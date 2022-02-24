<?php
   function createUser($pseudo, $email, $password) { 
      $database = connect(); 
      $userInsert = "INSERT INTO users (pseudo_user, email_user, pw_user)
      VALUES (
         :pseudo, 
         :email, 
         :pw); 
      ";

      try {
         $query = $database->prepare($userInsert);
         $success = $query->execute(array(
            ":pseudo" => $pseudo,
            ":email" => $email,
            ":pw" => $password,
         )); 
      } catch (PDOException $e) {
         errorLog("USER CREATION " . $e);
      }

      return $success;
   }  
   function readUser($email) {
      $database = connect(); 
      $connectionCheck = "SELECT pw_user, pseudo_user, admin_user FROM users WHERE email_user = :email";
      
      try {
         $query = $database->prepare($connectionCheck);
         $query->execute(array(
            ":email" => $email    
         ));    
 
      } catch (PDOException $e) {
         errorLog("USER CONNECTION " . $e);
      }

      return $query;
   }


   function updateUser($currentPseudo) {
      $database = connect(); 

      $userUpdate = 
      "
      UPDATE users (pseudo_user, pw_user, email_user)
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
   function deleteUser($currentPseudo) {
      $database = connect();  
      $query = 
      '  
      START TRANSACTION;

      UPDATE logs, messages
      SET logs.id_user = NULL,
          messages.id_user = NULL
      WHERE
          logs.id_user = (SELECT id_user from users WHERE pseudo_user = :pseudo)
      AND 
         messages.id_user = (SELECT id_user from users WHERE pseudo_user = :pseudo);
          
      DELETE FROM users WHERE pseudo_user = :pseudo;

      COMMIT;
      ';
      
      try {
         $query = $database->prepare($query);
         $success = $query->execute(array(
            ":pseudo" => $currentPseudo    
         ));     
      } catch (PDOException $e) {
         errorLog("USER REMOVAL " . $e);
      }

      return $success;
   }   

   function checkPseudo($pseudo) {  // Retourne true si pseudo dispo
      $database = connect(); 
      $checkPseudo = 'SELECT * FROM users WHERE pseudo_user = :pseudo';
      
      $query = $database->prepare($checkPseudo);
      $query->execute(array(
         ":pseudo" => $pseudo
      ));     
      $result = $query->fetch();

      return !is_array($result);
   }
   function checkMail($email) {    // Retourne true si mail dispo
      $database = connect(); 
      $checkMail = 'SELECT * FROM users WHERE email_user = :mail';

      $query = $database->prepare($checkMail);
      $query->execute(array(
         ":mail" => $email
      ));
      $result = $query->fetch();

      return !is_array($result);
   }
?>


