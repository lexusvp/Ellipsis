CREATE TABLE users (
   id_user INT AUTO_INCREMENT PRIMARY KEY NOT NULL,

   admin_user BOOLEAN,
   email_user VARCHAR(75),
   pseudo_user VARCHAR(25),
   pw_user VARCHAR(100)
);
CREATE TABLE images(
   id_image INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
   path_image VARCHAR(100)
);
CREATE TABLE logs (
   id_log INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
   id_user INT NOT NULL,
   type_log VARCHAR(25), 
   timestamp_log INT,

   CONSTRAINT fk_users_logs FOREIGN KEY(id_user) REFERENCES users(id_user)
);
CREATE TABLE messages (
   id_message INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
   id_user INT NOT NULL,
   direction_message INT NOT NULL,
   content_message TEXT, 
   timestamp_message INT,

   CONSTRAINT fk_users_messages_user FOREIGN KEY(id_user) REFERENCES users(id_user)
);
CREATE TABLE services (
   id_service INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
   name_service VARCHAR(50), 
   content_service TEXT
);
CREATE TABLE illustrer (
   id_service INT,
   id_image INT,
   PRIMARY KEY(id_service, id_image),

   CONSTRAINT fk_services_illustrer FOREIGN KEY(id_service) REFERENCES services(id_service),
   CONSTRAINT fk_images_illustrer FOREIGN KEY(id_image) REFERENCES images(id_image)
);
