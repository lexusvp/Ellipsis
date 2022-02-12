<?php
   //============= HELPERS FUNCTIONS =================//
   
   function fileLog($text) {
      fwrite(fopen("./logs.txt", "a+"), $text);
   }

   function getTimestamp() {
      return (new DateTime())->getTimestamp();
   }
?>