-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2024 at 08:37 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecom`
--

-- --------------------------------------------------------

--
-- Table structure for table `buynow_cart`
--

CREATE TABLE `buynow_cart` (
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buynow_cart`
--

INSERT INTO `buynow_cart` (`user_id`, `product_id`) VALUES
(20, 19);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`user_id`, `product_id`) VALUES
(21, 10),
(21, 11),
(21, 12),
(21, 14);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100)NOT NULL,
  `img` varchar(100)DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `img`) VALUES
(1, 'Anime', 'anime_category.jpg'),
(2, 'Kidsware', 'category_kids.jpeg'),
(4, 'Men\'s Ware', 'category_mens.jpg'),
(5, 'Women\'s Ware', 'category_women.jpeg'),
(6, 'Japanese Manga', 'category_manga.jpg'),
(7, 'Hacker Tools', 'category_hacker_tools.jpg'),
(8, 'Laptops', 'category_laptops.jpg'),
(9, 'Electronics', 'category_electronics.jpg'),
(10, 'Mobiles', 'category_mobiles.jpg'),
(11, 'Watches', 'category_watches.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE `collections` (
  `id` int(11) NOT NULL,
  `name` varchar(100)NOT NULL,
  `img` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `collections`
--

INSERT INTO `collections` (`id`, `name`, `img`) VALUES
(1, 'Winter Clothing', 'winter_clothing.jpg'),
(2, 'Summer Clothing', 'summer_clothing.jpg'),
(3, 'Anime Series', 'anime_collection.jpg'),
(4, 'Manga Collection', 'manga_collection.jpg'),
(5, 'Fashion Feast', 'fashion_feast.jpg'),
(6, 'Super Sale', 'super_sale.jpg'),
(7, 'New Smartphones', 'new_smartphones.jpg'),
(8, 'New Laptops', 'new_laptops.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `flags`
--

CREATE TABLE `flags` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flags`
--

INSERT INTO `flags` (`id`, `name`) VALUES
(1, 'Featured'),
(2, 'Top Rated'),
(3, 'Sale'),
(4, 'Best Seller'),
(5, 'Nothing Special');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` varchar(100) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_price` float NOT NULL,
  `payment_status` varchar(100)DEFAULT NULL,
  `order_status` varchar(100)DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `total_price`, `payment_status`, `order_status`) VALUES
('order_N0mSUHQObel2LV', 20, 1060000, 'DONE', 'PROCESSING'),
('order_N5qkwEKZtdvpZZ', 20, 720000, 'PENDING', 'CREATED');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_id` varchar(100) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_id`, `product_id`) VALUES
('order_N0mSUHQObel2LV', 10),
('order_N0mSUHQObel2LV', 11),
('order_N0mSUHQObel2LV', 12),
('order_N0mSUHQObel2LV', 10),
('order_N5qkwEKZtdvpZZ', 19);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `sku` varchar(100) NOT NULL,
  `name` varchar(100)NOT NULL,
  `SP` int(11) NOT NULL,
  `rating` float DEFAULT NULL,
  `imgs` varchar(100)NOT NULL,
  `MRP` int(11) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `category` int(11) DEFAULT NULL,
  `collection` int(11) DEFAULT NULL,
  `flag` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `sku`, `name`, `SP`, `rating`, `imgs`, `MRP`, `description`, `category`, `collection`, `flag`) VALUES
(10, 'OP01', 'FireFist Ace | One Piece', 1800, NULL, 'dc80d6de406de406e3b9.jpg', 2000, 'Fire Fist Ace, a pivotal character in \"One Piece,\" is the adoptive brother of Luffy, wielding the destructive Mera Mera no Mi. Tragically dies in the Paramount War.', 1, 6, NULL),
(11, 'OP02', 'Doflamingo | One Piece', 2200, NULL, 'c88438f3c98f3c9e2af7.jpg', 3000, 'Donquixote Doflamingo, a major antagonist in \"One Piece,\" is a former Shichibukai and a ruthless pirate with the ability to control others using his Devil Fruit power.', 1, 6, 1),
(12, 'NRT01', 'Jiraya | Naruto', 4800, NULL, '85478db77ddb77d62ec0.jpg', 5000, 'Jiraiya, a prominent character in \"Naruto,\" is a legendary ninja and mentor to Naruto Uzumaki. Renowned as the \"Toad Sage,\" he possesses immense skill in ninjutsu and is a member of the elite trio known as the Legendary Sannin', 1, NULL, 1),
(13, 'NRT02', 'Kakashi | Naruto', 1800, NULL, 'e2785479e5479e57230d.jpg', 2000, 'Kakashi Hatake, a key figure in \"Naruto,\" is a skilled ninja and former leader of Team 7. Renowned for his Sharingan eye and mastery of countless jutsu, including the iconic Chidori, Kakashi serves as a mentor to Naruto, Sasuke, and Sakura.', 1, NULL, 4),
(14, 'AOT01', 'Levi Ackerman | AOT', 1500, NULL, 'e7e7d66c1b66c1be6716.jpg', 2200, 'Levi Ackerman, a central character in \"Attack on Titan,\" is humanity\'s strongest soldier and captain of the elite Survey Corps. Known for his unparalleled combat skills and precision, Levi is a strategic and stoic leader.', 1, NULL, NULL),
(15, 'DN01', 'Light Yagami | Death Note', 1000, NULL, '8ba63565d8565d81ef30.png', 1200, 'Light Yagami, the protagonist of \"Death Note,\" is a highly intelligent and ambitious high school student who discovers the Death Note, a supernatural notebook allowing him to kill anyone by writing their name.', 1, NULL, 4),
(16, 'OP3', 'Monkey D. Luffy | One Piece', 6500, NULL, 'df8ec2ba4a2ba4a91b52.jpg', 7000, 'My Favorite Character from One Piece.', 1, 6, NULL),
(17, 'NRT3', 'Madara Uchiha | Naruto', 3000, NULL, '4510b4e0304e03092db2.jpg', 3400, 'Most Badass Character out there.', 1, 6, 4),
(18, 'NRT04', 'Obito | Naruto', 2800, NULL, 'de4710601306013a675c.jpg', 3300, 'Obito is real badass.', 1, 3, 4),
(19, 'OP4', 'Whitebeard | One Piece', 7200, NULL, 'e484c6c7ac6c7acd0f61.jpg', 8000, 'He is the one of the characters i respect the most.', 1, 3, 4),
(20, 'OP5', 'Eren Yeager | AOT', 4900, NULL, 'b3eac383df383df2d3f2.jpg', 5000, 'This guy i used to like before i watched ONE PIECE. ', 1, 3, 1),
(21, 'OP6', 'Roronoa ZORO | One Piece', 6000, NULL, 'f9502c289ec289ebe07f.jpg', 6700, 'This guy is hell of a swordsman. I am looking forward for him to open his left eye.', 1, NULL, 1),
(22, 'OP7', 'Red-Hair Shanks | One Piece', 7800, NULL, '57c7bd44ced44ce21de1.jpg', 8000, 'Shanks is just awesome. I think you should pay me as i uploaded him to my website.', 1, 6, 4),
(23, 'NRTM01', 'Naruto Manga | VOL 1', 3200, NULL, '347614cb324cb32fe968.jpg', 3300, 'This is the manga for Naruto vol 1. Buy this master piece if you are an Anime fan.', 6, 4, 4),
(24, 'NRTM02', 'Itachi\'s Story | VOL 01', 3800, NULL, '6ce74465b9465b9ab252.jpg', 4000, 'This manga is filled with the awesome story of everyone\'s fav Itachi', 6, 4, 1),
(25, 'W01', 'Benyar Watch | Limited Edition', 2900, NULL, 'c3dab3c1383c13844fcd.jpg', 3500, 'An awesome watch for low budget.', 11, 6, NULL),
(26, 'DS1', 'Demon Slayer | Full Manga', 3000, NULL, 'e805b8f7388f7384a2ff.jpg', 3300, 'This manga is filled with awesome battles in the demon slayer universe.', 6, 4, NULL),
(27, 'OPM01', 'One Piece | Manga vol 1', 4800, NULL, '52d73f5a0bf5a0ba3d5e.jpg', 5000, 'This one piece manga will clear your confusion about anime.', 6, 4, 1),
(31, 'SHRT01', 'Women Shirt | crappy', 3200, NULL, '1128bcfec4cfec471498.jpg', 4000, 'hekk yeah.', 5, 2, 3),
(33, 'ARM01', 'Armani Shirt', 2200, NULL, 'b37590023b0023b79313.jpg', 2500, 'A must have shirt for men.', 4, 2, 5),
(34, 'COOL01', 'cool women', 2780, NULL, '397e2a2f19a2f195a232.jpg', 3000, 'stay cool, stay calm', 5, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `product_id` int(11) NOT NULL,
  `items` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`product_id`, `items`) VALUES
(10, 20),
(11, 10),
(12, 5),
(13, 30),
(14, 200),
(15, 22),
(16, 23),
(17, 55),
(19, 34),
(20, 55),
(21, 100),
(22, 100),
(23, 332),
(24, 300),
(25, 342),
(26, 323),
(27, 20),
(31, 300),
(33, 399),
(34, 20);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100)NOT NULL,
  `first_name` varchar(100)NOT NULL,
  `last_name` varchar(100)NOT NULL,
  `email` varchar(100)NOT NULL,
  `password` varchar(100)NOT NULL,
  `phone` varchar(100)NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `email`, `password`, `phone`) VALUES
(1, 'shoaibwani', 'shoaib', 'wani', 'shoaib@gmail.com', '1cafa61f242b9871a23e5f66ea340380505ebfdf1ccfe303853302a7762ee819', '7051131413'),
(3, 'Shoaib20Gc', '', '', 'letmeuseit158@gmail.com', '', ''),
(4, 'shoaibwani23', 'shoaib', 'wani', 'wani@g.c', '2cf24dba5fb0a30e26e83b2ac5b9e29e1b161e5c1fa7425e73043362938b9824', '7711111111'),
(6, 'Rbi', '', '', 'rbiachiever01@gmail.com', '', ''),
(14, 'Alladin', 'Saqlain', 'Mushtaq', 'saqlaincosmo@gmail.com', 'd4f9fa4d8f6e89df0143e60efb7645b14dd1447b0b60d107a627e19bd7158a03', '9797798232'),
(20, 'admin', '11111112222', '11111112222', '11111112222', '9afea1f1c0c5c232b8c922f8dee2bfaae37de077ac32a549ad85a6c7111ced7b', '11111112222'),
(21, 'hackerobito', 'shoaib', 'wani', 'nikagi6927@newnime.com', 'c82a9175fa69b71f32c309cf3e165111715b5647b5919162944acc4ab277cd6e', '1212121212');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` int(11) NOT NULL,
  `street` varchar(30) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `country` varchar(30) DEFAULT NULL,
  `pin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buynow_cart`
--
ALTER TABLE `buynow_cart`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flags`
--
ALTER TABLE `flags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`) USING HASH,
  ADD KEY `fk1` (`category`),
  ADD KEY `fk2` (`collection`),
  ADD KEY `fk3` (`flag`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD UNIQUE KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`) USING HASH;

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `flags`
--
ALTER TABLE `flags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buynow_cart`
--
ALTER TABLE `buynow_cart`
  ADD CONSTRAINT `buynow_cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `buynow_cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk1` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk2` FOREIGN KEY (`collection`) REFERENCES `collections` (`id`),
  ADD CONSTRAINT `fk3` FOREIGN KEY (`flag`) REFERENCES `flags` (`id`);

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `user_details_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
