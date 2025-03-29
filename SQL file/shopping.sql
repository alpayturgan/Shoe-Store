-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 10 Ara 2023, 13:20:41
-- Sunucu sürümü: 10.4.6-MariaDB
-- PHP Sürümü: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `shopping`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `updationDate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `creationDate`, `updationDate`) VALUES
(1, 'admin', 'f925916e2754e5e03f75dd58a5733251', '2021-01-24 16:21:18', '21-06-2018 08:27:55 PM');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `color` varchar(50) NOT NULL,
  `size` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `categoryName` varchar(255) DEFAULT NULL,
  `categoryDescription` longtext DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `updationDate` varchar(255) DEFAULT NULL,
  `categoryImage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `category`
--

INSERT INTO `category` (`id`, `categoryName`, `categoryDescription`, `creationDate`, `updationDate`, `categoryImage`) VALUES
(3, 'KIDS', 'Slip-ons', '2021-01-24 19:17:37', '30-01-2020 12:22:24 AM', 'KIDS.png'),
(4, 'TEENS', 'Women Footware', '2021-01-24 19:19:32', '', 'TEENS.png'),
(5, 'ADULTS', 'Men Footware', '2021-01-24 19:19:54', '', 'ADULTS.png');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `productId` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `orderDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `paymentMethod` varchar(50) DEFAULT NULL,
  `orderStatus` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `orders`
--

INSERT INTO `orders` (`id`, `userId`, `productId`, `quantity`, `orderDate`, `paymentMethod`, `orderStatus`) VALUES
(1, 1, '3', 1, '2021-01-07 19:32:57', 'COD', 'Delivered'),
(3, 1, '4', 1, '2021-01-10 19:43:04', 'Debit / Credit card', 'Delivered'),
(4, 1, '17', 1, '2021-01-08 16:14:17', 'COD', 'in Process'),
(5, 1, '3', 1, '2021-01-08 19:21:38', 'COD', NULL),
(6, 1, '4', 1, '2021-01-08 19:21:38', 'COD', NULL),
(7, 4, '1', 3, '2023-12-02 15:30:04', 'Debit / Credit card', NULL),
(8, 4, '1', 1, '2023-12-03 13:28:17', 'Debit / Credit card', NULL),
(9, 4, '1', 1, '2023-12-03 13:35:43', 'Debit / Credit card', NULL),
(10, 4, '1', 1, '2023-12-03 13:51:03', 'COD', NULL),
(11, 4, '1', 1, '2023-12-03 13:54:41', 'COD', NULL),
(12, 4, '1', 1, '2023-12-03 14:08:58', 'Debit / Credit card', NULL),
(13, 4, '1', 1, '2023-12-03 14:18:00', 'COD', NULL),
(14, 4, '2', 1, '2023-12-08 09:54:54', 'COD', NULL),
(15, 4, '3', 2, '2023-12-08 09:54:54', 'COD', NULL),
(16, 4, '2', 1, '2023-12-08 10:04:51', 'COD', NULL),
(17, 4, '3', 2, '2023-12-08 10:04:51', 'COD', NULL),
(18, 1, '1', 10, '2023-12-09 14:55:47', 'COD', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ordertrackhistory`
--

