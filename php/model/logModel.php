<?php

   //== TODO: Retourner des données journalières / hebdomadaires / mensuelles
   //== TODO: Générer "now", calculer les différents timestamp de l'intervalle souhaitée 
   //== TODO: et ensuite => ?

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
   function countRegistrations() {
      $database = connect(); 
      $query = 
      "  SELECT COUNT(type_log) FROM logs 
         WHERE type_log = :arg
      ";

      try {
         $query = $database->prepare($query);
         $query->execute(array(
            ":arg" => "Registration"
         ));
      } catch (PDOException $e) {
         errorLog("LOG READ", $e);
      }
      return $query;
   }

   
   function countLogins() {
      $database = connect(); 
      $query = 
      "  SELECT COUNT(type_log) FROM logs 
         WHERE type_log = :arg
      ";

      try {
         $query = $database->prepare($query);
         $query->execute(array(
            ":arg" => "Login"
         ));
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

   function getConnectionsOnInterval($arr) {
      $database = connect(); 
      $query = 
      "  SELECT 
         CASE 
         WHEN datetime_log BETWEEN :0 AND :1 THEN 'J-7'
         WHEN datetime_log BETWEEN :1 AND :2 THEN 'J-6'
         WHEN datetime_log BETWEEN :2 AND :3 THEN 'J-5'
         WHEN datetime_log BETWEEN :3 AND :4 THEN 'J-4'
         WHEN datetime_log BETWEEN :4 AND :5 THEN 'J-3'
         WHEN datetime_log BETWEEN :5 AND :6 THEN 'J-2'
         WHEN datetime_log BETWEEN :6 AND :7 THEN 'J-1'
         ELSE 'OTHERS'
         END as `Range`,
         COUNT(1) as `Amount`
         FROM logs
         GROUP BY `Range`;
      "; 

      try {
         $query = $database->prepare($query);
         $query->execute(array(
            ":0" => $arr[0], 
            ":1" => $arr[1],
            ":2" => $arr[2],
            ":3" => $arr[3],
            ":4" => $arr[4],
            ":5" => $arr[5],
            ":6" => $arr[6],
            ":7" => $arr[7]
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
?>