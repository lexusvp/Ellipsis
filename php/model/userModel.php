<?php

   function createUser() { 
      $database = connect(); 

      $userInsert = "INSERT INTO users (login_user, pw_user, email_user)
      VALUES (:login, :pw, :email); 
      ";
      $query = $database->prepare($userInsert);

      $success = $query->execute(array(
         ":login" => $_POST['login'],
         ":pw" => $_POST['password'],
         ":email" => $_POST['email'],
      ));

      return $success;
   }  
   function readUser() {
      $database = connect(); 

      $connectionCheck = "SELECT login_user, pw_user FROM users 
      WHERE email_user = :email
      ";

      $query = $database->prepare($connectionCheck);

      $query->execute(array(
         ":email" => $_POST['email']      
      ));

      return $query;
   }
   function updateUser() {}
   function deleteUser() {}



   function checkPseudo() {  // Retourne true si pseudo dispo
      $database = connect(); 

      $checkPseudo = 'SELECT * FROM users WHERE login_user = :login';
      $query = $database->prepare($checkPseudo);
  
      $query->execute(array(
         ":login" => $_POST['login']
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


