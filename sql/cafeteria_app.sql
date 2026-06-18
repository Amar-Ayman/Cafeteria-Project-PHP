-- 1. مسح الداتابيز القديمة وإنشاء واحدة جديدة عشان نبدأ على نظافة
DROP DATABASE IF EXISTS `cafeteria_app`;
CREATE DATABASE `cafeteria_app` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `cafeteria_app`;

-- 2. جدول الأقسام
CREATE TABLE `categories` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- 3. جدول المستخدمين (الباسوورد هنا نص عادي مش مشفر عشان يشتغل مع كودك)
CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `room_no` VARCHAR(20) NULL,
    `ext` VARCHAR(20) NULL,
    `profile_picture` VARCHAR(255) NULL,
    `role` ENUM('admin', 'user') DEFAULT 'user'
) ENGINE=InnoDB;

-- 4. جدول المنتجات
CREATE TABLE `products` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `price` DECIMAL(10, 2) NOT NULL,
    `category_id` INT NOT NULL,
    `image` VARCHAR(255) NULL,
    `status` ENUM('available', 'unavailable') DEFAULT 'available',
    FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 5. جدول الطلبات
CREATE TABLE `orders` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `total_amount` DECIMAL(10, 2) NOT NULL,
    `order_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `status` ENUM('processing', 'out for delivery', 'done') DEFAULT 'processing',
    `room` VARCHAR(20) NULL,
    `notes` TEXT NULL,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 6. جدول تفاصيل الطلب
CREATE TABLE `order_items` (
    `order_id` INT NOT NULL,
    `product_id` INT NOT NULL,
    `quantity` INT NOT NULL DEFAULT 1,
    `price` DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (`order_id`, `product_id`),
    FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO `categories` (`id`, `name`) VALUES 
(1, 'Hot Drinks'), (2, 'Cold Drinks'), (3, 'Snacks');

INSERT INTO `users` (`id`, `name`, `email`, `password`, `room_no`, `ext`, `role`) VALUES 
(1, 'Admin User', 'admin@cafeteria.com', 'password', '101', '5555', 'admin'),
(2, 'Regular User', 'user@cafeteria.com', 'password', '202', '4444', 'user');

INSERT INTO `products` (`name`, `price`, `category_id`, `status`, `image`) VALUES 
('Tea', 30.00, 1, 'available', 'tea.jpg.jpeg'),
('Coffee', 60.00, 1, 'available', 'coffee.png'),
('Pepsi', 20.00, 2, 'available', 'pepsi.jpg.jpeg'),
('Croissant', 30.00, 3, 'available', 'croissant.jpg.jpeg'),
('White Chocolate', 120.00, 1, 'available', 'White Chocolate.jpg.jpeg'),
('Avocado Juice', 55.00, 2, 'available', 'avogado juice.jpg.jpeg'),
('Brownies', 20.00, 3, 'available', 'browns.jpg.jpeg'),
('Cheese Cake', 170.00, 3, 'available', 'chesse cake.jpg.jpeg'),
('Cookies', 70.00, 3, 'available', 'cookies.jpg.jpeg'),
('Donut', 25.00, 3, 'available', 'dount.jpg.jpeg'),
('Latte', 120.00, 1, 'available', 'latte.jpg.jpeg'),
('Lemon Juice', 40.00, 2, 'available', 'lemon juice.jpg.jpeg'),
('Molten Cake', 70.00, 3, 'available', 'molton cake.jpg.jpeg'),
('Orange Juice', 50.00, 2, 'available', 'orange.jpg.jpeg'),
('Waffle', 40.00, 3, 'available', 'waffel.jpg.jpeg'),
('Watermelon Juice', 40.00, 2, 'available', 'watermelon juice.jpg.jpeg');
