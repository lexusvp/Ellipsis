<?php
   require './model/connect.php';
   require './model/userModel.php';
   require './model/messageModel.php';
   require './model/logModel.php';

   require './helpers.php';

   $regCondition = (
      isset($_POST['pseudo']) && 
      isset($_POST['password']) &&
      isset($_POST['email'])
   );   
   $logCondition = (
      isset($_POST['email']) && 
      isset($_POST['password'])
   );   
   
   if ($_GET["type"] === "registerUser" && $regCondition) {
      
      $_POST['password'] = password_hash($_POST['password'], PASSWORD_ARGON2I);

      $test = availableCheck();
      if ($test["check_success"]) {
         createUser();
         createLog("Registration", $_POST["pseudo"]);
      }

      echo json_encode($test);
   }
   else if ($_GET["type"] === "loginUser" && $logCondition) {
      $userData = connectUser();                            //== NOTE: Non-sensitive data

      echo json_encode($userData);
   } else if ($_GET["type"] === "logoutUser") {
      session_destroy();
   }
   else if ($_GET["type"] === "updateUser" && $updateCondition) {

   }   

   // else if ($_GET["type"] === "createMessage" && $messageCondition) {   
   //    createMessage();
   // } 
   // else if ($_GET["type"] === "readMessage" && $readCondition) {
   //    readMessage();
   // }
  
   function connectUser() {
      $query = readUser();
      $result = $query->fetch();    // Retourn tableau si ok      

      if ($result[2] === "0") $result[2] = False;
      else $result[2] = True;

      $data = [];
      if (is_array($result)) {
         if (password_verify($_POST["password"], $result[0])) {
            session_start();

            $data["pseudo"] = $result[1];
            $data["admin"] = $result[2];
            $data["logged"] = True;

            $_SESSION["pseudo"] = $result[1];
            $_SESSION["admin"] = $result[2];

            createLog("Login", $_SESSION["pseudo"]);
         }
      } else {
         $data["logged"] = False;
      }

      return $data;
   }
   function availableCheck() {
      $arr = [];
      $arr["pseudo"] = checkPseudo();
      $arr["email"] = checkMail();

      if ($arr["pseudo"] && $arr["email"]) $arr["check_success"] = True;
      else $arr["check_success"] = False;

      return $arr;
   }


?>