<?php

//== NOTE : Comment gérér les logs des visiteurs et des erreurs ? pseudo_user comme unique source de logs pas ouf
function createLog($type, $pseudo) { 
      $database = connect(); 
      $timestamp = getTimestamp();

      $userInsert = "INSERT INTO logs (type_log, timestamp_log, id_user)
      VALUES (:type, :timestamp, (SELECT id_user FROM users WHERE pseudo_user = :pseudo)); 
      ";
      
      try {
         $query = $database->prepare($userInsert);
         $success = $query->execute(array(
            ":type" => $type,
            ":timestamp" => $timestamp,
            ":pseudo" => $pseudo
         ));    
      } catch (PDOException $e) {
         fileLog("LOG CREATION : " . json_encode($e) . "\n");
      }

      return $success;   
   }

?>