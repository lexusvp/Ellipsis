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

   function getHourly($bounds, $type) {
      $database = connect(); 
      $query = 
      "  SELECT 
         CASE 
         WHEN datetime_log BETWEEN :0 AND :1 THEN 'H - 24'
         WHEN datetime_log BETWEEN :1 AND :2 THEN 'H - 23'
         WHEN datetime_log BETWEEN :2 AND :3 THEN 'H - 22'
         WHEN datetime_log BETWEEN :3 AND :4 THEN 'H - 21'
         WHEN datetime_log BETWEEN :4 AND :5 THEN 'H - 20'
         WHEN datetime_log BETWEEN :5 AND :6 THEN 'H - 19'
         WHEN datetime_log BETWEEN :6 AND :7 THEN 'H - 18'
         WHEN datetime_log BETWEEN :7 AND :8 THEN 'H - 17'
         WHEN datetime_log BETWEEN :8 AND :9 THEN 'H - 16'
         WHEN datetime_log BETWEEN :9 AND :10 THEN 'H - 15'
         WHEN datetime_log BETWEEN :10 AND :11 THEN 'H - 14'
         WHEN datetime_log BETWEEN :11 AND :12 THEN 'H - 13'
         WHEN datetime_log BETWEEN :12 AND :13 THEN 'H - 12'
         WHEN datetime_log BETWEEN :13 AND :14 THEN 'H - 11'
         WHEN datetime_log BETWEEN :14 AND :15 THEN 'H - 10'
         WHEN datetime_log BETWEEN :15 AND :16 THEN 'H - 09'
         WHEN datetime_log BETWEEN :16 AND :17 THEN 'H - 08'
         WHEN datetime_log BETWEEN :17 AND :18 THEN 'H - 07'
         WHEN datetime_log BETWEEN :18 AND :19 THEN 'H - 06'
         WHEN datetime_log BETWEEN :19 AND :20 THEN 'H - 05'
         WHEN datetime_log BETWEEN :20 AND :21 THEN 'H - 04'
         WHEN datetime_log BETWEEN :21 AND :22 THEN 'H - 03'
         WHEN datetime_log BETWEEN :22 AND :23 THEN 'H - 02'
         WHEN datetime_log BETWEEN :23 AND :24 THEN 'H - 01'

         ELSE 'OTHERS'
         END as `Range`,
         COUNT(1) as `Amount`
         FROM logs

         WHERE type_log LIKE CONCAT(:type, '%')
         GROUP BY `Range`;
      "; 

      try {
         $query = $database->prepare($query);
         $query->execute(array(
            ":0" => $bounds[0], ":1" => $bounds[1],
            ":2" => $bounds[2], ":3" => $bounds[3],
            ":4" => $bounds[4], ":5" => $bounds[5],
            ":6" => $bounds[6], ":7" => $bounds[7],
            ":8" => $bounds[8], ":9" => $bounds[9],
            ":10" => $bounds[10], ":11" => $bounds[11],
            ":12" => $bounds[12], ":13" => $bounds[13],
            ":14" => $bounds[14], ":15" => $bounds[15],
            ":16" => $bounds[16], ":17" => $bounds[17],
            ":18" => $bounds[18], ":19" => $bounds[19],
            ":20" => $bounds[20], ":21" => $bounds[21],
            ":22" => $bounds[22], ":23" => $bounds[23],
            ":24" => $bounds[24], ":type" => $type 
         ));
      } catch (PDOException $e) {
         errorLog("LOG READ", $e);
      }
      return $query;
   }
   function getDaily($bounds, $type) {
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

         WHERE type_log LIKE CONCAT(:type, '%')
         GROUP BY `Range`;
      "; 

      try {
         $query = $database->prepare($query);
         $query->execute(array(
            ":0" => $bounds[0], 
            ":1" => $bounds[1],
            ":2" => $bounds[2],
            ":3" => $bounds[3],
            ":4" => $bounds[4],
            ":5" => $bounds[5],
            ":6" => $bounds[6],
            ":7" => $bounds[7],
            ":type" => $type
         ));
      } catch (PDOException $e) {
         errorLog("LOG READ", $e);
      }
      return $query;
   }
   function getWeekly($bounds, $type) {
      $database = connect(); 
      $query = 
      "  SELECT 
         CASE 
         WHEN datetime_log BETWEEN :0 AND :1 THEN 'W-8'
         WHEN datetime_log BETWEEN :1 AND :2 THEN 'W-7'
         WHEN datetime_log BETWEEN :2 AND :3 THEN 'W-6'
         WHEN datetime_log BETWEEN :3 AND :4 THEN 'W-5'
         WHEN datetime_log BETWEEN :4 AND :5 THEN 'W-4'
         WHEN datetime_log BETWEEN :5 AND :6 THEN 'W-3'
         WHEN datetime_log BETWEEN :6 AND :7 THEN 'W-2'
         WHEN datetime_log BETWEEN :7 AND :8 THEN 'W-1'
         ELSE 'OTHERS'
         END as `Range`,
         COUNT(1) as `Amount`
         FROM logs

         WHERE type_log LIKE CONCAT(:type, '%')
         GROUP BY `Range`;
      "; 

      try {
         $query = $database->prepare($query);
         $query->execute(array(
            ":0" => $bounds[0], 
            ":1" => $bounds[1],
            ":2" => $bounds[2],
            ":3" => $bounds[3],
            ":4" => $bounds[4],
            ":5" => $bounds[5],
            ":6" => $bounds[6],
            ":7" => $bounds[7],
            ":8" => $bounds[8],
            ":type" => $type
         ));
      } catch (PDOException $e) {
         errorLog("LOG READ", $e);
      }
      return $query;
   }
?>