<?php
   session_start();
   date_default_timezone_set('Europe/Paris');

   //== TODO : Sanitize inputs
   //== TODO : Whitelist inputs HERE
   
   require './model/connect.php';
   require './model/userModel.php';
   require './model/messageModel.php';
   require './model/logModel.php';
   require './helpers.php';

   $regCondition = (
      $_GET["type"] === "registerUser" &&
      isset($_POST['pseudo']) && 
      isset($_POST['password']) &&
      isset($_POST['email'])
   );   
   $loginCondition = (
      $_GET["type"] === "loginUser" &&
      isset($_POST['email']) && 
      isset($_POST['password'])
   ); 
   
   //======= LOGGED ONLY FEATURES =========//
   $logged = (
      isset($_SESSION["logged"]) &&
      $_SESSION["logged"]
   );
   $logoutCondition = ($logged && $_GET["type"] === "logoutUser");
   $updateCondition = ($logged && $_GET["type"] === "updateUser");
   $deleteCondition = ($logged && $_GET["type"] === "deleteUser");

   $readMessageCondition = ($loggedCondition && $_GET["type"] === "readMessage");
   $createMessageCondition = (
      $loggedCondition &&      
      $_GET["type"] === "createMessage" &&
      isset($_POST['message']) 
   );

   //======= ADMIN ONLY FEATURES =========//
   $admin = (
      isset($_SESSION["admin"]) &&
      $_SESSION["admin"]
   );
   $closeConversationCondition = (
      $admin &&
      $_GET["type"] === "closeConversation" && 
      isset($_GET["target"])
   );
   $getDataCondition = (
      $admin &&
      $_GET["type"] === "getData" && 
      isset($_GET["target"])
   );

   //======================>> USER <<============================//

   if ($regCondition) {
      $test = availableCheck();

      if ($test["check_success"]) {
         createUser();
         createLog("Registration", $_POST["pseudo"]);
      }
      echo json_encode($test);
   }
   else if ($loginCondition) {      
      echo json_encode(connectUser());
   } 

   else if ($logoutCondition) {
      $_SESSION["logged"] = false;
      createLog("Logout", $_SESSION["pseudo"]);
   }
   else if ($updateCondition) {}  //== TODO 
   else if ($deleteCondition) {}  //== TODO 

   //=====================>> MESSAGES <<=======================//

   else if ($createMessageCondition) {   
      if ($admin && isset($_GET["target"])) {
         createMessage($_GET["target"], $_SESSION["admin"]);
      } else {
         createMessage($_SESSION["pseudo"]);
      }
      echo 0;
   } 
   else if ($readMessageCondition) {
      if ($admin) {
         $response = readMessage($_SESSION["pseudo"], true);    
      } else {
         $response = readMessage($_SESSION["pseudo"]);
      } 
      $messageHistory = $response->fetchAll(PDO::FETCH_ASSOC);
      $messageHistory = json_encode(formatConversations($messageHistory));
      
      echo $messageHistory;
   } 
   else if ($closeConversationCondition) {
      if ($admin) {
         $closed = closeConversation($_GET["target"]);

         echo json_encode($closed === 1);
      }
   }

   //=====================>> DASHBOARD <<=======================//

   else if ($getDataCondition) {
      if (isset($_GET["resolution"]) && isset($_GET["range"])) {
         $dataNeeded = getData($_GET["target"], $_GET["resolution"], $_GET["range"]);
      } else {
         $dataNeeded = getData($_GET["target"]);
      }
      echo json_encode($dataNeeded);
   } else {
      echo json_encode("You're not allowed to do this, i'm watching you.");
   }

   //== TODO: FIND MORE &!@!*? DATA !!!
   function getData($target, $resolution = null, $range = null) {

      if ($target === "userCount") {       
         return countUsers()->fetchAll(PDO::FETCH_NUM);
      }  else if ($target === "messageCount") {
         return countMessages()->fetchAll(PDO::FETCH_NUM);
      }  else if ($target === "allErrors") {

         return getAllErrors()->fetchAll(PDO::FETCH_NUM);; 
      }   

      else if ($target === "logins") {
         [$query, $bindArgs] = buildDataQuery("Login", $resolution, $range);
         $answer = getDataPoints($query, $bindArgs)->fetchAll(PDO::FETCH_NUM);

         return formatData($answer, $bindArgs, $range, $resolution);
      }
      else if ($target === "register") {
         [$query, $bindArgs] = buildDataQuery("Reg", $resolution, $range);
         $answer = getDataPoints($query, $bindArgs)->fetchAll(PDO::FETCH_NUM);

         return formatData($answer, $bindArgs, $range, $resolution);
      }

   }
   function buildDataQuery($target, $resolution, $range) {
      //== NOTE: Construit une query pour une résolution et une intervalle donnée, sur le type de log "target"

      $intervalNb = $range + 1;
      $bindArgs = array();

      // Construit les binds nécessaires sur l'intervalle donnée
      // Plus vieux indexé à zéro, plus récent à intervalNb
      for ($i=$intervalNb ; $i>0 ; $i--) {
         $bound = "";
         if ($resolution === "Hourly") {
            $bound = date("Y-m-d H:0:0", strtotime("-" . $i . " hour"));
         } else if ($resolution === "Daily") {
            $bound = date("Y-m-d 08:00:00", strtotime("-" . $i . " day"));
         } else if ($resolution === "Weekly") {
            $bound = date("Y-m-d 08:00:00", strtotime("-" . $i . " week"));
         }
         $bindArgs[":". ($intervalNb - $i)] = $bound;
      }
      $bindArgs[":type"] = $target;    
      
      // Formatte la requête nécessaire sur l'intervalle donnée
      $start = "SELECT * FROM (SELECT CASE";
      $queryIntervals = "";
      for ($i = 0 ; $i < $range ; $i ++) {
         $queryIntervals .= 
         " WHEN datetime_log BETWEEN :" . $i . " AND :" . ($i + 1) . " THEN " . $i;
      }    
      $end = 
         "  END as `Interval`, COUNT(1) as `Amount`
         FROM logs
         JOIN logs_type ON logs_type.id_log_type = logs.id_log_type
         WHERE name_log_type LIKE CONCAT(:type, '%')
         GROUP BY `Interval`
         )  AS `Data`
         WHERE `Interval` IS NOT NULL
         ORDER BY `Interval` ASC;
         ";
      $query = $start.$queryIntervals.$end;

      return [$query, $bindArgs];
   }
   function formatData($answer, $bindArgs, $range, $resolution) {
      //== Prend le tableau retourné par la BDD et le transforme en associatif [Intervalle de temps => Donnée]

      $numericArr = new SplFixedArray($range);
      $finalArr = array();

      for ($i=0 ; $i<count($numericArr); $i++) {
         if (isset($answer[$i][0])) {
            $indexToPush = intval($answer[$i][0]); 
            $numericArr[$indexToPush] = intval($answer[$i][1]);      
         }

         $formatedIndex = "";
         if ($resolution === "Hourly") {
            $datetime = $bindArgs[":".$i];
            $formatedIndex = date("H:00:00", strtotime($datetime));
         } else if ($resolution === "Daily") {
            $datetime = $bindArgs[":".$i];
            $formatedIndex = date("d/m", strtotime($datetime));
         } else if ($resolution === "Weekly") {
            $datetime = $bindArgs[":".$i];
            $formatedIndex = date("d/m/Y", strtotime($datetime));
         }

         $amount = $numericArr[$i];      // Remplace les champs null par zéro
         if ($amount === null) {
            $amount = 0;
         }
         $finalArr[$formatedIndex] = $amount;
      }
      return $finalArr;
   }


   function formatConversations($messageHistory) {
      $arr = array();

      foreach ($messageHistory as $message){
         if ($_SESSION["admin"] === false) {
            $currentPseudo = "Admin - Vazn";
         } else {
            $currentPseudo = $message["pseudo_user"];
         }

         // Crée une clé par pseudo, et push tout les messages correspondant au pseudo correspondant.         
         $arr[$currentPseudo][] = $message;
      }

      return $arr;
   }
   function connectUser() {
      $query = readUser();
      $result = $query->fetch();    // Retourn tableau si ok      
      $data = [];

      if ($result[2] === "0") $result[2] = False;     // BDD retourn une chaine pour le booleen
      else $result[2] = True;

      if (is_array($result)) {
         if (password_verify($_POST["password"], $result[0])) {

            $data["pseudo"] = $result[1];
            $data["admin"] = $result[2];
            $data["logged"] = True;

            $_SESSION["pseudo"] = $result[1];
            $_SESSION["admin"] = $result[2];
            $_SESSION["logged"] = True;

            createLog("Login", $_SESSION["pseudo"]);
         }
      } else {
         $data["logged"] = False;
      }

      return $data;
   }
   function availableCheck() {
      $arr = [];

      try {
         $arr["pseudo"] = checkPseudo();
         $arr["email"] = checkMail();  
      } catch (PDOException $e) {
         errorLog("USER DUPLICATE CHECK", $e);
      }

      if ($arr["pseudo"] && $arr["email"]) $arr["check_success"] = True;
      else $arr["check_success"] = False;

      return $arr;
   }
   function sanitizeData() {
      //== Enough ?
      foreach ($_POST as $key => $value){
         $_POST[$key] = htmlspecialchars(strip_tags($value));
      }
   }

?>