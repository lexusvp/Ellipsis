<?php
   session_start();
   date_default_timezone_set('Europe/Paris');
   
   require '../helpers.php';
   require '../model/userModel.php';
   require '../model/messageModel.php';
   require '../model/logModel.php';

   $admin = ( isset($_SESSION["admin"]) && $_SESSION["admin"] );
   $closeConversationCondition = (
      $admin &&
      $_GET["type"] === "closeConversation" && 
      isset($_GET["target"])
   );
   $getDataCondition = (
      $admin &&
      $_GET["type"] === "getData" && 
      isset($_GET["target"])
   );

   if ($closeConversationCondition) {
      $success = closeConversation($_GET["target"]) === 1;
      echo json_encode(["success" => $success]);
   }
   else if ($getDataCondition) {
      if (isset($_GET["resolution"]) && isset($_GET["range"])) {
         $dataNeeded = getData($_GET["target"], $_GET["resolution"], $_GET["range"]);
      } else {
         $dataNeeded = getData($_GET["target"]);
      }
      echo json_encode($dataNeeded);
   } else {
      echo json_encode(["authorized" => false]);
   }

   //=============>> DATA FETCH && FORMATTING <<===========//

   function getData($target, $resolution = "", $range = "") {
      $datasets = [];

      if ($resolution !== "" && $range !== "") {
         $intervalBinds = buildBinds($range, $resolution);

         for ($i=0 ; $i<count($target) ; $i++) {
            if ($target[$i] === "Logins") {
               $intervalBinds[":type"] = "Login";
               $prepared = buildIntervalQuery($range, "logs");

               $datasets["Logins"] = getFormattedData($prepared, $intervalBinds, $range, $resolution);
            }
            else if ($target[$i] === "Registrations") {
               $intervalBinds[":type"] = "Registrations";
               $prepared = buildIntervalQuery($range, "logs");

               $datasets["Registrations"] = getFormattedData($prepared, $intervalBinds, $range, $resolution);
            }     
            else if ($target[$i] === "Messages") {
               $prepared = buildIntervalQuery($range, "messages");               
               
               $datasets["Messages"] = getFormattedData($prepared, $intervalBinds, $range, $resolution);
            }
         }
      } else {
         if ($target[0] === "Errors") {
            $bound = date("Y-m-d H:i:0", strtotime("-" . $range . " day"));
            $datasets["Errors"] = getDataSince("Error", $bound)->fetchAll(PDO::FETCH_NUM);
         }  else if ($target[0] === "UserCount") {       
            $datasets["Users total"] = countUsers()->fetchAll(PDO::FETCH_NUM);
         }  else if ($target[0] === "MessageCount") {
            $datasets["Messages total"] = countMessages()->fetchAll(PDO::FETCH_NUM);
         }  
      }

      return $datasets;
   }

   function buildIntervalQuery($range, $table) {
      $start = 
      "
      WITH Cte AS (
         SELECT CASE
      ";
      
      $queryIntervals = "";
      $rowPostfix = substr($table, 0, -1);
      for ($i = 0 ; $i < $range ; $i ++) {
         $queryIntervals .= 
         " 
         WHEN datetime_" . $rowPostfix . " >= :" . $i . " 
         AND datetime_" . $rowPostfix . " < :" . ($i + 1) . " THEN " . $i;
      }   
      $logsEnd = 
         "  
         END as `Interval`, COUNT(1) as `Amount`
         FROM logs
         JOIN logs_type ON logs_type.id_log_type = logs.id_log_type
         WHERE name_log_type LIKE CONCAT(:type, '%')
         GROUP BY `Interval`)

         SELECT * FROM Cte
         WHERE `Interval` IS NOT NULL
         ORDER BY `Interval` ASC;
         ";
      $messEnd =
         "
         END as `Interval`, COUNT(1) as `Amount`
         FROM messages
         GROUP BY `Interval`)

         SELECT * FROM Cte
         WHERE `Interval` IS NOT NULL
         ORDER BY `Interval` ASC;
         ";   
      if ($table === "logs") {
         $query = $start.$queryIntervals.$logsEnd;
      } else if ($table === "messages") {
         $query = $start.$queryIntervals.$messEnd;
      }     
      
      return $query;
   }  
   function buildBinds($range, $resolution) {   
      $bindArgs = array();

      // Construit les binds nécessaires sur l'intervalle donnée
      for ($i=$range ; $i>=0 ; $i--) {
         if ($resolution === "Minutely") {
            $bound = date("Y-m-d H:i:0", strtotime("-" . ($i) . " minute"));
         } else if ($resolution === "Hourly") {
            $bound = date("Y-m-d H:0:0", strtotime("-" . ($i) . " hour"));
         } else if ($resolution === "Daily") {
            $bound = date("Y-m-d 08:00:00", strtotime("-" . ($i). " day"));
         } else if ($resolution === "Weekly") {
            $bound = date("Y-m-d 08:00:00", strtotime("-" . ($i). " week"));
         }
         $bindArgs[":".($range - $i)] = $bound;
      }

      return $bindArgs;
   }

   function formatData($answer, $bindArgs, $range, $resolution) {
      //== Prend le tableau retourné par la BDD et le transforme en associatif [Intervalle de temps => Donnée]
      $numericArr = new SplFixedArray($range);
      $finalArr = array();

      for ($i=0 ; $i<count($numericArr); $i++) {
         if (isset($answer[$i][0])) {
            $indexToPush = intval($answer[$i][0]); 
            $numericArr[$indexToPush] = intval($answer[$i][1]);      
         }
         
         if ($resolution === "Minutely") {
            $datetime = $bindArgs[":".$i];
            $formatedIndex = date("H:i:00", strtotime($datetime."+ 1 minute"));
         } else if ($resolution === "Hourly") {
            $datetime = $bindArgs[":".$i];
            $formatedIndex = date("H:00:00", strtotime($datetime."+ 1 hour"));
         } else if ($resolution === "Daily") {
            $datetime = $bindArgs[":".$i];
            $formatedIndex = date("d/m", strtotime($datetime."+ 1 day"));
         } else if ($resolution === "Weekly") {
            $datetime = $bindArgs[":".$i];
            $formatedIndex = date("d/m/Y", strtotime($datetime ."+ 1 week"));
         }

         // Remplace les champs null par zéro
         if ($numericArr[$i] === null) {
            $numericArr[$i] = 0;
         }
         $finalArr[$formatedIndex] = $numericArr[$i];
      }
      return $finalArr;
   }
   function getFormattedData($prepared, $binds, $range, $resolution) {
      $answer = getDataIntervals($prepared, $binds)->fetchAll(PDO::FETCH_NUM);
      return formatData($answer, $binds, $range, $resolution);
   }

?>