<?php
   session_start();
   date_default_timezone_set('Europe/Paris');

   require '../helpers.php';
   require '../model/userModel.php';
   require '../model/logModel.php';

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
   $updateCondition = ($_GET["type"] === "updateUser");
   $logoutCondition = ($_GET["type"] === "logoutUser");
   $deleteCondition = ($_GET["type"] === "deleteUser");
   
   if ($regCondition) {
      $test = availableCheck($_POST["pseudo"], $_POST["email"]);
      
      if ($test["success"]) {
         $password = password_hash($_POST['password'], PASSWORD_ARGON2I);

         createUser($_POST["pseudo"], $_POST["email"], $password);
         createLog("Registration", $_POST["pseudo"]);
      }
      echo json_encode($test);
   }
   else if ($loginCondition) {   

      $clientData = connectionProtocol($_POST['email'], $_POST['password']);
      echo json_encode($clientData);
   } 
   else if ($logged) {
      if ($logoutCondition) {
         createLog("Logout", $_SESSION["pseudo"]);
         session_destroy();
   
         echo json_encode(["success" => true]);
      }
      else if ($updateCondition) {

         $success = updateProtocol($_SESSION['email'], $_POST['current_password']);

         echo json_encode($success);
      }
      else if ($deleteCondition) {
         $success = deleteUser($_SESSION["pseudo"]);
   
         if ($success) {
            session_destroy();
            echo json_encode(["success" => true]);
         } else {
            echo json_encode(["success" => false]);
         }
      }
      else {
         errorLog("User controler was unable to parse the request !");
         json_encode(["success" => false]);
      }
   }
   else {
      errorLog("User controler was unable to parse the request !");
      json_encode(["success" => false]);
   }

   function connectionProtocol($email, $password) {  
      $query = readUser($email);
      $answer = $query->fetch();   

      $success = authorize($answer, $password);
      if ($success) {
         $data = [];
         $answer[3] = !($answer[3] === "0");        // BDD retourne une chaine pour le booleen
         
         $data["pseudo"] = $answer[1];
         $data["admin"] = $answer[3];
         $data["logged"] = True;
         
         $_SESSION["pseudo"] = $answer[1];
         $_SESSION["email"] = $answer[2];
         $_SESSION["admin"] = $answer[3];
         $_SESSION["logged"] = True;
         
         createLog("Login", $_SESSION["pseudo"]);
      }  else {
         $data["logged"] = False;
      }
      return $data;
   }
   function updateProtocol($currentMail, $password) {
      $query = readUser($currentMail);
      $answer = $query->fetch();   

      $success = authorize($answer, $password);
      $arr = [];
      if ($success) {
         if ($_POST["pseudo"] === "") {
            $arr["pseudo"] = $_SESSION["pseudo"];
         }  else {
            if (checkPseudo($_POST["pseudo"])) {
               $arr["pseudo"] = $_POST["pseudo"];
            } else {
               $arr["pseudo"] = false;
            }
         }
         if ($_POST["email"] === "") { // validate
            $arr["email"] = $_SESSION["email"];
         } else {
            if (checkMail($_POST["email"])) {
               $arr["email"] = $_POST["email"];
            } else {
               $arr["email"] = false;
            }
         }
         if ($_POST["password"] === "") {
            $arr["password"] = password_hash($_POST["current_password"], PASSWORD_ARGON2I);
         } else {
            if ("ValidPassword") {  // TODO
               $arr["password"] = $_POST["password"];
            } else {
               $arr["password"] = false;
            }
         }
         foreach ($arr as $credential) {
            if ($credential === false) {
               foreach ($arr as &$credential) {
                  if ($credential !== false) {
                     $credential = true;
                  }
               }
               return $arr;
            }
         }

         // updateUser($currentMail, $arr["pseudo"], $arr["email"], $arr["password"]);
         return ["success" => true];         
      } else {
         return ["success" => false];
      }
   }


   function authorize($answer, $password) {
      if (is_array($answer)) {
         if (password_verify($password, $answer[0])) {
            return true;
         }
         return false;
      }
      return false;
   }
   function availableCheck($pseudo, $email) {
      $arr = [];

      try {
         $arr["pseudo"] = checkPseudo($pseudo);
         $arr["email"] = checkMail($email);  
      } catch (PDOException $e) {
         errorLog("USER DUPLICATE CHECK", $e);
      }

      if ($arr["pseudo"] && $arr["email"]) $arr["success"] = True;
      else $arr["success"] = False;

      return $arr;
   }
?>