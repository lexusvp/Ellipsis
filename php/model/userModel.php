<?php

   function createUser() { 
      $database = connect(); 
      $userInsert = "INSERT INTO users (pseudo_user, pw_user, email_user)
      VALUES (
         :pseudo, 
         :pw, 
         :email); 
      ";
      $_POST['password'] = password_hash($_POST['password'], PASSWORD_ARGON2I);

      try {
         $query = $database->prepare($userInsert);
         $success = $query->execute(array(
            ":pseudo" => $_POST['pseudo'],
            ":pw" => $_POST['password'],
            ":email" => $_POST['email'],
         )); 
      } catch (PDOException $e) {
         fileLog("USER CREATION : " . json_encode($e) . "\n");
      }

      return $success;
   }  
   function readUser() {
      $database = connect(); 
      $connectionCheck = "SELECT pw_user, pseudo_user, admin_user FROM users WHERE email_user = :email";

      try {
         $query = $database->prepare($connectionCheck);
         $query->execute(array(
            ":email" => $_POST['email']      
         ));     
      } catch (PDOException $e) {
         fileLog("USER READ : " . json_encode($e) . "\n");
      }

      return $query;
   }
   function updateUser($currentPseudo) {
      $database = connect(); 

      $userUpdate = "UPDATE users (pseudo_user, pw_user, email_user)
      VALUES (:pseudo, :pw, :email)
      WHERE pseudo_user = $currentPseudo; 
      ";
      $query = $database->prepare($userUpdate);
      
      $success = $query->execute(array(
         ":pseudo" => $_POST["pseudo"],
         ":pw" => $_POST["password"],
         ":email" => $_POST["email"]
      ));

      return $success;
   }
   function deleteUser() {}

   function closeConversation($target) {
      $database = connect(); 

      $closeConv = 
      "  UPDATE users 
         SET conversation_user = 0
         WHERE pseudo_user = :target; 
      ";

      try {
         $query = $database->prepare($closeConv);
         $query->execute(array(
            ":target" => $target
         ));   
      } catch (PDOException $e) {
         fileLog("CONVERSATION CLOSE : " . json_encode($e) . "\n");
      }
      
      return $query->rowCount();
   }
   



   function checkPseudo() {  // Retourne true si pseudo dispo
      $database = connect(); 
      $checkPseudo = 'SELECT * FROM users WHERE pseudo_user = :pseudo';
      
      $query = $database->prepare($checkPseudo);
      $query->execute(array(
         ":pseudo" => $_POST['pseudo']
      ));     
      $result = $query->fetch();

      return !is_array($result);
   }
   function checkMail() {    // Retourne true si mail dispo
      $database = connect(); 
      $checkMail = 'SELECT * FROM users WHERE email_user = :mail';

      $query = $database->prepare($checkMail);
      $query->execute(array(
         ":mail" => $_POST['email']
      ));
      $result = $query->fetch();

      return !is_array($result);
   }

?>


