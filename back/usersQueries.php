<?php
   include './queryHandler.php';

   function insertUsers() {
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
   function readUsers() {
      $userSelect = "SELECT * FROM users";
      $result = queryDatabase($userSelect);
      while ($donnees = $result[1]->fetch()) {
         echo $donnees['user_name'] . "/" .
              $donnees['user_firstname'] . "/" .
              $donnees['user_login'] . "/" .
              $donnees['user_mdp'];
      }  
   }

   if ($_GET["type"] === "select") {
      readUsers();
   } else if ($_GET["type"] === "insert") {
      insertUsers();
   }
?>


