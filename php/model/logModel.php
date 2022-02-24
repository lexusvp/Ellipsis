<?php
   //== REMINDER: Source des logs erreurs / visiteurs => "Vazn"
   function createLog($type, $pseudo, $description = NULL) { 
      $database = connect(); 
      $now = date("y-m-d H:i:s", time());

      $query = 
      "  INSERT INTO logs (datetime_log, info_log, id_log_type, id_user)
         VALUES (
            :datetime, 
            :description, 
            (SELECT id_log_type FROM logs_type WHERE name_log_type = :type), 
            (SELECT id_user FROM users WHERE pseudo_user = :pseudo)); 
      ";
      
      try {
         $query = $database->prepare($query);
         $success = $query->execute(array(
            ":type" => $type,
            ":datetime" => $now,
            ":description" => $description,
            ":pseudo" => $pseudo
         ));   
      } catch (PDOException $e) {
         fileLog("LOG CREATION : " . $e);
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
         errorLog("LOG READ " . $e);
      }
      return $query;
   }
   function countMessages() {
      $database = connect(); 
      $query = "SELECT COUNT(id_messages) FROM messages"; 

      try {
         $query = $database->prepare($query);
         $query->execute();

      } catch (PDOException $e) {
         errorLog("LOG READ " . $e);
      }
      return $query;
   }

   function getDataSince($type, $range) {
      $database = connect(); 
      $query = 
      "  SELECT  info_log, datetime_log FROM logs 

         JOIN logs_type
         ON logs_type.id_log_type = logs.id_log_type
         WHERE name_log_type = :type
         AND datetime_log >= :range
         ORDER BY datetime_log ASC;
      ";

      try {
         $query = $database->prepare($query);
         $query->execute(array(
            ":type" => $type,
            ":range" => $range,
         ));
      } catch (PDOException $e) {
         errorLog("LOG READ " . $e);
      }
      return $query;
   }
   function getDataIntervals($query, $args) {
      $database = connect(); 

      try {
         $query = $database->prepare($query);
         $query->execute($args);
      } catch (PDOException $e) {
         errorLog("LOG READ " . $e);
      }
      return $query;
   }
?>