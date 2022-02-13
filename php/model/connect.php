<?php
   function connect() {
      $dsn = "mysql:host=localhost;dbname=ellipsis";
      $database = new PDO($dsn, "root", "root", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
      $database->exec("set names utf8");

      return $database;
   }
?>
