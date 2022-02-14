<?php

   //== NOTE : Comment gérér les logs des visiteurs et des erreurs ? pseudo_user comme unique source de logs pas ouf
   function createLog($type, $pseudo) { 
      $database = connect(); 
      $timestamp = getTimestamp();

      $userInsert = "INSERT INTO logs (type_log, timestamp_log, id_user)
      VALUES (:type, :timestamp, (SELECT id_user FROM users WHERE pseudo_user = :pseudo)); 
      ";
      
      try {
         fileLog("test1");

         $query = $database->prepare($userInsert);
         $success = $query->execute(array(
            ":type" => $type,
            ":timestamp" => $timestamp,
            ":pseudo" => $pseudo
         ));   
         fileLog("test2"); 
      } catch (PDOException $e) {
         fileLog("LOG CREATION : " . json_encode($e) . "\n");
      }

      return $success;   
   }

   function getData($type) {
      $database = connect(); 

      $getLoginLogout = "SELECT pseudo_user, type_log, timestamp_log FROM logs 
         JOIN users
         WHERE logs.id_user = users.id_user
         AND (type_log = 'Login' OR type_log = 'Logout')

         ORDER BY timestamp_log ASC;
      ";

      $getData = "SELECT pseudo_user, type_log, timestamp_log FROM logs 
         JOIN users
         WHERE logs.id_user = users.id_user
         AND type_log = :type

         ORDER BY timestamp_log ASC;
      ";

      try {
         $query = $database->prepare($getData);
         $success = $query->execute(array(
            ":type" => $type
         ));    
      } catch (PDOException $e) {
         fileLog("LOG CREATION : " . json_encode($e) . "\n");
      }

   }
   function getConnectionData() {
      $database = connect(); 

      $userInsert = "SELECT INTO logs (type_log, timestamp_log, id_user)
      VALUES (:type, :timestamp, (SELECT id_user FROM users WHERE pseudo_user = :pseudo)); 
      ";
   }

?>