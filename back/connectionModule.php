<?php
   function queryDatabase($prepared, $queryArgs = NULL) { 
      $dsn = "mysql:host=localhost;dbname=ellipsis";

      $database = new PDO($dsn, "root", "root", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
      $database -> exec("set names utf8");
      $query = $database -> prepare($prepared);

      try {
         $success = $query->execute($queryArgs); 
      }  catch (Exception $e) { 
         die("La requête a échoué !");
      }

      return [$success, $query];
   }
?>
