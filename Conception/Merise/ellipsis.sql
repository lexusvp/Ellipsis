CREATE TABLE users (
   id_user INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
   first_name_user VARCHAR(50), 
   last_name_user VARCHAR(50),
   email_user VARCHAR(75),
   pseudo_user VARCHAR(25),
   pw_user VARCHAR(100)
);
CREATE TABLE admins (
   id_admin INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
   pseudo_admin VARCHAR(50), 
   pw_admin VARCHAR(100)
);
CREATE TABLE images(
   id_image INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
   path_image VARCHAR(100)
);

CREATE TABLE logs (
   id_log INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
   id_user INT NOT NULL,
   type_log VARCHAR(25), 
   datetime_log DATETIME,

   CONSTRAINT fk_users_logs FOREIGN KEY(id_user) REFERENCES users(id_user)
);
CREATE TABLE messages (
   id_message INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
   id_admin INT NOT NULL,
   id_user INT NOT NULL,
   content_message TEXT, 
   datetime_message VARCHAR(50),

   CONSTRAINT fk_admins_messages FOREIGN KEY(id_admin) REFERENCES admins(id_admin),
   CONSTRAINT fk_users_messages FOREIGN KEY(id_user) REFERENCES users(id_user)
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