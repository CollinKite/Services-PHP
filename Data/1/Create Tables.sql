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
  `token_expiration` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
);
