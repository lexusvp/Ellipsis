<?php
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

      echo json_encode($userData);
   } 
   else if ($_GET["type"] === "logoutUser") {
      createLog("Logout", $_SESSION["pseudo"]);

      session_destroy();
   }
   else if ($_GET["type"] === "updateUser" && $updateCondition) {}  //== TODO 

   //=====================>> MESSAGES BRANCHES <<=======================//

   else if ($_GET["type"] === "createMessage" && $createMessageCondition) {   
      createMessage($_SESSION["pseudo"]);

      //== TODO: If admin, send receiver pseudo to server somehow (chat tabs clicks store pseudo ?)

      echo 0;
   } 
   else if ($_GET["type"] === "readMessage") {
      $messageHistory = readMessage($_SESSION["pseudo"]);
      $arr = $messageHistory->fetchAll(PDO::FETCH_ASSOC);

      echo json_encode($arr);
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


?>