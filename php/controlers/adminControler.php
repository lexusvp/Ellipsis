<?php
   session_start();
   date_default_timezone_set('Europe/Paris');

   require '../helpers.php';
   require '../model/userModel.php';
   require '../model/messageModel.php';
   require '../model/logModel.php';

   $admin = (
      isset($_SESSION["admin"]) &&
      $_SESSION["admin"]
   );
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

   function getData($target, $resolution = null, $range = null) {

      if ($target === "userCount") {       
         return countUsers()->fetchAll(PDO::FETCH_NUM);
      }  else if ($target === "messageCount") {
         return countMessages()->fetchAll(PDO::FETCH_NUM);
      }   

      else if ($target === "Error") {
         $bound = buildBinds($range, $resolution, "Error", "logs", true);

         return  getDataSince("Error", $bound)->fetchAll(PDO::FETCH_NUM);
      }


      else if ($target === "Registration") {
         [$prepared, $bindArgs] = getIntervalQuery("logs", "Registration", $range, $resolution);
         $answer = getDataIntervals($prepared, $bindArgs)->fetchAll(PDO::FETCH_NUM);
      
         return formatData($answer, $bindArgs, $range, $resolution);
      }     
      else if ($target === "Login") {
         [$prepared, $bindArgs] = getIntervalQuery($range, $resolution, "Login");

         $answer = getDataIntervals($prepared, $bindArgs)->fetchAll(PDO::FETCH_NUM);     
         return formatData($answer, $bindArgs, $range, $resolution);
      }
      else if ($target === "Messages") {
         [$prepared, $bindArgs] = getIntervalQuery($range, $resolution, null, "messages");

         $answer = getDataIntervals($prepared, $bindArgs)->fetchAll(PDO::FETCH_NUM);
         return formatData($answer, $bindArgs, $range, $resolution);
      }
   }

   //== REMINDER: Build query on any interval with any res, on any table, with optionnal LIKE clause.
   function getIntervalQuery($range, $resolution, $target, $table = "logs") {
      $binds = buildBinds($range, $resolution, $target, $table);
      $prepared = buildIntervalQuery($table, $range);

      return [$prepared, $binds];
   }
   function buildIntervalQuery($table, $range) {
      $start = "SELECT * FROM (SELECT CASE";
      $queryIntervals = "";

      $rowPostfix = substr($table, 0, -1);
      for ($i = 0 ; $i < $range ; $i ++) {
         $queryIntervals .= 
         " 
         WHEN datetime_" . $rowPostfix . " >= :" . $i . " 
         AND datetime_" . $rowPostfix . " < :" . ($i + 1) . " THEN " . $i;
      }   
      $logsEnd = 
         "  END as `Interval`, COUNT(1) as `Amount`
         FROM logs
         JOIN logs_type ON logs_type.id_log_type = logs.id_log_type
         WHERE name_log_type LIKE CONCAT(:type, '%')
         GROUP BY `Interval`
         )  AS `Data`
         WHERE `Interval` IS NOT NULL
         ORDER BY `Interval` ASC;
         ";
      $messEnd =
         "
         END as `Interval`, COUNT(1) as `Amount`
         FROM messages
         GROUP BY `Interval`
         )  AS `Data`
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
   function buildBinds($range, $resolution, $target, $table, $single = false) {   
      $bindArgs = array();

      // Construit les binds nécessaires sur l'intervalle donnée
      // Plus vieux indexé à zéro, plus récent à intervalNb
      for ($i=$range ; $i>=0 ; $i--) {
         if ($resolution === "Hourly") {
            $bound = date("Y-m-d H:0:0", strtotime("-" . ($i) . " hour"));
         } else if ($resolution === "Daily") {
            $bound = date("Y-m-d 08:00:00", strtotime("-" . ($i). " day"));
         } else if ($resolution === "Weekly") {
            $bound = date("Y-m-d 08:00:00", strtotime("-" . ($i). " week"));
         }
         if ($single) {
            return $bound;
         }

         $bindArgs[":".($range - $i)] = $bound;
      }
      if ($table === "logs") {
         $bindArgs[":type"] = $target; 
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
         
         //== Obligé de décaler manuellement de + 1  resolution ?
         if ($resolution === "Hourly") {
            $datetime = $bindArgs[":".$i];
            $formatedIndex = date("H:00:00", strtotime($datetime));
         } else if ($resolution === "Daily") {
            $datetime = $bindArgs[":".$i];
            $formatedIndex = date("d/m", strtotime($datetime));
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
?>