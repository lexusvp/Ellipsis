<?php
   include './connectionModule.php';

   //========================>> USER QUERIES <<========================//

   function createUser() {
      $condition = (
         !empty($_POST['user_name']) && 
         !empty($_POST['user_firstname']) &&
         !empty($_POST['user_firstname']) &&
         !empty($_POST['user_mdp'])
      );   

      if ($condition) {
         $userInsert = "INSERT INTO users SET 
         user_name = :user_name, 
         user_firstname = :user_firstname, 
         user_login = :user_login, 
         user_mdp = :user_mdp
         ";
         $response = queryDatabase($userInsert, array(
         ':user_name' => $_POST['user_name'],
         ':user_firstname' => $_POST['user_firstname'],
         ':user_login' => $_POST['user_login'],
         ':user_mdp' => $_POST['user_mdp'],
         ));
         return $response[0];
      }  
   }  
   function checkUser() {}
   function updateUser() {}

   //=======================>> MESSAGE QUERIES <<=====================//

   function createMessage() {}

   //=========================>> LOG QUERIES <<======================//

   function createLog() {}

?>


