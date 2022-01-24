<?php
   include './queryModules.php';
   include './connectionModule.php';

   //==========================>> CALL ZONE <<======================//

   //== INFO: Fully functionnal branching
   $queryType = $_GET["type"];
   switch($queryType) {
      case "createUser":
         createUser();
         break;
      case "checkUser":
         checkUser();
         break;
      case "updateUser":
         updateUser();
         break;

      case "createMessage":
         createMessage();
         break;
      case "createLog":
         createLog();
         break;

      default:
         die("No valid arguments in URL, WTF are you doing ?");
         break;
   }
?>