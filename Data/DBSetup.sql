DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `Customer`;
DROP TABLE IF EXISTS `Sub_Category`;
DROP TABLE IF EXISTS `Main_Category`;
DROP TABLE IF EXISTS `Selected_Style`;
DROP TABLE IF EXISTS `styles`;


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

CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `styles` (
  `id` INT AUTO_INCREMENT,
  `filename` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `Selected_Style` (
  `id` INT AUTO_INCREMENT,
  `style_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`style_id`) REFERENCES `styles`(`id`)
);

INSERT INTO `Main_Category` (`name`) VALUES
('Services'),
('Contact Us'),
('About'),
('Admin');

INSERT INTO `Sub_Category` (`title`, `desc`, `main_category_id`) VALUES
('Lawn Care', 'Lawn care is essential to maintaining a beautiful and healthy lawn. Our lawn care services include mowing, trimming, edging, and fertilizing. We take pride in creating lush, green lawns that enhance the curb appeal of your property. Let us take care of your lawn so you can enjoy your outdoor space to the fullest.', (SELECT id FROM `Main_Category` WHERE name = 'Services')),
('Carpet Cleaning', 'Carpet cleaning is the key to maintaining a fresh and healthy living environment. Our professional carpet cleaning services use advanced equipment and eco-friendly solutions to remove dirt, stains, and allergens from your carpets. With our expertise, your carpets will look and feel as good as new, extending their lifespan and enhancing the indoor air quality of your home or business.', (SELECT id FROM `Main_Category` WHERE name = 'Services')),
('Landscaping', 'Landscaping transforms outdoor spaces into captivating and functional areas that reflect your style and taste. Our landscaping services encompass design, installation, and maintenance, covering everything from lush gardens and inviting pathways to stunning water features and outdoor living spaces. Let our skilled team create a landscape that will be the envy of the neighborhood.', (SELECT id FROM `Main_Category` WHERE name = 'Services')),
('History', 'Our history is a testament to our commitment to excellence and customer satisfaction. Since our founding, we have been dedicated to providing top-notch services and building lasting relationships with our clients. Our journey is marked by continuous growth, innovation, and a relentless pursuit of perfection. We look forward to shaping a future that is even more remarkable.', (SELECT id FROM `Main_Category` WHERE name = 'About')),
('Locations', 'Our locations serve as hubs of convenience and accessibility. With strategically located branches, we can cater to a wide range of clients, delivering our services promptly and efficiently. Our presence in multiple locations allows us to better understand the unique needs of various communities and adapt our offerings accordingly. Find the nearest location and experience our exceptional services.', (SELECT id FROM `Main_Category` WHERE name = 'About')),
('Consultation', '', (SELECT id FROM `Main_Category` WHERE name = 'Contact Us')),
('FAQ', 'Frequently Asked Questions (FAQ) provide valuable insights and answers to common inquiries. Our comprehensive FAQ section covers various topics, ranging from our services and pricing to policies and customer support. If you have any questions or need further clarification, dont hesitate to reach out to our friendly team. We are here to assist you every step of the way.', (SELECT id FROM `Main_Category` WHERE name = 'Contact Us')),
('Login', '', (SELECT id FROM `Main_Category` WHERE name = 'Admin')),
('Admin Panel', '', (SELECT id FROM `Main_Category` WHERE name = 'Admin'));


INSERT INTO `Customer` (`name`, `email`, `sub_category_id`) VALUES
('John Doe', 'johndoe@example.com', 1);

INSERT INTO `users` (`username`, `password`, `token`) VALUES
('admin', 'password', 'unsafetokenvalue');


INSERT INTO `styles` (`filename`) VALUES
('lightmode.css'),
('darkmode.css'),
('pink.css');

INSERT INTO `Selected_Style` (`style_id`) VALUES
(2);