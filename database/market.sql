CREATE DATABASE IF NOT EXISTS `market`;

USE `market`;

CREATE TABLE IF NOT EXISTS `users` (
    userid int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    role ENUM('admin','seller', 'customer') NOT NULL DEFAULT 'customer',
    status ENUM('pending', 'under_review', 'active', 'disabled') NOT NULL DEFAULT 'pending',
    created_at datetime DEFAULT CURRENT_TIMESTAMP,
    updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);

CREATE TABLE IF NOT EXISTS `product` (
    productid int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sellerid int(11) UNSIGNED NOT NULL,
    name varchar(255) NOT NULL,
    description varchar(255) NOT NULL,
    image varchar(255) NOT NULL,
    price float NOT NULL,
    category varchar(255) NOT NULL,
    created_at datetime DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sellerid) REFERENCES users(userid));

CREATE TABLE IF NOT EXISTS `orders` (
    orderid int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    userid int(11) UNSIGNED NOT NULL,
    productid int(11) UNSIGNED NOT NULL,
    quantity int(11),
    totalprice DECIMAL(10,2),
    created_at datetime DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userid) REFERENCES users(userid),
    FOREIGN KEY (productid) REFERENCES product(productid));

CREATE TABLE IF NOT EXISTS `cart` (
    cartid int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    userid int(11) UNSIGNED NOT NULL,
    productid int(11) UNSIGNED NOT NULL,
    quantity int(11),
    FOREIGN KEY (userid) REFERENCES users(userid),
    FOREIGN KEY (productid) REFERENCES product(productid));

INSERT INTO `users` (`name`, `password`, `role`, `status`) 
        VALUES ('admin1', '$2y$10$XG9fxiBFlu2E1SxM9zSgLud7f7jKyOwKKNyUmRDzVQu9EwMhOl36e', 'admin', 'active');