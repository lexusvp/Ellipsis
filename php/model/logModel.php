<?php

   //== REMINDER: Source des logs erreurs / visiteurs => "Vazn"
   function createLog($type, $pseudo, $description = NULL) { 
      $database = connect(); 
      $timestamp = getTimestamp();

      $userInsert = "INSERT INTO logs (type_log, timestamp_log, info_log, id_user)
      VALUES (:type, :timestamp, :description, (SELECT id_user FROM users WHERE pseudo_user = :pseudo)); 
      ";
      
      try {
         $query = $database->prepare($userInsert);
         $success = $query->execute(array(
            ":type" => $type,
            ":timestamp" => $timestamp,
            ":description" => $description,
            ":pseudo" => $pseudo
         ));   
      } catch (PDOException $e) {
         fileLog("LOG CREATION : " . json_encode($e) . "\n");
      }

      return $success;   
   }

   function getData($type) {
      $database = connect(); 
      $query = "";
      $arg = "";

      if ($type === "countUsers"){
         $query = "SELECT COUNT(id_user) FROM users"; 
      }
      else if ($type === "countRegistrations") {
         $query = 
         "  SELECT COUNT(type_log) FROM logs 
            WHERE type_log = :arg
         "; 
         $arg = $type;
      } else if ($type === "allConnexions"){
         $query = 
         "  SELECT pseudo_user, type_log, timestamp_log FROM logs 
            JOIN users
            WHERE logs.id_user = users.id_user
            AND type_log LIKE CONCAT('%', :arg)

            ORDER BY timestamp_log ASC;
         "; 
      } else if ($type === "errors") {
         $query = 
         "  SELECT  info_log, timestamp_log FROM logs 
            WHERE type_log = :arg

            ORDER BY timestamp_log ASC;
         ";
      }

      try {
         $query = $database->prepare($query);
         $query->execute(array(
            ":arg" => $arg
         ));
      } catch (PDOException $e) {
         errorLog("LOG READ", $e);
      }

      return $query;
   }

?>