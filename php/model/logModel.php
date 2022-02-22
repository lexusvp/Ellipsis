<?php
   //== REMINDER: Source des logs erreurs / visiteurs => "Vazn"
   function createLog($type, $pseudo, $description = NULL) { 
      $database = connect(); 
      $now = date("y-m-d H:i:s", time());

      $userInsert = "INSERT INTO logs (type_log, datetime_log, info_log, id_user)
      VALUES (:type, :datetime, :description, (SELECT id_user FROM users WHERE pseudo_user = :pseudo)); 
      ";
      
      try {
         $query = $database->prepare($userInsert);
         $success = $query->execute(array(
            ":type" => $type,
            ":datetime" => $now,
            ":description" => $description,
            ":pseudo" => $pseudo
         ));   
      } catch (PDOException $e) {
         fileLog("LOG CREATION : " . json_encode($e) . "\n");
      }

      return $success;   
   }

   function countUsers() {
      $database = connect(); 
      $query = "SELECT COUNT(id_user) FROM users"; 

      try {
         $query = $database->prepare($query);
         $query->execute();

      } catch (PDOException $e) {
         errorLog("LOG READ", $e);
      }
      return $query;
   }

   function getAllConnections() {
      $database = connect(); 
      $query = 
      "  SELECT pseudo_user, type_log, datetime_log FROM logs 
         JOIN users
         WHERE logs.id_user = users.id_user
         AND type_log LIKE CONCAT(:arg, '%')

         ORDER BY datetime_log ASC;
      "; 

      try {
         $query = $database->prepare($query);
         $query->execute(array(
            ":arg" => "Log"
         ));
      } catch (PDOException $e) {
         errorLog("LOG READ", $e);
      }
      return $query;
   }
   function getAllErrors() {
      $database = connect(); 
      $query = 
      "  SELECT  info_log, datetime_log FROM logs 
         WHERE type_log = :arg

         ORDER BY datetime_log ASC;
      ";

      try {
         $query = $database->prepare($query);
         $query->execute(array(
            ":arg" => "Error"
         ));
      } catch (PDOException $e) {
         errorLog("LOG READ", $e);
      }
      return $query;
   }

   function getDataPoints($query, $args) {
      $database = connect(); 

      try {
         $query = $database->prepare($query);
         $query->execute($args);
      } catch (PDOException $e) {
         errorLog("LOG READ", $e);
      }
      return $query;
   }
?>