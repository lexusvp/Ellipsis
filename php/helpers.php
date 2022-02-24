<?php
   //============= HELPERS FUNCTIONS =================//

   $logged = (
      isset($_SESSION["logged"]) &&
      $_SESSION["logged"]
   );
   $admin = (
      isset($_SESSION["admin"]) &&
      $_SESSION["admin"]
   );

   function connect() {
      $dsn = "mysql:host=localhost;dbname=ellipsis";
      $database = new PDO($dsn, "root", "root", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
      $database->exec("set names utf8");

      return $database;
   }
   function fileLog($text) {
      fwrite(fopen("./logs.json", "a+"), $text);
   }
   function errorLog($description) {
      createLog("Error", "Vazn", $description);
   }

   function sanitizeInputs() { 
   }
?>