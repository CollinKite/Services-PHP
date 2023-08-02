DROP TABLE IF EXISTS `Admin`;
DROP TABLE IF EXISTS `Customer`;
DROP TABLE IF EXISTS `Sub_Category`;
DROP TABLE IF EXISTS `Main_Category`;

CREATE TABLE `Main_Category` (
  `id` INT AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `Sub_Category` (
  `id` INT AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `desc` TEXT NOT NULL,
  `cost` DECIMAL(10, 2),
  `main_category_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`main_category_id`) REFERENCES `Main_Category`(`id`)
);

CREATE TABLE `Customer` (
  `id` INT AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `sub_category_id` INT,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`sub_category_id`) REFERENCES `Sub_Category`(`id`)
);

CREATE TABLE `Admin` (
  `id` INT AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `Main_Category` (`name`) VALUES
('Services'),
('Contact Us'),
('About'),
('Admin Panel');

-- Assuming IDs were assigned in the order the records were inserted
INSERT INTO `Sub_Category` (`title`, `desc`, `main_category_id`) VALUES
('Consultation', 'Description for Consultation', (SELECT id FROM `Main_Category` WHERE name = 'Contact Us')),
('History', 'Description for History', (SELECT id FROM `Main_Category` WHERE name = 'About')),
('Locations', 'Description for Locations', (SELECT id FROM `Main_Category` WHERE name = 'About')),
('FAQ', 'Description for FAQ', (SELECT id FROM `Main_Category` WHERE name = 'Contact Us'));

-- Inserting sample data for Customer and Admin
INSERT INTO `Customer` (`name`, `email`, `sub_category_id`) VALUES
('John Doe', 'johndoe@example.com', 1); -- Assuming the first subcategory is 'Consultation'

INSERT INTO `Admin` (`username`, `password`, `token`, `token_expiration`) VALUES
('admin', 'admin123', 'sometokenvalue', '2023-08-01 00:00:00');