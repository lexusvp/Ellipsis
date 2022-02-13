<?php

   function createMessage($sender, $receiver = "Vazn") {
      $database = connect();
      $timestamp = getTimestamp();

      $createMessage = 
      "  INSERT INTO messages (content_message, timestamp_message, id_sender, id_receiver)
         VALUES (
            :message,
            :timestamp,
            (SELECT id_user FROM users WHERE pseudo_user = :sender),
            (SELECT id_user FROM users WHERE pseudo_user = :receiver)
         );
      ";

      try {
         $query = $database->prepare($createMessage);
         $query->execute(array(
            ":message" => $_POST["message"],
            ":timestamp" => $timestamp,
            ":sender" => $sender,
            ":receiver" => $receiver,
         ));
      } catch (PDOException $e) {
         fileLog("MESSAGE CREATE : " . json_encode($e) . "\n");
      }

      return $query;
   }

   function readMessage($pseudo) {
      $database = connect();

      $createMessage = 
      "  SELECT content_message, timestamp_message FROM messages
         WHERE id_sender = (SELECT id_user FROM users WHERE pseudo_user = :pseudo)
         OR id_receiver = (SELECT id_user FROM users WHERE pseudo_user = :pseudo)
         ORDER BY timestamp_message;
      ";

      try {
         $query = $database->prepare($createMessage);
         $query->execute(array(
            ":pseudo" => $pseudo
         ));

      } catch (PDOException $e) {
         fileLog("MESSAGE READ : " . json_encode($e) . "\n");
      }
   }

?>