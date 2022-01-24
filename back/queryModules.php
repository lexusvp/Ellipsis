<?php
   //========================>> USER QUERIES <<========================//
   //== TODO: Duplicates check, insertion working
   function createUser() { 
      $condition = (
         !empty($_POST['login']) && 
         !empty($_POST['password']) &&
         !empty($_POST['email'])
      );   
      if ($condition) {
         $userInsert = "INSERT INTO users SET 
         login_user = :login_user, 
         pw_user = :pw_user,
         email_user = :email_user 
         ";

         $response = queryDatabase($userInsert, array(
         ':login_user' => $_POST['login'],
         ':pw_user' => $_POST['password'],
         ':email_user' => $_POST['email'],
         ));
         return $response[0];
      }  
   }  
   function checkUser() {
      
   }

   function updateUser() {}

   //=======================>> MESSAGE QUERIES <<=====================//

   function createMessage() {}

   //=========================>> LOG QUERIES <<======================//

   function createLog() {}

?>


