-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 21, 2025 at 03:33 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `userid` varchar(10) DEFAULT NULL,
  `page` varchar(300) DEFAULT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `browser` varchar(300) DEFAULT NULL,
  `os` varchar(500) DEFAULT NULL,
  `activity` varchar(500) DEFAULT NULL,
  `data` mediumtext,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `userid`, `page`, `ip`, `browser`, `os`, `activity`, `data`, `date_created`) VALUES
(1, NULL, 'login', '127.0.0.1', 'Firefox', 'Mac OS X', 'Loggedin', '[]', '2025-03-19 12:50:45'),
(2, NULL, 'dashboard', '127.0.0.1', 'Firefox', 'Mac OS X', 'View Dashboard', '[]', '2025-03-19 12:50:45'),
(3, NULL, 'dashboard', '127.0.0.1', 'Firefox', 'Mac OS X', 'View Dashboard', '[]', '2025-03-19 12:51:22'),
(4, NULL, 'dashboard', '127.0.0.1', 'Firefox', 'Mac OS X', 'View Dashboard', '[]', '2025-03-19 12:53:07'),
(5, NULL, 'dashboard', '127.0.0.1', 'Firefox', 'Mac OS X', 'View Dashboard', '[]', '2025-03-19 12:54:29'),
(6, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products Page opened', '[]', '2025-03-19 12:54:32'),
(7, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"T-Shirt\",\"price\":\"4\",\"sku\":\"1001\",\"status\":\"1\",\"image\":\"1742388988_67dabefc4e36a.png\"}', '2025-03-19 12:56:28'),
(8, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products Page opened', '[]', '2025-03-19 12:57:14'),
(9, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Singlet\",\"price\":\"3\",\"sku\":\"1002\",\"status\":\"1\",\"image\":\"1742389146_67dabf9a8548d.png\"}', '2025-03-19 12:59:06'),
(10, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Boxers\",\"price\":\"3\",\"sku\":\"1003\",\"status\":\"1\",\"image\":\"1742389234_67dabff221e67.png\"}', '2025-03-19 13:00:34'),
(11, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Brazier\",\"price\":\"3\",\"sku\":\"1004\",\"status\":\"1\",\"image\":\"1742389307_67dac03b93894.png\"}', '2025-03-19 13:01:47'),
(12, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Shirt Long Sleeves\",\"price\":\"5\",\"sku\":\"1005\",\"status\":\"1\",\"image\":\"1742389394_67dac092b4982.png\"}', '2025-03-19 13:03:14'),
(13, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Shirt Short Sleeves\",\"price\":\"4\",\"sku\":\"1006\",\"status\":\"1\",\"image\":\"1742389457_67dac0d19d285.png\"}', '2025-03-19 13:04:17'),
(14, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Dress\",\"price\":\"5\",\"sku\":\"1007\",\"status\":\"1\",\"image\":\"1742389537_67dac12168478.png\"}', '2025-03-19 13:05:37'),
(15, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"African Print Top\\/Down\",\"price\":\"7\",\"sku\":\"1008\",\"status\":\"1\",\"image\":\"1742389585_67dac15167215.png\"}', '2025-03-19 13:06:25'),
(16, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Kente Kaba & Slit\",\"price\":\"12\",\"sku\":\"1009\",\"status\":\"1\",\"image\":\"1742389625_67dac17929838.png\"}', '2025-03-19 13:07:05'),
(17, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Kaftan(2 Pieces)\",\"price\":\"12\",\"sku\":\"1010\",\"status\":\"1\",\"image\":\"1742390133_67dac375b8aab.png\"}', '2025-03-19 13:15:33'),
(18, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Kaftan(3 Pieces)\",\"price\":\"15\",\"sku\":\"1011\",\"status\":\"1\",\"image\":\"1742390332_67dac43c081d1.png\"}', '2025-03-19 13:18:52'),
(19, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Suit(Dry Cleaning)\",\"price\":\"25\",\"sku\":\"1012\",\"status\":\"1\",\"image\":\"1742390411_67dac48b84a78.png\"}', '2025-03-19 13:20:11'),
(20, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Suit(3 pieces)\",\"price\":\"30\",\"sku\":\"1013\",\"status\":\"1\",\"image\":\"1742390454_67dac4b621747.png\"}', '2025-03-19 13:20:54'),
(21, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Camo up\\/down\",\"price\":\"20\",\"sku\":\"1014\",\"status\":\"1\",\"image\":\"1742390547_67dac513a9bb1.png\"}', '2025-03-19 13:22:27'),
(22, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Uniform up\\/down\",\"price\":\"7\",\"sku\":\"1015\",\"status\":\"1\",\"image\":\"1742390613_67dac55591777.png\"}', '2025-03-19 13:23:33'),
(23, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Hoodie\",\"price\":\"6\",\"sku\":\"1016\",\"status\":\"1\",\"image\":\"1742390698_67dac5aabb887.png\"}', '2025-03-19 13:24:58'),
(24, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Blazer\",\"price\":\"8\",\"sku\":\"1017\",\"status\":\"1\",\"image\":\"1742390745_67dac5d9c1c0a.png\"}', '2025-03-19 13:25:45'),
(25, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Jacket\",\"price\":\"10\",\"sku\":\"1018\",\"status\":\"1\",\"image\":\"1742390783_67dac5ff7ba4f.png\"}', '2025-03-19 13:26:23'),
(26, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Bedsheet Double Bed\",\"price\":\"8\",\"sku\":\"1019\",\"status\":\"1\",\"image\":\"1742390840_67dac6388f5d4.png\"}', '2025-03-19 13:27:20'),
(27, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Bedsheet Queen Bed\",\"price\":\"12\",\"sku\":\"1020\",\"status\":\"1\",\"image\":\"1742390881_67dac661bcb2a.png\"}', '2025-03-19 13:28:01'),
(28, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Bedsheet King Size Bed\",\"price\":\"20\",\"sku\":\"1021\",\"status\":\"1\",\"image\":\"1742390938_67dac69aae7bb.png\"}', '2025-03-19 13:28:58'),
(29, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Pillowcase\",\"price\":\"2\",\"sku\":\"1022\",\"status\":\"1\",\"image\":\"1742390982_67dac6c69a3ff.png\"}', '2025-03-19 13:29:42'),
(30, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Blanket\",\"price\":\"8\",\"sku\":\"1023\",\"status\":\"1\",\"image\":\"1742391035_67dac6fbb2c2b.png\"}', '2025-03-19 13:30:35'),
(31, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Curtains\",\"price\":\"10\",\"sku\":\"1024\",\"status\":\"1\",\"image\":\"1742391071_67dac71f85a56.png\"}', '2025-03-19 13:31:11'),
(32, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Duvet\",\"price\":\"15\",\"sku\":\"1025\",\"status\":\"1\",\"image\":\"1742391116_67dac74cddd4d.png\"}', '2025-03-19 13:31:56'),
(33, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Towel Small\",\"price\":\"6\",\"sku\":\"1026\",\"status\":\"1\",\"image\":\"1742391172_67dac7848016f.png\"}', '2025-03-19 13:32:52'),
(34, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Towel Medium\",\"price\":\"10\",\"sku\":\"1027\",\"status\":\"1\",\"image\":\"1742391218_67dac7b2587fa.png\"}', '2025-03-19 13:33:38'),
(35, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Towel Big\",\"price\":\"15\",\"sku\":\"1028\",\"status\":\"1\",\"image\":\"1742391272_67dac7e85ee08.png\"}', '2025-03-19 13:34:32'),
(36, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Sneakers\",\"price\":\"10\",\"sku\":\"1029\",\"status\":\"1\",\"image\":\"1742391322_67dac81a2b66f.png\"}', '2025-03-19 13:35:22'),
(37, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Denim Shorts\",\"price\":\"4\",\"sku\":\"1030\",\"status\":\"1\",\"image\":\"1742391361_67dac841240ab.png\"}', '2025-03-19 13:36:01'),
(38, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Denim Trousers\",\"price\":\"5\",\"sku\":\"1031\",\"status\":\"1\",\"image\":\"1742391402_67dac86a757f1.png\"}', '2025-03-19 13:36:42'),
(39, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products added', '{\"name\":\"Smock\",\"price\":\"10\",\"sku\":\"1032\",\"status\":\"1\",\"image\":\"1742391450_67dac89a09c0c.png\"}', '2025-03-19 13:37:30'),
(40, '1', 'pos', '127.0.0.1', 'Firefox', 'Mac OS X', 'POS Page opened', '[]', '2025-03-19 13:37:44'),
(41, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products Page opened', '[]', '2025-03-19 13:39:16'),
(42, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products Page opened', '[]', '2025-03-19 13:41:40'),
(43, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products Page opened', '[]', '2025-03-19 14:17:59'),
(44, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products Page opened', '[]', '2025-03-19 14:18:02'),
(45, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products Page opened', '[]', '2025-03-19 14:19:17'),
(46, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products Page opened', '[]', '2025-03-19 14:19:52'),
(47, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products Page opened', '[]', '2025-03-19 14:20:40'),
(48, NULL, 'login', '127.0.0.1', 'Firefox', 'Mac OS X', 'Loggedin', '[]', '2025-03-19 19:45:52'),
(49, NULL, 'dashboard', '127.0.0.1', 'Firefox', 'Mac OS X', 'View Dashboard', '[]', '2025-03-19 19:45:53'),
(50, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products Page opened', '[]', '2025-03-19 19:46:01'),
(51, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products updated', '{\"name\":\"T-Shirt\",\"price\":\"40\",\"sku\":\"1001\"}', '2025-03-19 19:46:10'),
(52, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products updated', '{\"name\":\"T-Shirt\",\"price\":\"4\",\"sku\":\"1001\"}', '2025-03-19 19:46:20'),
(53, '1', 'products', '127.0.0.1', 'Firefox', 'Mac OS X', 'Products Page opened', '[]', '2025-03-19 19:47:12'),
(54, '1', 'orders', '127.0.0.1', 'Firefox', 'Mac OS X', 'Orders Page opened', '[]', '2025-03-19 19:47:29'),
(55, '1', 'pos', '127.0.0.1', 'Firefox', 'Mac OS X', 'POS Page opened', '[]', '2025-03-19 19:47:34'),
(56, '1', 'pos', '127.0.0.1', 'Firefox', 'Mac OS X', 'POS Page opened', '[]', '2025-03-19 21:41:47'),
(57, '1', 'orders', '127.0.0.1', 'Firefox', 'Mac OS X', 'Orders Page opened', '[]', '2025-03-19 21:41:50'),
(58, NULL, 'login', '127.0.0.1', 'Firefox', 'Mac OS X', 'Loggedin', '[]', '2025-03-21 12:30:34'),
(59, NULL, 'dashboard', '127.0.0.1', 'Firefox', 'Mac OS X', 'View Dashboard', '[]', '2025-03-21 12:30:34'),
(60, '1', 'orders', '127.0.0.1', 'Firefox', 'Mac OS X', 'Orders Page opened', '[]', '2025-03-21 12:30:48'),
(61, '1', 'orders', '127.0.0.1', 'Firefox', 'Mac OS X', 'Orders Page opened', '[]', '2025-03-21 13:07:57'),
(62, '1', 'pos', '127.0.0.1', 'Firefox', 'Mac OS X', 'POS Page opened', '[]', '2025-03-21 13:08:04'),
(63, '1', 'pos', '127.0.0.1', 'Firefox', 'Mac OS X', 'New Order created', '{\"items\":[\"3\"],\"qty\":[\"1\"],\"discount\":\"0\",\"amount_paid\":\"3\",\"customername\":\"\",\"customerid\":\"\",\"clientname\":\"Thomas Nabanyi\",\"clientphone\":\"0208086525\",\"clientemail\":\"kojo@yahoo.co.uk\",\"clientdob\":\"2025-03-21\"}', '2025-03-21 13:08:31'),
(64, '1', 'orders', '127.0.0.1', 'Firefox', 'Mac OS X', 'Orders Page opened', '[]', '2025-03-21 13:08:39'),
(65, '1', 'orders', '127.0.0.1', 'Firefox', 'Mac OS X', 'Orders Page opened', '[]', '2025-03-21 13:09:17'),
(66, '1', 'orders', '127.0.0.1', 'Firefox', 'Mac OS X', 'Orders Page opened', '[]', '2025-03-21 13:09:39'),
(67, '1', 'orders', '127.0.0.1', 'Firefox', 'Mac OS X', 'Orders Page opened', '[]', '2025-03-21 13:10:01'),
(68, '1', 'orders', '127.0.0.1', 'Firefox', 'Mac OS X', 'Orders Page opened', '[]', '2025-03-21 13:10:09'),
(69, '1', 'orders', '127.0.0.1', 'Firefox', 'Mac OS X', 'Orders Page opened', '[]', '2025-03-21 13:16:28'),
(70, '1', 'orders', '127.0.0.1', 'Firefox', 'Mac OS X', 'Orders Page opened', '[]', '2025-03-21 13:17:01'),
(71, '1', 'pos', '127.0.0.1', 'Firefox', 'Mac OS X', 'POS Page opened', '[]', '2025-03-21 13:21:48'),
(72, '1', 'pos', '127.0.0.1', 'Firefox', 'Mac OS X', 'New Order created', '{\"items\":[\"2\"],\"qty\":[\"1\"],\"discount\":\"0\",\"amount_paid\":\"3\",\"customername\":\"Thomas  Nabanyi\",\"customerid\":\"1\",\"clientname\":\"\",\"clientphone\":\"\",\"clientemail\":\"\",\"clientdob\":\"\"}', '2025-03-21 13:22:20'),
(73, '1', 'orders', '127.0.0.1', 'Firefox', 'Mac OS X', 'Orders Page opened', '[]', '2025-03-21 13:23:00'),
(74, '1', 'orders', '127.0.0.1', 'Firefox', 'Mac OS X', 'Orders Page opened', '[]', '2025-03-21 13:35:57'),
(75, '1', 'orders', '127.0.0.1', 'Firefox', 'Mac OS X', 'Orders Page opened', '[]', '2025-03-21 13:40:36'),
(76, '1', 'pos', '127.0.0.1', 'Firefox', 'Mac OS X', 'POS Page opened', '[]', '2025-03-21 13:40:47'),
(77, '1', 'pos', '127.0.0.1', 'Firefox', 'Mac OS X', 'POS Page opened', '[]', '2025-03-21 13:41:34'),
(78, '1', 'pos', '127.0.0.1', 'Firefox', 'Mac OS X', 'POS Page opened', '[]', '2025-03-21 13:42:01'),
(79, '1', 'logout', '127.0.0.1', 'Firefox', 'Mac OS X', 'Logged Out', '[]', '2025-03-21 13:42:23'),
(80, NULL, 'login', '127.0.0.1', 'Firefox', 'Mac OS X', 'Loggedin', '[]', '2025-03-21 13:42:27'),
(81, '1', 'pos', '127.0.0.1', 'Firefox', 'Mac OS X', 'POS Page opened', '[]', '2025-03-21 13:42:28'),
(82, NULL, 'dashboard', '127.0.0.1', 'Firefox', 'Mac OS X', 'View Dashboard', '[]', '2025-03-21 13:42:32'),
(83, '1', 'orders', '127.0.0.1', 'Firefox', 'Mac OS X', 'Orders Page opened', '[]', '2025-03-21 13:43:19'),
(84, '1', 'orders', '127.0.0.1', 'Firefox', 'Mac OS X', 'Orders Page opened', '[]', '2025-03-21 13:49:31'),
(85, '1', 'orders', '127.0.0.1', 'Firefox', 'Mac OS X', 'Updated Order status', '{\"orderid\":\"1\",\"status\":\"3\"}', '2025-03-21 13:49:51'),
(86, '1', 'orders', '127.0.0.1', 'Firefox', 'Mac OS X', 'Orders Page opened', '[]', '2025-03-21 13:49:51'),
(87, '1', 'orders', '127.0.0.1', 'Firefox', 'Mac OS X', 'Updated Order status', '{\"orderid\":\"2\",\"status\":\"3\"}', '2025-03-21 13:49:55'),
(88, '1', 'orders', '127.0.0.1', 'Firefox', 'Mac OS X', 'Orders Page opened', '[]', '2025-03-21 13:49:56'),
(89, '1', 'sales', '127.0.0.1', 'Firefox', 'Mac OS X', 'Sales Page opened', '[]', '2025-03-21 13:49:58'),
(90, '1', 'sales', '127.0.0.1', 'Firefox', 'Mac OS X', 'Sales Page opened', '[]', '2025-03-21 13:51:50'),
(91, '1', 'pos', '127.0.0.1', 'Firefox', 'Mac OS X', 'POS Page opened', '[]', '2025-03-21 13:55:44'),
(92, '1', 'orders', '127.0.0.1', 'Firefox', 'Mac OS X', 'Orders Page opened', '[]', '2025-03-21 13:55:49'),
(93, '1', 'logout', '127.0.0.1', 'Firefox', 'Mac OS X', 'Logged Out', '[]', '2025-03-21 13:55:51'),
(94, NULL, 'login', '127.0.0.1', 'Firefox', 'Mac OS X', 'Loggedin', '[]', '2025-03-21 13:55:55'),
(95, '1', 'pos', '127.0.0.1', 'Firefox', 'Mac OS X', 'POS Page opened', '[]', '2025-03-21 13:55:55'),
(96, '1', 'pos', '127.0.0.1', 'Firefox', 'Mac OS X', 'POS Page opened', '[]', '2025-03-21 13:56:39'),
(97, '1', 'pos', '127.0.0.1', 'Firefox', 'Mac OS X', 'POS Page opened', '[]', '2025-03-21 13:56:42'),
(98, '1', 'orders', '127.0.0.1', 'Firefox', 'Mac OS X', 'Orders Page opened', '[]', '2025-03-21 13:56:47'),
(99, '1', 'logout', '127.0.0.1', 'Firefox', 'Mac OS X', 'Logged Out', '[]', '2025-03-21 13:56:52'),
(100, NULL, 'login', '127.0.0.1', 'Firefox', 'Mac OS X', 'Loggedin', '[]', '2025-03-21 13:57:04'),
(101, NULL, 'dashboard', '127.0.0.1', 'Firefox', 'Mac OS X', 'View Dashboard', '[]', '2025-03-21 13:57:04');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `abbr` varchar(30) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `abbr`, `phone`, `email`, `address`) VALUES
(1, 'Laundry Depot', 'LP', '0548246749', 'laundrydepotgh@gmail.com', 'Rashid Sumailia Washing Bay');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `middlename` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `status` varchar(2) NOT NULL DEFAULT '1',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `firstname`, `middlename`, `lastname`, `email`, `phone`, `dob`, `address`, `status`, `date_created`) VALUES
(1, 'Thomas', '', 'Nabanyi', 'kojo@yahoo.co.uk', '0208086525', '2025-03-21', NULL, '1', '2025-03-21 13:08:31');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `orderid` varchar(60) NOT NULL,
  `itemid` varchar(11) NOT NULL,
  `customer` varchar(11) NOT NULL,
  `total_amount` double DEFAULT NULL,
  `amount_paid` double DEFAULT NULL,
  `balance` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `discount_amt` double DEFAULT NULL,
  `trans_date` date DEFAULT NULL,
  `notes` varchar(30) DEFAULT NULL,
  `status` varchar(5) DEFAULT '0' COMMENT '0=pending, 1=in-progress, 2=ready, 3=delivered',
  `active` varchar(2) NOT NULL DEFAULT '1',
  `created_by` varchar(30) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `orderid`, `itemid`, `customer`, `total_amount`, `amount_paid`, `balance`, `discount`, `discount_amt`, `trans_date`, `notes`, `status`, `active`, `created_by`, `created_at`) VALUES
(1, '790423560366', '3', '1', 3, 3, 0, 0, 0, '2025-03-21', '', '3', '1', '1', '2025-03-21 13:08:31'),
(2, '218553327864', '2', '1', 3, 3, 0, 0, 0, '2025-03-21', '', '3', '1', '1', '2025-03-21 13:22:20');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `orderid` varchar(60) NOT NULL,
  `amount` double DEFAULT NULL,
  `selling_price` double DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `itemid` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `orderid`, `amount`, `selling_price`, `quantity`, `itemid`) VALUES
(1, '790423560366', 3, 3, 1, '3'),
(2, '218553327864', 3, 3, 1, '2');

-- --------------------------------------------------------

--
-- Table structure for table `payment_logs`
--

CREATE TABLE `payment_logs` (
  `id` int(11) NOT NULL,
  `orderid` varchar(11) NOT NULL,
  `prev_bal` double NOT NULL,
  `amount` double NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `status` varchar(2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `sku`, `price`, `status`, `image`, `date_created`) VALUES
(1, 'T-Shirt', '1001', 4, '1', '1742388988_67dabefc4e36a.png', '2025-03-19 12:56:28'),
(2, 'Singlet', '1002', 3, '1', '1742389146_67dabf9a8548d.png', '2025-03-19 12:59:06'),
(3, 'Boxers', '1003', 3, '1', '1742389234_67dabff221e67.png', '2025-03-19 13:00:34'),
(4, 'Brazier', '1004', 3, '1', '1742389307_67dac03b93894.png', '2025-03-19 13:01:47'),
(5, 'Shirt Long Sleeves', '1005', 5, '1', '1742389394_67dac092b4982.png', '2025-03-19 13:03:14'),
(6, 'Shirt Short Sleeves', '1006', 4, '1', '1742389457_67dac0d19d285.png', '2025-03-19 13:04:17'),
(7, 'Dress', '1007', 5, '1', '1742389537_67dac12168478.png', '2025-03-19 13:05:37'),
(8, 'African Print Top/Down', '1008', 7, '1', '1742389585_67dac15167215.png', '2025-03-19 13:06:25'),
(9, 'Kente Kaba & Slit', '1009', 12, '1', '1742389625_67dac17929838.png', '2025-03-19 13:07:05'),
(10, 'Kaftan(2 Pieces)', '1010', 12, '1', '1742390133_67dac375b8aab.png', '2025-03-19 13:15:33'),
(11, 'Kaftan(3 Pieces)', '1011', 15, '1', '1742390332_67dac43c081d1.png', '2025-03-19 13:18:52'),
(12, 'Suit(Dry Cleaning)', '1012', 25, '1', '1742390411_67dac48b84a78.png', '2025-03-19 13:20:11'),
(13, 'Suit(3 pieces)', '1013', 30, '1', '1742390454_67dac4b621747.png', '2025-03-19 13:20:54'),
(14, 'Camo up/down', '1014', 20, '1', '1742390547_67dac513a9bb1.png', '2025-03-19 13:22:27'),
(15, 'Uniform up/down', '1015', 7, '1', '1742390613_67dac55591777.png', '2025-03-19 13:23:33'),
(16, 'Hoodie', '1016', 6, '1', '1742390698_67dac5aabb887.png', '2025-03-19 13:24:58'),
(17, 'Blazer', '1017', 8, '1', '1742390745_67dac5d9c1c0a.png', '2025-03-19 13:25:45'),
(18, 'Jacket', '1018', 10, '1', '1742390783_67dac5ff7ba4f.png', '2025-03-19 13:26:23'),
(19, 'Bedsheet Double Bed', '1019', 8, '1', '1742390840_67dac6388f5d4.png', '2025-03-19 13:27:20'),
(20, 'Bedsheet Queen Bed', '1020', 12, '1', '1742390881_67dac661bcb2a.png', '2025-03-19 13:28:01'),
(21, 'Bedsheet King Size Bed', '1021', 20, '1', '1742390938_67dac69aae7bb.png', '2025-03-19 13:28:58'),
(22, 'Pillowcase', '1022', 2, '1', '1742390982_67dac6c69a3ff.png', '2025-03-19 13:29:42'),
(23, 'Blanket', '1023', 8, '1', '1742391035_67dac6fbb2c2b.png', '2025-03-19 13:30:35'),
(24, 'Curtains', '1024', 10, '1', '1742391071_67dac71f85a56.png', '2025-03-19 13:31:11'),
(25, 'Duvet', '1025', 15, '1', '1742391116_67dac74cddd4d.png', '2025-03-19 13:31:56'),
(26, 'Towel Small', '1026', 6, '1', '1742391172_67dac7848016f.png', '2025-03-19 13:32:52'),
(27, 'Towel Medium', '1027', 10, '1', '1742391218_67dac7b2587fa.png', '2025-03-19 13:33:38'),
(28, 'Towel Big', '1028', 15, '1', '1742391272_67dac7e85ee08.png', '2025-03-19 13:34:32'),
(29, 'Sneakers', '1029', 10, '1', '1742391322_67dac81a2b66f.png', '2025-03-19 13:35:22'),
(30, 'Denim Shorts', '1030', 4, '1', '1742391361_67dac841240ab.png', '2025-03-19 13:36:01'),
(31, 'Denim Trousers', '1031', 5, '1', '1742391402_67dac86a757f1.png', '2025-03-19 13:36:42'),
(32, 'Smock', '1032', 10, '1', '1742391450_67dac89a09c0c.png', '2025-03-19 13:37:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `status` varchar(2) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `phone`, `email`, `address`, `status`, `username`, `password`, `role`, `date_created`) VALUES
(1, 'Thomas', 'Donzaalas', 'Nabanyi', '0248086525', 'xraygunplay@gmail.com', 'Elmina, Peace Avenue', '1', 'Naab', '$2y$10$mn7/bSqrxdI773j02aDOsO1wVK8pekoqo5gH3sCsug1cV7jmCxfqy', 'ADMIN', '2025-03-07 11:50:06'),
(2, 'Charity', '', 'Votere', '0249893519', 'votere@gmail.com', '', '1', 'Votere', '$2y$10$xA3vXgfMofhi5w.cxeEK6.CsOQAA8Y7CWvZ7j72ir4upJuwDmWua2', 'USER', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_logs`
--
ALTER TABLE `payment_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment_logs`
--
ALTER TABLE `payment_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
