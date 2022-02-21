<?php
   session_start();
   date_default_timezone_set('Europe/Paris');

   //== NOTE: 1 day to seconds => 86,400;
   //== NOTE: 1 week to seconds  => 604,800;
   //== NOTE: 1 month to seconds  => 2,629,746;  

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
   $logoutCondition = (
      $_SESSION["logged"] &&
      $_GET["type"] === "logoutUser"
   );
   $updateCondition = (
      $_SESSION["logged"] &&
      $_GET["type"] === "updateUser"
   );
   $deleteCondition = (
      $_SESSION["logged"] &&
      $_GET["type"] === "deleteUser"
   );

   $createMessageCondition = (
      $_SESSION["logged"] &&
      $_GET["type"] === "createMessage" &&
      isset($_POST['message']) 
   );
   $readMessageCondition = (
      $_SESSION["logged"] &&
      $_GET["type"] === "readMessage"
   );

   //======= ADMIN ONLY FEATURES =========//
   $closeConversationCondition = (
      $_SESSION["admin"] &&
      $_GET["type"] === "closeConversation" && 
      isset($_GET["target"])
   );
   $getDataCondition = (
      $_SESSION["admin"] &&
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
      echo json_encode(connectUser());          //== NOTE: Non-sensitive data
   } 

   else if ($logoutCondition) {
      $_SESSION["logged"] = false;
      createLog("Logout", $_SESSION["pseudo"]);

      echo 0;
   }
   else if ($updateCondition) {}  //== TODO 
   else if ($deleteCondition) {}  //== TODO 

   //=====================>> MESSAGES <<=======================//

   else if ($createMessageCondition) {   
      if ($_SESSION["admin"] && isset($_GET["target"])) {
         createMessage($_GET["target"], $_SESSION["admin"]);
      } else {
         createMessage($_SESSION["pseudo"]);
      }
      echo 0;
   } 
   else if ($readMessageCondition) {
      if ($_SESSION["admin"]) {
         $response = readMessage($_SESSION["pseudo"], true);    
      } else {
         $response = readMessage($_SESSION["pseudo"]);
      } 
      $messageHistory = $response->fetchAll(PDO::FETCH_ASSOC);
      $messageHistory = json_encode(formatConversations($messageHistory));
      
      echo $messageHistory;
   } 
   else if ($closeConversationCondition) {
      if ($_SESSION["admin"]) {
         $closed = closeConversation($_GET["target"]);

         echo json_encode($closed === 1);
      }
   }

   //=====================>> DASHBOARD <<=======================//

   else if ($getDataCondition) {
      if (isset($_GET["interval"])) {
         $dataNeeded = getData($_GET["target"], $_GET["interval"]);
      } else {
         $dataNeeded = getData($_GET["target"]);
      }
      echo json_encode($dataNeeded);
   } else {
      echo json_encode("You're not allowed to do this, i'm watching you.");
   }

   function getData($target, $interval = null) {

      if ($target === "countUsers") {
         return countUsers()->fetchAll(PDO::FETCH_NUM);
      }  else if ($target === "allErrors") {
         return getAllErrors()->fetchAll(PDO::FETCH_NUM);; 
      } 
      
      else if ($target === "logins") {
         $data = getDataWithinInterval($interval, "Login");
         return $data->fetchAll(PDO::FETCH_ASSOC);
      }
      else if ($target === "registrations") {
         $data = getDataWithinInterval($interval, "Registrations");
         return $data->fetchAll(PDO::FETCH_ASSOC);
      }
      else if ($target === "errors") {
         $data = getDataWithinInterval($interval, "Errors");
         return $data->fetchAll(PDO::FETCH_ASSOC);
      }

      else {
         return [];
      }
   }
   
   function getDataWithinInterval($interval, $type) {

      if ($interval === "hourly") {
         for ($i=0 ; $i<25 ; $i++) {
            $intervalStart = date("Y-m-d H:i:s", strtotime("-" . $i . " hour"));
            $arr[] = $intervalStart;
         }
         return getHourly(array_reverse($arr), $type);
      } else if ($interval === "daily") {
         for ($i=0 ; $i<8 ; $i++) {
            $intervalStart = date("Y-m-d", strtotime("-" . $i . " day"));
            $arr[] = $intervalStart;
         }
         return  getDaily(array_reverse($arr), $type);
      } else if ($interval === "weekly") {
         for ($i=0 ; $i<9 ; $i++) {
            $intervalStart = date("Y-m-d", strtotime("-" . $i . " week"));
            $arr[] = $intervalStart;
         }
         return getWeekly(array_reverse($arr), $type);
      }
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