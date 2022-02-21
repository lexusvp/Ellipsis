<?php
   //============= HELPERS FUNCTIONS =================//
   
   function fileLog($text) {
      fwrite(fopen("./logs.json", "a+"), $text);
   }
   function errorLog($type, $description) {
      createLog($type, 0, json_encode($description));
   }
   function getTimestamp() {
      return (new DateTime())->getTimestamp();
   }
?>