CREATE TABLE `ordertrackhistory` (
  `id` int(11) NOT NULL,
  `orderId` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `remark` mediumtext DEFAULT NULL,
  `postingDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `ordertrackhistory`
--

INSERT INTO `ordertrackhistory` (`id`, `orderId`, `status`, `remark`, `postingDate`) VALUES
(1, 3, 'in Process', 'Order has been Shipped.', '2021-01-10 19:36:45'),
(2, 1, 'Delivered', 'Order Has been delivered', '2021-01-10 19:37:31'),
(3, 3, 'Delivered', 'Product delivered successfully', '2021-01-10 19:43:04'),
(4, 4, 'in Process', 'Product ready for Shipping', '2021-01-10 19:50:36');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `productreviews`
--

CREATE TABLE `productreviews` (
  `id` int(11) NOT NULL,
  `productId` int(11) DEFAULT NULL,
  `quality` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `summary` varchar(255) DEFAULT NULL,
  `review` longtext DEFAULT NULL,
  `reviewDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `subCategory` int(11) DEFAULT NULL,
  `productName` varchar(255) DEFAULT NULL,
  `productCompany` varchar(255) DEFAULT NULL,
  `productPrice` int(11) DEFAULT NULL,
  `productPriceBeforeDiscount` int(11) DEFAULT NULL,
  `productDescription` longtext DEFAULT NULL,
  `productImage1` varchar(255) DEFAULT NULL,
  `productImage2` varchar(255) DEFAULT NULL,
  `productImage3` varchar(255) DEFAULT NULL,
  `shippingCharge` int(11) DEFAULT NULL,
  `productAvailability` varchar(255) DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `products`
--

INSERT INTO `products` (`id`, `category`, `subCategory`, `productName`, `productCompany`, `productPrice`, `productPriceBeforeDiscount`, `productDescription`, `productImage1`, `productImage2`, `productImage3`, `shippingCharge`, `productAvailability`, `postingDate`, `updationDate`) VALUES
(1, 3, 13, 'Miss Belgini Pink Boots', 'Miss Belgini', 1200, 1500, 'These ankle boots are a classic piece for your girls wardrobe. The side zipper makes them easy to slip into, while their fancy design will make your little girl stand out.\r\n\r\n\r\nMaterials: \r\n\r\nUpper: Faux leather\r\nInsole: Vegan Leather\r\nSole: Synthetic', '1.jpg', '2.jpg', '3.jpg', 50, 'In Stock', '2023-12-02 15:26:55', NULL),
(2, 3, 14, 'Ortopasso Gold  Sandals', 'Ortopasso', 900, 1000, 'A timeless design, these gold sandals will make your little princess the talk of the town. Perfectly suited for all occasions and events, she will be ready to show off her most fashionable look every day with ease. These sandals are sure to set her apart from the crowd due to their classic style and comfort fit. Not only is the material soft against even sensitive skin, but it also provides excellent foot support while keeping feet comfortable.\r\n\r\nMaterials: \r\n\r\nUpper: Vegan Leather\r\nInsole: Vegan Leather\r\nSole: Synthetic', '1.jpg', '2.jpg', '3.jpg', 50, 'In Stock', '2023-12-02 15:26:55', NULL),
(3, 3, 15, 'Miss Belgini Loafers', 'Miss Belgini', 900, 1000, 'These shoes are perfect for every girl. They effortlessly transition from school days to formal occasions.\r\n\r\n\r\nMaterials: \r\n\r\nUpper: Patent\r\nInsole: Vegan Leather\r\nSole: Synthetic', '1.jpg', '2.jpg', '3.jpg', 50, 'In Stock', '2023-12-02 15:26:55', NULL),
(4, 3, 16, 'Minnie Sneakers\r\n', 'Minnie ', 1300, 1500, 'A touch of magic: these Disney Minnie Mouse shoes make girls hearts beat faster. Comfortable and in a trendy pink look. Equipped with glitter and bright LED light sole. Let your girl be the coolest on the playground\r\n\r\n\r\n\r\nMaterials: \r\n\r\nUpper: Faux leather\r\nInsole: Textile\r\nSole: Rubber', '1.jpg', '2.jpg', '3.jpg', 50, 'In Stock', '2023-12-02 15:26:55', NULL),
(5, 3, 17, 'Coo Kids Pink Cute Slippers\r\n', 'Coo', 300, 350, 'These cute bunny slippers can make winter magical. They are super soft and warm, which makes them perfect for cold days.\r\n\r\n\r\n\r\n\r\nMaterials: \r\n\r\nUpper: Textile\r\nInsole: Textile\r\nSole: Rubber', '1.jpg', '2.jpg', '3.jpg', 50, 'In Stock', '2023-12-02 15:26:55', NULL),
(6, 4, 19, 'Rafaela Belgini Women platform sneakers in black\r\n\r\n', 'RAFAELA BELGINI', 1800, 2000, 'Women platform wedge sneakers in black. The soft platform heel is made from durable and elastic material. Comfortable wedge, accord with human engineering design, to increase the height. On trend fashion design to easy match with many occasions.\r\n\r\n\r\n\r\n\r\n\r\n\r\nMaterials: \r\n\r\n• Lace up sneakers\r\n• Durable rubber outsole\r\n• Memory foam\r\n• Platform wedge sole', '1.jpg', '2.jpg', '3.jpg', 50, 'In Stock', '2023-12-02 15:26:55', NULL),
(7, 4, 20, 'Skechers Go Walk 7 - Razi', 'Skechers ', 2000, 2500, 'This design is made with recycled materials\r\nSkechers Air-Cooled Memory Foam® cushioned comfort insole\r\nLightweight, responsive ULTRA GO® cushioning\r\nHigh-rebound ultra-lightweight Hyper Pillar Technology™ for added support\r\nSOFT STRIDE™\r\nCrafted with 100% vegan materials\r\n\r\nDesign Details\r\nAthletic mesh upper\r\nDurable dual-density traction outsole for stability\r\nMachine washable\r\n1 1/2-inch heel height\r\nSkechers® logo detail', '1.jpg', '2.jpg', '3.jpg', 50, 'In Stock', '2023-12-02 15:26:55', NULL),
(8, 4, 21, 'Reverse Flip Flops with Large Stones\r\n', 'REVERSE ', 300, 350, 'Upper: Other Materials\r\nSole: Other Materials', '1.jpg', '2.jpg', '2.jpg', 50, 'In Stock', '2023-12-02 15:26:55', NULL),
(9, 4, 22, 'Reverse Tan furry warm boots with bow accessory\r\n', 'Reverse ', 800, 1000, 'Winter is here, get this pair of tan coloured boots to keep your feet warn in cute bow style.\r\nTip: get one size bigger then your normal size\r\n• Slip on boots\r\n• Extra warm', '1.jpg', '2.jpg', '3.jpg', 50, 'In Stock', '2023-12-02 15:26:55', NULL),
(10, 4, 23, 'Columbia Women\'s Flow District Sneaker\r\n', 'Columbia ', 1900, 2000, '• INSPIRED DESIGN: Inspired by the Iconic Columbia Flow Sportswear apparel, the Flow District provides lightweight versatility with classic styling\r\n\r\n•NIMBLE PERFORMANCE: High function and wide ranging capabilities are designed into this agile shoe, built to deliver nimble response wherever you go\r\n\r\n•ADAPTIVE TERRAIN RESPONSE: Our TechLite lightweight midsole offers long lasting support, superior cushioning, and high energy return for all day performance\r\n\r\n•TRAIL READY / INDOOR SAFE: Our signature Omni-Grip non-marking traction rubber outsole provides versatility; from trail, to pavement, to indoor use – without worrying floor scuffs\r\n\r\n•BUILT TO LAST: Columbias attention to detail is what sets our footwear apart from others. We use only the highest quality materials, expert craftsmanship, and durable stitching. This is an excellent pair of shoes you will enjoy for seasons to come\r\n\r\n\r\n\r\n', '1.png', '2.jpg', '3.jpg', 50, 'In Stock', '2023-12-02 15:26:55', NULL),
(11, 5, 24, 'Miss Belgini Pink Wedge High Pumps\r\n', 'Miss Belgini', 350, 400, 'These beautifully crafted wedge high pumps feature an espadrilles-like design for all day comfort. These chic pink shoes take your look to the next level, adding a bit of glamour and edge to any outfit. The wedge heels provide added stability and the rubber soles ensure you can strut around with confidence.\r\n\r\nUpper: Textile\r\nInsole: Vegan Leather\r\nSole: Synthetic\r\nHeel height: 11cm', '1.jpg', '2.jpg', '3.jpg', 50, 'In Stock', '2023-12-02 15:26:55', NULL),
(12, 5, 25, 'Miss Belgini loafers in black with silver buckle\r\n', 'Miss Belgini', 1000, 1100, 'Timeless loafers with a sleek and sophisticated look that’s perfect for any outfit. Women’s loafers are a must-have for any fashion-forward individual.\r\n\r\n\r\nUpper: Vegan Leather\r\nInsole: Vegan Leather\r\nSole: Synthetic', '1.jpg', '2.jpg', '3.jpg', 50, 'In Stock', '2023-12-02 15:26:55', NULL),
(13, 5, 26, 'Miss Belgini Women stiletto pumps in nude\r\n', 'Miss Belgini', 1000, 1500, 'Classic and sexy slip on beige stiletto heels with pointed toe. Great choice and easy to go with dresses, jeans or slacks.\r\n\r\n\r\n\r\n• Stiletto style\r\n• Point toe\r\n• Slim high heel\r\n\r\n• Heel height: 9,5cm', '1.jpg', '2.jpg', '3.jpg', 50, 'In Stock', '2023-12-02 15:26:55', NULL),
(14, 5, 27, 'Miss Belgini black heeled pump\r\n', 'Miss Belgini', 1000, 1500, 'Step into elegance and confidence with these black heeled pumps. You can match them with every winter outfit. Available also in silver.\r\n\r\nUpper: Textile\r\nInsole: Vegan Leather\r\nSole: Synthetic', '1.jpg', '2.jpg', '3.jpg', 50, 'In Stock', '2023-12-02 15:26:55', NULL),
(15, 5, 28, 'Miss Belgini beige heeled pump with platform\r\n', 'Miss Belgini', 1600, 2000, 'Super high and sexy block heel pumps. The platform in the front allows you to stay comfort through out the night.\r\n\r\nUpper: Patent\r\nInsole: Vegan Leather\r\nSole: Synthetic', '1.jpg', '2.jpg', '3.jpg', 50, 'In Stock', '2023-12-02 15:26:55', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `size`
--

CREATE TABLE `size` (
  `size_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `size1` int(11) NOT NULL,
  `size2` int(11) NOT NULL,
  `size3` int(11) NOT NULL,
  `size4` int(11) NOT NULL,
  `size5` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `size`
--

INSERT INTO `size` (`size_id`, `category_id`, `size1`, `size2`, `size3`, `size4`, `size5`) VALUES
(1, 3, 18, 19, 20, 21, 22),
(2, 4, 28, 29, 30, 31, 32),
(3, 5, 36, 37, 38, 39, 40);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `subcategory`
--

CREATE TABLE `subcategory` (
  `id` int(11) NOT NULL,
  `categoryid` int(11) DEFAULT NULL,
  `subcategory` varchar(255) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `subcategory`
--

INSERT INTO `subcategory` (`id`, `categoryid`, `subcategory`, `creationDate`, `updationDate`) VALUES
(13, 3, 'Boots', '2023-12-02 15:03:47', NULL),
(14, 3, 'Sandals', '2023-12-02 15:04:35', NULL),
(15, 3, 'Loafers', '2023-12-02 15:04:58', NULL),
(16, 3, 'Sneakers', '2023-12-02 15:07:00', NULL),
(17, 3, 'Slippers', '2023-12-02 15:07:00', NULL),
(19, 4, 'Sneakers', '2023-12-02 15:09:08', NULL),
(20, 4, 'Slip-ons', '2023-12-02 15:09:43', NULL),
(21, 4, 'Flip-Flops', '2023-12-02 15:09:43', NULL),
(22, 4, 'Boots', '2023-12-02 15:10:14', NULL),
(23, 4, 'Outdoor and Hiking', '2023-12-02 15:10:28', NULL),
(24, 5, 'Platform Shoes\r\n', '2023-12-02 15:11:17', NULL),
(25, 5, 'Ballerina Flats', '2023-12-02 15:11:38', NULL),
(26, 5, 'Stiletto', '2023-12-02 15:11:51', NULL),
(27, 5, 'High Heels', '2023-12-02 15:11:59', NULL),
(28, 5, 'Platform Pumps', '2023-12-02 15:12:17', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `userlog`
--

CREATE TABLE `userlog` (
  `id` int(11) NOT NULL,
  `userEmail` varchar(255) DEFAULT NULL,
  `userip` binary(16) DEFAULT NULL,
  `loginTime` timestamp NULL DEFAULT current_timestamp(),
  `logout` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `userlog`
--

INSERT INTO `userlog` (`id`, `userEmail`, `userip`, `loginTime`, `logout`, `status`) VALUES
(1, 'vaishnavi@gmail.com', 0x3a3a3100000000000000000000000000, '2020-02-26 11:18:50', '', 1),
(2, 'vaishnavi@gmail.com', 0x3a3a3100000000000000000000000000, '2020-02-26 11:29:33', '', 1),
(3, 'vaishnavi@gmail.com', 0x3a3a3100000000000000000000000000, '2020-02-26 11:30:11', '', 1),
(4, 'vaishnavi@gmail.com', 0x3a3a3100000000000000000000000000, '2020-02-26 15:00:23', '26-02-2020 11:12:06 PM', 1),
(5, 'vaishnavi@gmail.com', 0x3a3a3100000000000000000000000000, '2020-02-26 18:08:58', '', 0),
(6, 'vaishnavi@gmail.com', 0x3a3a3100000000000000000000000000, '2020-02-26 18:09:41', '', 0),
(7, 'vaishnavi@gmail.com', 0x3a3a3100000000000000000000000000, '2020-02-26 18:10:04', '', 0),
(8, 'vaishnavi@gmail.com', 0x3a3a3100000000000000000000000000, '2020-02-26 18:10:31', '', 0),
(9, 'vaishnavi@gmail.com', 0x3a3a3100000000000000000000000000, '2020-02-26 18:13:43', '', 1),
(10, 'vaishnavi@gmail.com', 0x3a3a3100000000000000000000000000, '2020-02-27 18:52:58', '', 0),
(11, 'vaishnavi@gmail.com', 0x3a3a3100000000000000000000000000, '2020-02-27 18:53:07', '', 1),
(12, 'vaishnavi@gmail.com', 0x3a3a3100000000000000000000000000, '2020-03-03 18:00:09', '', 0),
(13, 'vaishnavi@gmail.com', 0x3a3a3100000000000000000000000000, '2020-03-03 18:00:15', '', 1),
(14, 'vaishnavi@gmail.com', 0x3a3a3100000000000000000000000000, '2020-03-06 18:10:26', '', 1),
(15, 'vaishnavi@gmail.com', 0x3a3a3100000000000000000000000000, '2020-03-07 12:28:16', '', 1),
(16, 'vaishnavi@gmail.com', 0x3a3a3100000000000000000000000000, '2020-03-07 18:43:27', '', 1),
(17, 'vaishnavi@gmail.com', 0x3a3a3100000000000000000000000000, '2020-03-07 18:55:33', '', 1),
(18, 'vaishnavi@gmail.com', 0x3a3a3100000000000000000000000000, '2020-03-07 19:44:29', '', 1),
(19, 'vaishnavi@gmail.com', 0x3a3a3100000000000000000000000000, '2020-03-08 19:21:15', '', 1),
(20, 'vaishnavi@gmail.com', 0x3a3a3100000000000000000000000000, '2020-03-15 17:19:38', '', 1),
(21, 'vaishnavi@gmail.com', 0x3a3a3100000000000000000000000000, '2020-03-15 17:20:36', '15-03-2020 10:50:39 PM', 1),
(22, 'vaishnavi@gmail.com', 0x3a3a3100000000000000000000000000, '2020-03-16 01:13:57', '', 1),
(23, 'hgfhgf@gmass.com', 0x3a3a3100000000000000000000000000, '2018-04-29 09:30:40', '', 1),
(24, 'alpay_turgan@hotmail.com', 0x3a3a3100000000000000000000000000, '2023-12-02 15:29:46', '02-12-2023 10:22:15 PM', 1),
(25, 'alpay_turgan@hotmail.com', 0x3a3a3100000000000000000000000000, '2023-12-02 16:53:28', NULL, 1),
(26, 'alpay_turgan@hotmail.com', 0x3a3a3100000000000000000000000000, '2023-12-03 13:27:58', NULL, 1),
(27, 'alpay_turgan@hotmail.com', 0x3a3a3100000000000000000000000000, '2023-12-07 12:27:06', NULL, 1),
(28, 'alpay_turgan@hotmail.com', 0x3a3a3100000000000000000000000000, '2023-12-08 09:53:54', '08-12-2023 03:41:04 PM', 1),
(29, 'alpay_turgan@hotmail.com', 0x3a3a3100000000000000000000000000, '2023-12-08 10:16:00', NULL, 1),
(30, 'alpay_turgan@hotmail.com', 0x3a3a3100000000000000000000000000, '2023-12-08 14:48:21', NULL, 1),
(31, 'alpay_turgan@hotmail.com', 0x3a3a3100000000000000000000000000, '2023-12-09 09:27:56', NULL, 1),
(32, 'alpay_turgan@hotmail.com', 0x3a3a3100000000000000000000000000, '2023-12-09 14:22:56', '09-12-2023 07:54:13 PM', 1),
(33, 'alpay_turgan@hotmail.com', 0x3a3a3100000000000000000000000000, '2023-12-09 14:24:17', '09-12-2023 07:55:04 PM', 1),
(34, 'alpay_turgan@hotmail.com', 0x3a3a3100000000000000000000000000, '2023-12-09 14:25:09', '09-12-2023 07:55:15 PM', 1),
(35, 'alpay_turgan@hotmail.com', 0x3a3a3100000000000000000000000000, '2023-12-09 14:25:23', NULL, 1),
(36, 'alpay_turgan@hotmail.com', 0x3a3a3100000000000000000000000000, '2023-12-10 10:49:49', '10-12-2023 04:24:24 PM', 1),
(37, 'asdas@emu', 0x3a3a3100000000000000000000000000, '2023-12-10 10:55:15', NULL, 0),
(38, 'alpay_turgan@hotmail.com', 0x3a3a3100000000000000000000000000, '2023-12-10 11:00:00', NULL, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contactno` bigint(11) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `shippingAddress` longtext DEFAULT NULL,
  `shippingState` varchar(255) DEFAULT NULL,
  `shippingCity` varchar(255) DEFAULT NULL,
  `shippingPincode` int(11) DEFAULT NULL,
  `billingAddress` longtext DEFAULT NULL,
  `billingState` varchar(255) DEFAULT NULL,
  `billingCity` varchar(255) DEFAULT NULL,
  `billingPincode` int(11) DEFAULT NULL,
  `regDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `updationDate` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `contactno`, `password`, `shippingAddress`, `shippingState`, `shippingCity`, `shippingPincode`, `billingAddress`, `billingState`, `billingCity`, `billingPincode`, `regDate`, `updationDate`) VALUES
(1, 'Vaishnavi', 'vaishnavi@gmail.com', 9009857868, '123', 'CS Bangalore', 'Bangalore', 'Delhi', 560001, 'Bangalore', 'Bangalore', 'Bangalore', 560001, '2021-02-04 19:30:50', ''),
(2, 'Anuvarshini ', 'anu@gmail.com', 8285703355, '123', '', '', '', 0, '', '', '', 0, '2021-03-15 17:21:22', ''),
(3, 'hg', 'hgfhgf@gmass.com', 1121312312, '123', '', '', '', 0, '', '', '', 0, '2021-04-29 09:30:32', ''),
(4, 'a', 'alpay_turgan@hotmail.com', 0, '827ccb0eea8a706c4c34a16891f84e7b', 'dsadsa', 'asdasd', 'asdasd', 0, 'saas', 'asdasd', 'asdsad', 0, '2023-12-02 15:29:42', NULL),
(5, 'Alpay Turgan', 'asdsad@emu.edu.tr', 123123, 'a8f5f167f44f4964e6c998dee827110c', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-10 10:55:42', NULL),
(6, 's', 's@s', 0, '03c7c0ace395d80182db07ae2c30f034', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-10 10:59:11', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `productId` int(11) DEFAULT NULL,
  `postingDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `wishlist`
--

INSERT INTO `wishlist` (`id`, `userId`, `productId`, `postingDate`) VALUES
(1, 1, 0, '2021-02-27 18:53:17'),
(3, 4, 1, '2023-12-08 14:48:29'),
(4, 4, 2, '2023-12-08 14:48:35'),
(5, 4, 9, '2023-12-08 15:10:15'),
(6, 1, 1, '2023-12-09 15:17:17'),
(7, 1, 1, '2023-12-09 15:19:16'),
(8, 1, 1, '2023-12-09 15:19:18'),
(9, 1, 1, '2023-12-09 15:20:35'),
(10, 1, 2, '2023-12-09 16:05:49'),
(11, 1, 1, '2023-12-09 16:15:09'),
(12, 4, 1, '2023-12-10 10:53:51'),
(13, 4, 1, '2023-12-10 12:08:01'),
(14, 4, 1, '2023-12-10 12:08:04'),
(15, 4, 1, '2023-12-10 12:08:06');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Tablo için indeksler `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ordertrackhistory`
--
ALTER TABLE `ordertrackhistory`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `productreviews`
--
ALTER TABLE `productreviews`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`size_id`);

--
-- Tablo için indeksler `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `userlog`
--
ALTER TABLE `userlog`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Tablo için AUTO_INCREMENT değeri `ordertrackhistory`
--
ALTER TABLE `ordertrackhistory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `productreviews`
--
ALTER TABLE `productreviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Tablo için AUTO_INCREMENT değeri `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Tablo için AUTO_INCREMENT değeri `userlog`
--
ALTER TABLE `userlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
