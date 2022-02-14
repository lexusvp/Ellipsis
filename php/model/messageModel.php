<?php

   function createMessage($pseudo = "Vazn", $admin = false) {
      $database = connect();
      $timestamp = getTimestamp();
      $direction = null;

      if (!$admin) {
         $direction = 1;                  // Si crée par utilisateur => message considéré comme "envoyé"
      } else {
         $direction = 0;                  // Si crée par admin => change le sens
      }

      $createMessage = 
      "  INSERT INTO messages (content_message, timestamp_message, direction_message, id_user)
         VALUES (
            :message,
            :timestamp,
            :direction,
            (SELECT id_user FROM users WHERE pseudo_user = :pseudo)
         );
      ";
      try {
         $query = $database->prepare($createMessage);
         $query->execute(array(
            ":message" => $_POST["message"],
            ":timestamp" => $timestamp,
            ":direction" => $direction,
            ":pseudo" => $pseudo
         ));
      } catch (PDOException $e) {
         fileLog("MESSAGE CREATE : " . json_encode($e) . "\n");
      }
   }
   function readMessage($pseudo = "Vazn", $admin = false) {
      $database = connect();
      $readMessage = "";

      if ($admin) {        // Affiche toutes les conversations "ouvertes"
         $readMessage = 
         "  SELECT direction_message, content_message, timestamp_message, pseudo_user FROM messages
            JOIN users
            WHERE messages.id_user = users.id_user
            AND users.conversation_user = 1

            ORDER BY pseudo_user ASC, timestamp_message ASC;         
         ";
      } else {
         $readMessage = 
         "  SELECT direction_message, content_message, timestamp_message FROM messages
            WHERE id_user = (SELECT id_user FROM users WHERE pseudo_user = :pseudo)

            ORDER BY timestamp_message ASC;
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
         fileLog("MESSAGE READ : " . json_encode($e) . "\n");
      }

      return $query;
   }

?>