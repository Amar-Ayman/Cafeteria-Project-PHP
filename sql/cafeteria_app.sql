-- 1. Create and Use Database
4	CREATE DATABASE IF NOT EXISTS `cafeteria_app`;
5	USE `cafeteria_app`;
6	
7	-- 2. Categories Table
8	CREATE TABLE `categories` (
9	    `id` INT AUTO_INCREMENT PRIMARY KEY,
10	    `name` VARCHAR(100) NOT NULL UNIQUE
11	);
12	
13	-- 3. Users Table
14	CREATE TABLE `users` (
15	    `id` INT AUTO_INCREMENT PRIMARY KEY,
16	    `name` VARCHAR(100) NOT NULL,
17	    `email` VARCHAR(100) NOT NULL UNIQUE,
18	    `password` VARCHAR(255) NOT NULL,
19	    `room_no` VARCHAR(20),
20	    `ext` VARCHAR(20),
21	    `profile_picture` VARCHAR(255),
22	    `role` ENUM('admin', 'user') DEFAULT 'user'
23	);
24	
25	-- 4. Products Table
26	CREATE TABLE `products` (
27	    `id` INT AUTO_INCREMENT PRIMARY KEY,
28	    `name` VARCHAR(100) NOT NULL,
29	    `price` DECIMAL(10, 2) NOT NULL,
30	    `category_id` INT NOT NULL,
31	    `image` VARCHAR(255),
32	    `status` ENUM('available', 'unavailable') DEFAULT 'available',
33	    FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
34	);
35	
36	-- 5. Orders Table
37	CREATE TABLE `orders` (
38	    `id` INT AUTO_INCREMENT PRIMARY KEY,
39	    `user_id` INT NOT NULL,
40	    `total_amount` DECIMAL(10, 2) NOT NULL,
41	    `status` ENUM('processing', 'out for delivery', 'done') DEFAULT 'processing',
42	    `room` VARCHAR(20),
43	    `notes` TEXT,
44	    `order_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
45	    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
46	);
47	
48	-- 6. Order_Items Table (Link between Orders and Products)
49	CREATE TABLE `order_items` (
50	    `order_id` INT NOT NULL,
51	    `product_id` INT NOT NULL,
52	    `quantity` INT NOT NULL DEFAULT 1,
53	    `price` DECIMAL(10, 2) NOT NULL,
54	    PRIMARY KEY (`order_id`, `product_id`),
55	    FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
56	    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
57	);
58	
59	-- Sample Data
60	INSERT INTO `categories` (`name`) VALUES ('Hot Drinks'), ('Cold Drinks'), ('Snacks');
61	
62	INSERT INTO `users` (`name`, `email`, `password`, `room_no`, `ext`, `role`) VALUES 
63	('Admin User', 'admin@cafeteria.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '101', '5555', 'admin'),
64	('Regular User', 'user@cafeteria.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '202', '4444', 'user');
65	
66	INSERT INTO `products` (`name`, `price`, `category_id`, `status`) VALUES 
67	('Tea', 5.00, 1, 'available'),
68	('Coffee', 10.00, 1, 'available'),
69	('Pepsi', 7.00, 2, 'available'),
70	('Croissant', 15.00, 3, 'available');