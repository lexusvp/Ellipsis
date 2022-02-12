<?php
   require './model/connect.php';
   require './model/userModel.php';
   require './model/messageModel.php';

   require './helpers.php';
   
   $regCondition = (
      isset($_POST['login']) && 
      isset($_POST['password']) &&
      isset($_POST['email'])
   );   
   $logCondition = (
      isset($_POST['email']) && 
      isset($_POST['password'])
   );   
   
   if ($_GET["type"] === "register" && $regCondition) {
      $failedConstraints = registerUser();
      echo json_encode($failedConstraints);
   }

   else if ($_GET["type"] === "login" && $logCondition) {
      $userData = connectUser();                            //== NOTE: Non-sensitive
      echo json_encode($userData);
   }

   // else if ($_GET["type"] === "updateUser" && $updateCondition) {    
   //    updateUser();
   // }   
   // else if ($_GET["type"] === "createMessage" && $messageCondition) {   
   //    createMessage();
   // } 
   // else if ($_GET["type"] === "readMessage" && $readCondition) {
   //    readMessage();
   // }
   // else if ($_GET["type"] === "log" && $logCondition) {
   //    createLog();
   // }

   function connectUser() {
      $query = readUser();
      $result = $query->fetch();    // Retourn tableau si ok      
 
      $data = [];
      if (is_array($result)) {
         if (password_verify($_POST["password"], $result[1])) {
            $data["check_success"] = True;
            $data["pseudo_user"] = $result[0];
         }
      } else {
         $data["check_success"] = False;
      }

      return $data;
   }
   function registerUser() {
      $arr = [];
      $arr["login_check"] = checkPseudo();
      $arr["email_check"] = checkMail();

      $_POST['password'] = password_hash($_POST['password'], PASSWORD_ARGON2I);
      if ($arr["login_check"] && $arr["email_check"]) {
         $arr["check_success"] = True;
         createUser();
      } else $arr["check_success"] = False;

      return $arr;
   }

?>