<?php
   function createMessage($pseudo = "Vazn", $admin = false) {
      $database = connect();
      $now = date("y-m-d H:i:s", time());
      $direction = null;

      if (!$admin) {
         $direction = 1;                  // Si crée par utilisateur => message considéré comme "envoyé"
      } else {
         $direction = 0;                  // Si crée par admin => change le sens
      }

      $createMessage = 
      "  INSERT INTO messages (id_user, content_message, direction_message, datetime_message)
         VALUES (
            (SELECT id_user FROM users WHERE pseudo_user = :pseudo),
            :message,
            :direction,
            :datetime
         );
      ";
      try {
         $query = $database->prepare($createMessage);
         $query->execute(array(
            ":message" => $_POST["message"],
            ":datetime" => $now,
            ":direction" => $direction,
            ":pseudo" => $pseudo
         ));
      } catch (PDOException $e) {
         errorLog("MESSAGE CREATION " . $e);
      }
   }
   function readMessage($pseudo = "Vazn", $admin = false) {
      $database = connect();
      $readMessage = "";

      if ($admin) {        // Affiche toutes les conversations "ouvertes"
         $readMessage = 
         "  SELECT direction_message, content_message, datetime_message, pseudo_user FROM messages
            JOIN users
            WHERE messages.id_user = users.id_user
            AND users.conversation_user = 1

            ORDER BY pseudo_user ASC, datetime_message ASC;         
         ";
      } else {
         $readMessage = 
         "  SELECT direction_message, content_message, datetime_message FROM messages
            WHERE id_user = (SELECT id_user FROM users WHERE pseudo_user = :pseudo)

            ORDER BY datetime_message ASC;
         ";
      }

      try {
         $query = $database->prepare($readMessage);
         if ($admin) {
            $query->execute();
         } else {
            $query->execute(array(
               ":pseudo" => $pseudo
            ));        
         }
      } catch (PDOException $e) {
         errorLog("MESSAGE READ " . $e);
      }

      return $query;
   }

?>