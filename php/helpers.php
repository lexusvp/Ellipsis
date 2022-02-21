<?php
   //============= HELPERS FUNCTIONS =================//
   
   function fileLog($text) {
      fwrite(fopen("./logs.json", "a+"), $text);
   }
   function errorLog($type, $description) {
      createLog("Error", 0, $type . " : " . json_encode($description));
   }
?>