<?php

   //== TODO : Sanitize inputs
   
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

   if ($_GET["type"] === "authorize" && isset($_SESSION["admin"])) {
      echo json_encode($_SESSION["admin"]);
   }

   //======================>> USER BRANCHES <<============================//

   else if ($_GET["type"] === "registerUser" && $regCondition) {
      $test = availableCheck();

      if ($test["check_success"]) {
         createUser();
         createLog("Registration", $_POST["pseudo"]);
      }
      echo json_encode($test);
   }
   else if ($_GET["type"] === "loginUser" && $logCondition) {
      $userData = connectUser();             //== NOTE: Non-sensitive data
      fileLog(json_encode($userData));
      echo json_encode($userData);
   } 
   else if ($_GET["type"] === "logoutUser") {
      $_SESSION["logged"] = false;
      createLog("Logout", $_SESSION["pseudo"]);

      session_destroy();
   }
   else if ($_GET["type"] === "updateUser" && $updateCondition) {}  //== TODO 

   //=====================>> MESSAGES BRANCHES <<=======================//

   else if ($_GET["type"] === "createMessage" && $createMessageCondition) {   

      $pseudoCible = "?!!";

      if ($_SESSION["admin"]) {
         createMessage($pseudoCible, $_SESSION["admin"]);
      } else {
         createMessage($_SESSION["pseudo"]);
      }

      //== TODO: If admin, send receiver pseudo to server somehow (chat tabs clicks store pseudo ?)

      echo 0;
   } 
   else if ($_GET["type"] === "readMessage") {

      $messageHistory = null;

      if ($_SESSION["admin"]) {
         $response = readMessage($_SESSION["pseudo"], $_SESSION["admin"]);
         $messageHistory = $response->fetchAll(PDO::FETCH_ASSOC);

         $messageHistory = formatAdminConversations($messageHistory);
      } else {
         $response = readMessage($_SESSION["pseudo"]);
         $arr = $response->fetchAll(PDO::FETCH_ASSOC);
      }


      echo json_encode($messageHistory);
   }
  

   function formatAdminConversations($messageHistory) {
      $arr = array();

      foreach ($messageHistory as $message){
         $currentPseudo = $message["pseudo_user"];

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
         fileLog("\n USER DUPLICATE CHECK : " . json_encode($e));
      }

      if ($arr["pseudo"] && $arr["email"]) $arr["check_success"] = True;
      else $arr["check_success"] = False;

      return $arr;
   }

   function sanitizeData() {
      //== Enough ?
      foreach ($_POST as $key => $value){
         $_POST[$key] = htmlspecialchars(strip_tags($value));
         fileLog($_POST[$key]);
      }
   }
?>