-- Create database 
CREATE DATABASE customers_manager;

--Create types table
CREATE TABLE `types`(
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(225) NOT NULL UNIQUE,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id)
);

--Create products table
CREATE TABLE `products`(
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(225) NOT NULL UNIQUE,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id)
);

-- Create customer table
CREATE TABLE `customers` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `type_id` INT(11),
    `name` VARCHAR(225) NOT NULL,
    `phone` INT(11) NOT NULL UNIQUE,
    `email` VARCHAR(225) NOT NULL UNIQUE,
    `fav_products` VARCHAR(225),
    `address` VARCHAR(225) NOT NULL,
    `gender` VARCHAR(1) NOT NULL,
    `image` VARCHAR(225) NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(type_id) REFERENCES types(id) ON DELETE SET NULL,
    PRIMARY KEY(id)
);

-- Insert into types
INSERT INTO `types` (`name`) VALUES 
('Business'),
('Student'),
('Private');

-- Insert into products
INSERT INTO `products` (`name`) VALUES 
('iPad'),
('iPhone'),
('Apple TV'),
('Airpods'),
('Apple Watch'),
('Macbook'),
('iMac');
