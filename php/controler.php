<?php
   //== TODO : Sanitize inputs
   //== TODO : WHitelist inputs HERE
   
   require './model/connect.php';
   require './model/userModel.php';
   require './model/messageModel.php';
   require './model/logModel.php';

   require './helpers.php';
   session_start();

   $regCondition = (
      isset($_POST['pseudo']) && 
      isset($_POST['password']) &&
      isset($_POST['email'])
   );   
   $logCondition = (
      isset($_POST['email']) && 
      isset($_POST['password'])
   );   
   $createMessageCondition = (
      isset($_POST['message']) 
   );

   //======================>> USER BRANCHES <<============================//

   if ($_GET["type"] === "registerUser" && $regCondition) {
      $test = availableCheck();

      if ($test["check_success"]) {
         createUser();
         createLog("Registration", $_POST["pseudo"]);
      }
      echo json_encode($test);
   }
   else if ($_GET["type"] === "loginUser" && $logCondition) {      
      echo json_encode(connectUser());          //== NOTE: Non-sensitive data
   } 
   else if ($_GET["type"] === "logoutUser") {
      $_SESSION["logged"] = false;
      createLog("Logout", $_SESSION["pseudo"]);

      echo 0;
   }
   else if ($_GET["type"] === "updateUser" && $updateCondition) {}  //== TODO 

   //=====================>> MESSAGES BRANCHES <<=======================//

   else if ($_GET["type"] === "createMessage" && $createMessageCondition) {   
      if ($_SESSION["admin"] && isset($_GET["target"])) {
         createMessage($_GET["target"], $_SESSION["admin"]);
      } else {
         createMessage($_SESSION["pseudo"]);
      }
      echo 0;
   } 
   else if ($_GET["type"] === "readMessage") {
      if ($_SESSION["admin"]) {
         $response = readMessage($_SESSION["pseudo"], true);    
      } else {
         $response = readMessage($_SESSION["pseudo"]);
      } 
      $messageHistory = $response->fetchAll(PDO::FETCH_ASSOC);
      $messageHistory = formatConversations($messageHistory);
      
      echo json_encode($messageHistory);
   } 
   else if ($_GET["type"] === "closeConversation" && isset($_GET["target"])) {
      if ($_SESSION["admin"]) {
         $closed = closeConversation($_GET["target"]);

         echo json_encode($closed === 1);
      }
   }

   //=====================>> DASHBOARD BRANCHES <<=======================//

   else if ($_GET["type"] === "getData" && isset($_GET["target"])) {
      if ($_SESSION["admin"]) {
         fileLog(json_encode(getData($_GET["target"])->fetchAll(PDO::FETCH_ASSOC)));
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