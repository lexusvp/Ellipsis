<?php
   //============= HELPERS FUNCTIONS =================//
   
   function fileLog($text) {
      fwrite(fopen("./logs.txt", "a+"), $text);
   }
?>