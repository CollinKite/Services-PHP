INSERT INTO `Main_Category` (`name`) VALUES
('Services'),
('Contact Us'),
('About'),
('Login'),
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