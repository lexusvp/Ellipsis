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
      }  else if ($target === "allErrors") {

         return getAllErrors()->fetchAll(PDO::FETCH_NUM);; 
      }   

      else if ($target === "logins") {
         [$query, $bindArgs] = buildDataQuery("Login", $resolution, $range);
         $answer = getDataPoints($query, $bindArgs)->fetchAll(PDO::FETCH_NUM);

         return formatData($answer, $bindArgs, $range, $resolution);
      }
      else if ($target === "register") {
         [$query, $bindArgs] = buildDataQuery("Reg", $resolution, $range);
         $answer = getDataPoints($query, $bindArgs)->fetchAll(PDO::FETCH_NUM);

         return formatData($answer, $bindArgs, $range, $resolution);
      }

   }
   function buildDataQuery($target, $resolution, $range) {
      //== NOTE: Construit une query pour une résolution et une intervalle donnée, sur le type de log "target"

      $intervalNb = $range + 1;
      $bindArgs = array();

      // Construit les binds nécessaires sur l'intervalle donnée
      // Plus vieux indexé à zéro, plus récent à intervalNb
      for ($i=$intervalNb ; $i>0 ; $i--) {
         $bound = "";
         if ($resolution === "Hourly") {
            $bound = date("Y-m-d H:0:0", strtotime("-" . $i . " hour"));
         } else if ($resolution === "Daily") {
            $bound = date("Y-m-d 08:00:00", strtotime("-" . $i . " day"));
         } else if ($resolution === "Weekly") {
            $bound = date("Y-m-d 08:00:00", strtotime("-" . $i . " week"));
         }
         $bindArgs[":". ($intervalNb - $i)] = $bound;
      }
      $bindArgs[":type"] = $target;    
      
      // Formatte la requête nécessaire sur l'intervalle donnée
      $start = "SELECT * FROM (SELECT CASE";
      $queryIntervals = "";
      for ($i = 0 ; $i < $range ; $i ++) {
         $queryIntervals .= 
         " WHEN datetime_log BETWEEN :" . $i . " AND :" . ($i + 1) . " THEN " . $i;
      }    
      $end = 
         "  END as `Interval`, COUNT(1) as `Amount`
         FROM logs
         JOIN logs_type ON logs_type.id_log_type = logs.id_log_type
         WHERE name_log_type LIKE CONCAT(:type, '%')
         GROUP BY `Interval`
         )  AS `Data`
         WHERE `Interval` IS NOT NULL
         ORDER BY `Interval` ASC;
         ";
      $query = $start.$queryIntervals.$end;

      return [$query, $bindArgs];
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

         $formatedIndex = "";
         if ($resolution === "Hourly") {
            $datetime = $bindArgs[":".$i];
            $formatedIndex = date("H:00:00", strtotime($datetime));
         } else if ($resolution === "Daily") {
            $datetime = $bindArgs[":".$i];
            $formatedIndex = date("d/m", strtotime($datetime));
         } else if ($resolution === "Weekly") {
            $datetime = $bindArgs[":".$i];
            $formatedIndex = date("d/m/Y", strtotime($datetime));
         }

         $amount = $numericArr[$i];      // Remplace les champs null par zéro
         if ($amount === null) {
            $amount = 0;
         }
         $finalArr[$formatedIndex] = $amount;
      }
      return $finalArr;
   }
?>