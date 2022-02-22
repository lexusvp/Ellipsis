<?php
   //============= HELPERS FUNCTIONS =================//
   
   function fileLog($text) {
      fwrite(fopen("./logs.json", "a+"), $text);
   }
   function errorLog($description) {
      createLog("Error", "Vazn", $description);
   }
?>