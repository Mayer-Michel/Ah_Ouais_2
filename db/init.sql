CREATE TABLE `equipments` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `type_equipment` varchar(50)
);

CREATE TABLE `rooms` (
  `id` int AUTO_INCREMENT,
  `type_id` int,
  `address_id` int UNIQUE,
  `capacity` int,
  `surface` decimal,
  `price_day` decimal,
  `description` varchar(255),
  `image` varchar(50),
  PRIMARY KEY (`id`, `type_id`)
);

CREATE TABLE `room_equipment` (
  `room_id` int,
  `equipment_id` int,
  PRIMARY KEY (`room_id`, `equipment_id`)
);

CREATE TABLE `users` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `email` varchar(50),
  `password` varchar(128),
  `firstname` varchar(50),
  `lastname` varchar(50),
  `phone_number` varchar(20),
  `role` int
);

CREATE TABLE `rentals` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int,
  `room_id` int,
  `date_start` datetime,
  `date_end` datetime
);

CREATE TABLE `types` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `type` varchar(20)
);

CREATE TABLE `address` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `city` varchar(20),
  `country` varchar(20),
  `address` varchar(50),
  `postal_code` int
);

ALTER TABLE `rooms` ADD FOREIGN KEY (`type_id`) REFERENCES `types` (`id`);

ALTER TABLE `rooms` ADD FOREIGN KEY (`address_id`) REFERENCES `address` (`id`);

ALTER TABLE `room_equipment` ADD FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

ALTER TABLE `room_equipment` ADD FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`);

ALTER TABLE `rentals` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `rentals` ADD FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);
