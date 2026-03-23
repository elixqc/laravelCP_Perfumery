-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 23, 2026 at 12:28 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prestigeperf`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('prestige-perfumery-cache-77de68daecd823babbb58edb1c8e14d7106e83bb', 'i:1;', 1774150507),
('prestige-perfumery-cache-77de68daecd823babbb58edb1c8e14d7106e83bb:timer', 'i:1774150507;', 1774150507),
('prestige-perfumery-cache-b6692ea5df920cad691c20319a6fffd7a4a766b8', 'i:1;', 1774150486),
('prestige-perfumery-cache-b6692ea5df920cad691c20319a6fffd7a4a766b8:timer', 'i:1774150486;', 1774150486),
('prestige-perfumery-cache-f1f836cb4ea6efb2a0b1b99f41ad8b103eff4b59', 'i:1;', 1774150692),
('prestige-perfumery-cache-f1f836cb4ea6efb2a0b1b99f41ad8b103eff4b59:timer', 'i:1774150692;', 1774150692);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`user_id`, `product_id`, `quantity`, `date_added`) VALUES
(3, 6, 1, '2026-03-22 06:29:01'),
(7, 5, 2, '2026-03-07 03:21:51'),
(7, 14, 2, '2026-03-07 03:03:50');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` bigint UNSIGNED NOT NULL,
  `category_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `deleted_at`) VALUES
(1, 'Men\'s Fragrances', NULL),
(2, 'Women\'s Fragrances', NULL),
(3, 'Unisex Fragrances', NULL),
(4, 'niko pogi', '2026-03-21 22:21:48'),
(5, 'EDP', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_01_01_000001_create_categories_table', 1),
(2, '2024_01_01_000002_create_suppliers_table', 1),
(3, '2024_01_01_000003_create_users_table', 1),
(4, '2024_01_01_000004_create_products_table', 1),
(5, '2024_01_01_000005_create_product_images_table', 1),
(6, '2024_01_01_000006_create_orders_table', 1),
(7, '2024_01_01_000007_create_order_details_table', 1),
(8, '2024_01_01_000008_create_cart_table', 1),
(9, '2024_01_01_000009_create_product_reviews_table', 1),
(10, '2024_01_01_000010_create_supply_logs_table', 1),
(11, '2026_02_26_010209_create_sessions_table', 2),
(12, '2014_10_12_100000_create_password_resets_table', 3),
(13, '2026_02_27_025153_create_cache_table', 4),
(14, '2026_02_27_000000_add_total_amount_to_orders_table', 5),
(15, '2026_03_06_000001_add_deleted_at_to_products_table', 6),
(16, '2026_03_06_000002_add_initial_and_selling_price_to_products_table', 7),
(17, '2026_03_06_100000_remove_price_from_products_table', 8),
(18, '2026_03_07_000000_add_email_verification_to_users_table', 9),
(19, '2026_03_20_000001_drop_total_amount_from_orders_table', 10),
(20, '2026_03_20_000002_drop_image_path_from_products_table', 11),
(21, '2026_03_20_000001_drop_unit_price_from_order_details', 12),
(22, '2026_03_21_113822_add_soft_deletes_to_suppliers_table', 13),
(23, '2024_01_01_000001_add_soft_deletes_to_categories', 14),
(24, '2026_03_22_000001_remove_delivery_address_from_orders_table', 15),
(25, '2026_03_22_032455_rename_password_resets_to_password_reset_tokens', 16);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `date_received` timestamp NULL DEFAULT NULL,
  `payment_method` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'COD',
  `payment_reference` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `order_status`, `date_received`, `payment_method`, `payment_reference`) VALUES
(1, 3, '2026-02-26 01:07:27', 'cancelled', NULL, 'cash', NULL),
(2, 3, '2026-02-26 01:13:03', 'delivered', NULL, 'cash', NULL),
(3, 3, '2026-02-27 02:28:30', 'processing', NULL, 'cash', NULL),
(4, 3, '2026-03-05 01:54:40', 'cancelled', NULL, 'cash', NULL),
(6, 1, '2026-03-06 14:33:39', 'cancelled', NULL, 'cash', NULL),
(7, 1, '2026-03-06 14:35:56', 'completed', NULL, 'cash', NULL),
(8, 7, '2026-03-07 02:57:37', 'completed', NULL, 'cash', NULL),
(9, 7, '2026-03-07 02:58:02', 'completed', NULL, 'cash', NULL),
(10, 1, '2026-03-07 12:14:48', 'completed', NULL, 'cash', NULL),
(11, 2, '2026-03-06 04:44:21', 'completed', NULL, 'COD', NULL),
(12, 2, '2026-02-13 04:48:29', 'completed', NULL, 'COD', NULL),
(13, 3, '2026-02-20 04:48:29', 'completed', NULL, 'COD', NULL),
(14, 6, '2026-03-01 04:48:29', 'completed', NULL, 'COD', NULL),
(15, 6, '2026-02-05 04:48:29', 'completed', NULL, 'COD', NULL),
(16, 7, '2026-02-14 04:48:29', 'completed', NULL, 'COD', NULL),
(17, 7, '2026-02-14 04:48:29', 'completed', NULL, 'COD', NULL),
(18, 7, '2026-02-19 04:48:29', 'completed', NULL, 'COD', NULL),
(19, 8, '2026-02-08 04:48:29', 'completed', NULL, 'COD', NULL),
(20, 8, '2026-02-05 04:48:29', 'completed', NULL, 'COD', NULL),
(21, 8, '2026-03-01 04:48:29', 'completed', NULL, 'COD', NULL),
(22, 9, '2026-02-06 04:48:29', 'completed', NULL, 'COD', NULL),
(23, 9, '2026-02-06 04:48:29', 'completed', NULL, 'COD', NULL),
(24, 10, '2026-02-21 04:48:29', 'completed', NULL, 'COD', NULL),
(25, 11, '2026-03-03 04:48:29', 'completed', NULL, 'COD', NULL),
(26, 11, '2026-02-14 04:48:29', 'completed', NULL, 'COD', NULL),
(27, 12, '2026-03-03 04:48:29', 'completed', NULL, 'COD', NULL),
(28, 13, '2026-02-15 04:48:29', 'completed', NULL, 'COD', NULL),
(29, 13, '2026-02-13 04:48:29', 'completed', NULL, 'COD', NULL),
(30, 14, '2026-03-06 04:48:29', 'completed', NULL, 'COD', NULL),
(31, 14, '2026-03-03 04:48:29', 'completed', NULL, 'COD', NULL),
(32, 15, '2026-02-11 04:48:29', 'completed', NULL, 'COD', NULL),
(33, 16, '2026-02-20 04:48:29', 'completed', NULL, 'COD', NULL),
(34, 16, '2026-02-21 04:48:29', 'completed', NULL, 'COD', NULL),
(35, 17, '2026-03-02 04:48:29', 'completed', NULL, 'COD', NULL),
(36, 17, '2026-02-25 04:48:29', 'completed', NULL, 'COD', NULL),
(37, 17, '2026-02-25 04:48:29', 'completed', NULL, 'COD', NULL),
(38, 18, '2026-02-06 04:48:29', 'completed', NULL, 'COD', NULL),
(39, 18, '2026-02-09 04:48:29', 'completed', NULL, 'COD', NULL),
(40, 18, '2026-02-16 04:48:29', 'completed', NULL, 'COD', NULL),
(41, 19, '2026-03-05 04:48:29', 'completed', NULL, 'COD', NULL),
(42, 20, '2026-02-13 04:48:29', 'completed', NULL, 'COD', NULL),
(43, 20, '2026-02-12 04:48:29', 'completed', NULL, 'COD', NULL),
(44, 21, '2026-03-04 04:48:29', 'completed', NULL, 'COD', NULL),
(45, 22, '2026-02-20 04:48:29', 'completed', NULL, 'COD', NULL),
(46, 22, '2026-02-19 04:48:29', 'completed', NULL, 'COD', NULL),
(47, 22, '2026-03-02 04:48:29', 'completed', NULL, 'COD', NULL),
(48, 23, '2026-03-03 04:48:29', 'completed', NULL, 'COD', NULL),
(49, 24, '2026-02-24 04:48:29', 'completed', NULL, 'COD', NULL),
(50, 25, '2026-03-06 04:48:29', 'completed', NULL, 'COD', NULL),
(51, 26, '2026-02-24 04:48:29', 'completed', NULL, 'COD', NULL),
(52, 26, '2026-02-20 04:48:29', 'completed', NULL, 'COD', NULL),
(53, 27, '2026-02-19 04:48:29', 'completed', NULL, 'COD', NULL),
(54, 27, '2026-03-04 04:48:29', 'completed', NULL, 'COD', NULL),
(55, 27, '2026-02-28 04:48:29', 'completed', NULL, 'COD', NULL),
(56, 2, '2024-03-09 01:15:50', 'completed', NULL, 'COD', NULL),
(57, 2, '2025-05-15 16:27:45', 'completed', NULL, 'COD', NULL),
(58, 2, '2023-02-28 13:12:30', 'completed', NULL, 'COD', NULL),
(59, 2, '2025-06-15 19:31:27', 'completed', NULL, 'COD', NULL),
(60, 2, '2022-05-01 09:21:37', 'completed', NULL, 'COD', NULL),
(61, 2, '2025-02-23 06:48:46', 'completed', NULL, 'COD', NULL),
(62, 2, '2025-11-22 09:53:56', 'completed', NULL, 'COD', NULL),
(63, 3, '2022-09-15 17:43:12', 'completed', NULL, 'COD', NULL),
(64, 3, '2024-10-05 09:16:22', 'completed', NULL, 'COD', NULL),
(65, 3, '2025-03-11 13:39:11', 'completed', NULL, 'COD', NULL),
(66, 6, '2024-04-01 15:31:09', 'completed', NULL, 'COD', NULL),
(67, 6, '2026-09-07 01:08:45', 'completed', NULL, 'COD', NULL),
(68, 6, '2023-04-08 00:43:19', 'completed', NULL, 'COD', NULL),
(69, 6, '2024-03-03 06:13:27', 'completed', NULL, 'COD', NULL),
(70, 6, '2026-04-11 04:04:14', 'completed', NULL, 'COD', NULL),
(71, 6, '2024-08-15 13:09:14', 'completed', NULL, 'COD', NULL),
(72, 6, '2024-01-22 20:23:36', 'completed', NULL, 'COD', NULL),
(73, 7, '2023-02-01 09:33:01', 'completed', NULL, 'COD', NULL),
(74, 7, '2026-01-24 21:32:36', 'completed', NULL, 'COD', NULL),
(75, 7, '2025-06-01 21:44:20', 'completed', NULL, 'COD', NULL),
(76, 8, '2023-01-12 10:20:06', 'completed', NULL, 'COD', NULL),
(77, 8, '2024-03-11 00:21:12', 'completed', NULL, 'COD', NULL),
(78, 8, '2023-11-22 14:28:17', 'completed', NULL, 'COD', NULL),
(79, 8, '2022-08-22 00:14:43', 'completed', NULL, 'COD', NULL),
(80, 9, '2024-05-08 11:47:42', 'completed', NULL, 'COD', NULL),
(81, 9, '2022-09-22 15:00:53', 'completed', NULL, 'COD', NULL),
(82, 9, '2025-05-04 15:35:46', 'completed', NULL, 'COD', NULL),
(83, 9, '2022-04-08 22:58:17', 'completed', NULL, 'COD', NULL),
(84, 9, '2022-02-22 10:04:36', 'completed', NULL, 'COD', NULL),
(85, 9, '2024-12-03 01:15:16', 'completed', NULL, 'COD', NULL),
(86, 9, '2022-04-12 19:04:00', 'completed', NULL, 'COD', NULL),
(87, 10, '2022-05-09 03:20:11', 'completed', NULL, 'COD', NULL),
(88, 10, '2024-01-02 20:59:57', 'completed', NULL, 'COD', NULL),
(89, 10, '2023-08-22 18:13:04', 'completed', NULL, 'COD', NULL),
(90, 11, '2026-05-07 18:36:07', 'completed', NULL, 'COD', NULL),
(91, 11, '2024-08-26 07:38:44', 'completed', NULL, 'COD', NULL),
(92, 11, '2026-09-11 20:10:45', 'completed', NULL, 'COD', NULL),
(93, 11, '2024-06-26 14:53:40', 'completed', NULL, 'COD', NULL),
(94, 11, '2022-11-04 16:48:39', 'completed', NULL, 'COD', NULL),
(95, 12, '2025-05-28 13:22:57', 'completed', NULL, 'COD', NULL),
(96, 12, '2026-03-15 16:25:13', 'completed', NULL, 'COD', NULL),
(97, 12, '2025-12-18 00:09:34', 'completed', NULL, 'COD', NULL),
(98, 12, '2026-10-18 18:50:35', 'completed', NULL, 'COD', NULL),
(99, 12, '2024-08-31 18:32:08', 'completed', NULL, 'COD', NULL),
(100, 12, '2023-07-05 23:07:51', 'completed', NULL, 'COD', NULL),
(101, 13, '2022-06-14 15:47:40', 'completed', NULL, 'COD', NULL),
(102, 13, '2022-07-09 11:58:08', 'completed', NULL, 'COD', NULL),
(103, 13, '2022-02-13 00:41:59', 'completed', NULL, 'COD', NULL),
(104, 14, '2022-04-23 08:01:54', 'completed', NULL, 'COD', NULL),
(105, 14, '2022-04-18 15:30:13', 'completed', NULL, 'COD', NULL),
(106, 14, '2023-10-07 09:40:40', 'completed', NULL, 'COD', NULL),
(107, 14, '2023-12-15 18:06:48', 'completed', NULL, 'COD', NULL),
(108, 14, '2025-01-12 13:14:22', 'completed', NULL, 'COD', NULL),
(109, 14, '2026-06-19 07:59:33', 'completed', NULL, 'COD', NULL),
(110, 14, '2026-02-08 09:40:47', 'completed', NULL, 'COD', NULL),
(111, 15, '2023-10-20 12:46:46', 'completed', NULL, 'COD', NULL),
(112, 15, '2026-09-06 09:42:56', 'completed', NULL, 'COD', NULL),
(113, 15, '2025-06-11 20:35:40', 'completed', NULL, 'COD', NULL),
(114, 15, '2026-05-28 09:51:01', 'completed', NULL, 'COD', NULL),
(115, 15, '2023-12-11 03:04:44', 'completed', NULL, 'COD', NULL),
(116, 15, '2026-03-06 23:04:32', 'completed', NULL, 'COD', NULL),
(117, 15, '2026-10-22 17:15:00', 'completed', NULL, 'COD', NULL),
(118, 16, '2026-11-15 04:36:13', 'completed', NULL, 'COD', NULL),
(119, 16, '2024-06-23 13:00:16', 'completed', NULL, 'COD', NULL),
(120, 16, '2026-02-19 05:14:33', 'completed', NULL, 'COD', NULL),
(121, 16, '2026-05-13 16:37:02', 'completed', NULL, 'COD', NULL),
(122, 16, '2024-05-27 13:54:33', 'completed', NULL, 'COD', NULL),
(123, 17, '2023-05-11 13:35:13', 'completed', NULL, 'COD', NULL),
(124, 17, '2026-12-12 12:11:10', 'completed', NULL, 'COD', NULL),
(125, 17, '2022-11-01 18:45:40', 'completed', NULL, 'COD', NULL),
(126, 17, '2023-07-16 07:23:00', 'completed', NULL, 'COD', NULL),
(127, 18, '2022-08-04 19:04:20', 'completed', NULL, 'COD', NULL),
(128, 18, '2023-01-22 12:05:33', 'completed', NULL, 'COD', NULL),
(129, 18, '2022-05-15 11:04:09', 'completed', NULL, 'COD', NULL),
(130, 18, '2025-01-15 22:23:06', 'completed', NULL, 'COD', NULL),
(131, 19, '2023-10-07 13:27:24', 'completed', NULL, 'COD', NULL),
(132, 19, '2023-11-12 09:37:40', 'completed', NULL, 'COD', NULL),
(133, 19, '2025-05-17 13:26:53', 'completed', NULL, 'COD', NULL),
(134, 20, '2026-01-26 20:40:38', 'completed', NULL, 'COD', NULL),
(135, 20, '2022-11-02 20:48:28', 'completed', NULL, 'COD', NULL),
(136, 20, '2025-02-14 04:13:25', 'completed', NULL, 'COD', NULL),
(137, 20, '2024-01-07 16:41:07', 'completed', NULL, 'COD', NULL),
(138, 20, '2022-11-20 02:37:49', 'completed', NULL, 'COD', NULL),
(139, 20, '2022-10-19 11:54:44', 'completed', NULL, 'COD', NULL),
(140, 21, '2025-07-03 01:14:56', 'completed', NULL, 'COD', NULL),
(141, 21, '2025-12-05 11:48:25', 'completed', NULL, 'COD', NULL),
(142, 21, '2023-08-24 05:07:54', 'completed', NULL, 'COD', NULL),
(143, 21, '2023-10-19 04:16:05', 'completed', NULL, 'COD', NULL),
(144, 22, '2023-01-31 21:02:21', 'completed', NULL, 'COD', NULL),
(145, 22, '2025-03-20 17:53:10', 'completed', NULL, 'COD', NULL),
(146, 22, '2022-10-15 19:39:21', 'completed', NULL, 'COD', NULL),
(147, 22, '2025-08-22 06:09:53', 'completed', NULL, 'COD', NULL),
(148, 22, '2025-08-22 17:38:25', 'completed', NULL, 'COD', NULL),
(149, 22, '2025-10-24 08:52:21', 'completed', NULL, 'COD', NULL),
(150, 22, '2025-09-06 07:05:27', 'completed', NULL, 'COD', NULL),
(151, 23, '2024-05-24 07:05:41', 'completed', NULL, 'COD', NULL),
(152, 23, '2022-06-21 20:13:06', 'completed', NULL, 'COD', NULL),
(153, 23, '2026-09-22 09:12:27', 'completed', NULL, 'COD', NULL),
(154, 23, '2024-09-06 14:39:33', 'completed', NULL, 'COD', NULL),
(155, 23, '2022-08-13 00:59:08', 'completed', NULL, 'COD', NULL),
(156, 24, '2023-07-16 00:45:37', 'completed', NULL, 'COD', NULL),
(157, 24, '2023-05-08 02:29:33', 'completed', NULL, 'COD', NULL),
(158, 24, '2023-07-16 05:31:58', 'completed', NULL, 'COD', NULL),
(159, 24, '2026-04-16 22:59:09', 'completed', NULL, 'COD', NULL),
(160, 24, '2024-03-28 03:32:43', 'completed', NULL, 'COD', NULL),
(161, 24, '2024-10-12 22:08:38', 'completed', NULL, 'COD', NULL),
(162, 24, '2023-02-01 12:23:11', 'completed', NULL, 'COD', NULL),
(163, 25, '2024-04-19 21:37:52', 'completed', NULL, 'COD', NULL),
(164, 25, '2026-11-21 10:00:41', 'completed', NULL, 'COD', NULL),
(165, 25, '2026-03-22 13:28:40', 'completed', NULL, 'COD', NULL),
(166, 25, '2022-02-09 10:14:32', 'completed', NULL, 'COD', NULL),
(167, 26, '2026-04-24 18:04:12', 'completed', NULL, 'COD', NULL),
(168, 26, '2023-08-25 18:32:27', 'completed', NULL, 'COD', NULL),
(169, 26, '2026-04-13 19:23:53', 'completed', NULL, 'COD', NULL),
(170, 27, '2022-03-09 10:29:10', 'completed', NULL, 'COD', NULL),
(171, 27, '2025-11-12 23:16:18', 'completed', NULL, 'COD', NULL),
(172, 27, '2022-10-20 22:20:17', 'completed', NULL, 'COD', NULL),
(173, 27, '2025-11-25 10:20:59', 'completed', NULL, 'COD', NULL),
(174, 27, '2026-11-12 10:32:38', 'completed', NULL, 'COD', NULL),
(175, 3, '2026-03-13 01:19:15', 'completed', NULL, 'cash', NULL),
(176, 3, '2026-03-13 03:33:39', 'completed', NULL, 'cash', NULL),
(177, 3, '2026-03-20 10:14:00', 'completed', NULL, 'cash', NULL),
(178, 3, '2026-03-20 10:39:15', 'completed', NULL, 'cash', NULL),
(179, 3, '2026-03-20 10:42:31', 'completed', NULL, 'cash', NULL),
(180, 31, '2026-03-20 12:38:54', 'completed', NULL, 'cash', NULL),
(181, 31, '2026-03-20 12:57:33', 'completed', NULL, 'cash', NULL),
(182, 3, '2026-03-21 06:56:38', 'completed', NULL, 'gcash', '32244824274238'),
(183, 3, '2026-03-21 07:03:36', 'completed', NULL, 'cod', NULL),
(184, 3, '2026-03-21 07:08:26', 'completed', NULL, 'gcash', '2372285244323323'),
(185, 3, '2026-03-21 18:27:04', 'completed', NULL, 'cod', NULL),
(186, 3, '2026-03-21 19:12:05', 'completed', NULL, 'cod', NULL),
(187, 3, '2026-03-21 19:15:23', 'completed', '2026-03-21 19:16:03', 'cod', NULL),
(188, 3, '2026-03-21 19:18:33', 'completed', '2026-03-21 19:18:49', 'gcash', '8374232492582'),
(189, 34, '2026-03-21 19:39:27', 'completed', '2026-03-21 19:41:08', 'cod', NULL),
(190, 3, '2026-03-21 20:34:01', 'completed', '2026-03-21 20:34:45', 'cod', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_detail_id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `product_id` bigint UNSIGNED DEFAULT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_detail_id`, `order_id`, `product_id`, `quantity`) VALUES
(6, 6, 6, 2),
(7, 7, 7, 1),
(8, 8, 5, 1),
(9, 9, 7, 1),
(10, 9, 8, 1),
(11, 10, 7, 1),
(12, 12, 7, 3),
(13, 12, 10, 2),
(14, 12, 11, 3),
(15, 13, 8, 1),
(16, 13, 9, 3),
(17, 13, 11, 3),
(18, 14, 9, 3),
(19, 15, 5, 2),
(20, 15, 10, 3),
(21, 15, 11, 3),
(22, 16, 6, 1),
(23, 16, 10, 3),
(24, 17, 10, 3),
(25, 18, 5, 3),
(26, 18, 8, 1),
(27, 18, 9, 1),
(28, 19, 8, 1),
(29, 19, 11, 2),
(30, 20, 10, 1),
(31, 21, 7, 1),
(32, 21, 8, 3),
(33, 22, 5, 1),
(34, 22, 6, 3),
(35, 22, 10, 2),
(36, 22, 11, 2),
(37, 23, 5, 3),
(38, 23, 7, 3),
(39, 23, 8, 3),
(40, 24, 8, 1),
(41, 24, 9, 3),
(42, 25, 6, 2),
(43, 25, 7, 2),
(44, 25, 8, 3),
(45, 25, 9, 1),
(46, 26, 7, 1),
(47, 26, 9, 2),
(48, 26, 10, 2),
(49, 27, 7, 3),
(50, 27, 8, 2),
(51, 28, 7, 3),
(52, 28, 8, 1),
(53, 28, 10, 3),
(54, 29, 7, 1),
(55, 29, 8, 3),
(56, 30, 6, 1),
(57, 30, 7, 2),
(58, 30, 10, 1),
(59, 31, 5, 1),
(60, 31, 9, 1),
(61, 32, 5, 1),
(62, 32, 10, 3),
(63, 33, 8, 2),
(64, 33, 9, 3),
(65, 34, 5, 1),
(66, 34, 6, 3),
(67, 35, 5, 3),
(68, 35, 6, 1),
(69, 35, 10, 3),
(70, 35, 11, 1),
(71, 36, 8, 3),
(72, 37, 11, 2),
(73, 38, 6, 2),
(74, 38, 8, 1),
(75, 39, 8, 2),
(76, 39, 10, 1),
(77, 40, 8, 1),
(78, 40, 10, 1),
(79, 41, 5, 2),
(80, 41, 6, 2),
(81, 41, 8, 2),
(82, 41, 10, 2),
(83, 42, 5, 3),
(84, 42, 7, 1),
(85, 42, 9, 3),
(86, 42, 10, 3),
(87, 43, 5, 1),
(88, 43, 6, 3),
(89, 43, 11, 2),
(90, 44, 8, 1),
(91, 45, 9, 2),
(92, 45, 10, 2),
(93, 46, 6, 3),
(94, 46, 8, 1),
(95, 46, 11, 1),
(96, 47, 11, 2),
(97, 48, 9, 2),
(98, 49, 6, 3),
(99, 49, 9, 1),
(100, 49, 10, 3),
(101, 49, 11, 2),
(102, 50, 9, 2),
(103, 50, 11, 3),
(104, 51, 5, 1),
(105, 51, 9, 2),
(106, 51, 11, 2),
(107, 52, 5, 1),
(108, 52, 6, 1),
(109, 52, 7, 1),
(110, 53, 5, 2),
(111, 53, 6, 2),
(112, 53, 9, 2),
(113, 53, 10, 1),
(114, 54, 11, 3),
(115, 55, 9, 2),
(116, 55, 10, 2),
(117, 55, 11, 2),
(118, 56, 5, 1),
(119, 56, 7, 3),
(120, 56, 9, 3),
(121, 57, 5, 3),
(122, 57, 6, 1),
(123, 57, 10, 1),
(124, 58, 5, 3),
(125, 58, 7, 1),
(126, 58, 10, 3),
(127, 59, 6, 1),
(128, 59, 11, 3),
(129, 60, 7, 3),
(130, 61, 5, 3),
(131, 62, 6, 1),
(132, 63, 6, 3),
(133, 63, 7, 2),
(134, 64, 5, 1),
(135, 65, 5, 1),
(136, 65, 7, 1),
(137, 66, 6, 3),
(138, 66, 7, 1),
(139, 66, 10, 2),
(140, 67, 7, 3),
(141, 67, 9, 1),
(142, 68, 8, 1),
(143, 68, 11, 2),
(144, 69, 5, 1),
(145, 69, 6, 2),
(146, 69, 8, 3),
(147, 70, 7, 1),
(148, 71, 7, 2),
(149, 71, 8, 2),
(150, 71, 9, 2),
(151, 71, 10, 2),
(152, 72, 8, 2),
(153, 72, 10, 2),
(154, 73, 6, 2),
(155, 73, 7, 1),
(156, 74, 6, 2),
(157, 74, 7, 3),
(158, 74, 9, 2),
(159, 75, 5, 3),
(160, 76, 9, 2),
(161, 77, 5, 3),
(162, 78, 5, 3),
(163, 78, 7, 1),
(164, 78, 9, 1),
(165, 79, 6, 2),
(166, 79, 8, 3),
(167, 79, 9, 1),
(168, 79, 11, 1),
(169, 80, 5, 3),
(170, 80, 6, 1),
(171, 80, 7, 1),
(172, 80, 11, 3),
(173, 81, 6, 2),
(174, 81, 9, 1),
(175, 81, 10, 2),
(176, 81, 11, 3),
(177, 82, 5, 1),
(178, 82, 7, 2),
(179, 82, 8, 1),
(180, 82, 11, 3),
(181, 83, 7, 1),
(182, 84, 6, 3),
(183, 84, 8, 1),
(184, 84, 11, 1),
(185, 85, 6, 1),
(186, 85, 7, 1),
(187, 85, 11, 2),
(188, 86, 8, 3),
(189, 87, 8, 2),
(190, 87, 10, 1),
(191, 88, 10, 2),
(192, 89, 5, 2),
(193, 89, 6, 2),
(194, 89, 8, 3),
(195, 89, 11, 3),
(196, 90, 8, 3),
(197, 91, 6, 2),
(198, 91, 7, 3),
(199, 91, 11, 1),
(200, 92, 7, 2),
(201, 92, 9, 2),
(202, 92, 11, 3),
(203, 93, 5, 2),
(204, 93, 6, 1),
(205, 93, 7, 3),
(206, 93, 11, 3),
(207, 94, 11, 1),
(208, 95, 6, 3),
(209, 95, 11, 3),
(210, 96, 6, 3),
(211, 96, 10, 2),
(212, 97, 6, 2),
(213, 97, 8, 2),
(214, 98, 8, 1),
(215, 98, 11, 2),
(216, 99, 11, 3),
(217, 100, 9, 1),
(218, 100, 10, 1),
(219, 101, 6, 2),
(220, 101, 9, 3),
(221, 102, 5, 3),
(222, 102, 7, 2),
(223, 102, 9, 1),
(224, 102, 10, 1),
(225, 103, 6, 2),
(226, 103, 8, 2),
(227, 103, 11, 3),
(228, 104, 9, 1),
(229, 104, 10, 3),
(230, 105, 6, 1),
(231, 106, 9, 3),
(232, 107, 6, 2),
(233, 107, 10, 3),
(234, 107, 11, 2),
(235, 108, 5, 1),
(236, 108, 6, 1),
(237, 108, 9, 3),
(238, 108, 10, 2),
(239, 109, 6, 1),
(240, 109, 9, 3),
(241, 109, 10, 1),
(242, 109, 11, 1),
(243, 110, 6, 3),
(244, 110, 11, 2),
(245, 111, 8, 3),
(246, 111, 11, 1),
(247, 112, 10, 2),
(248, 113, 6, 2),
(249, 113, 9, 1),
(250, 113, 10, 2),
(251, 114, 5, 1),
(252, 114, 8, 3),
(253, 114, 11, 2),
(254, 115, 6, 1),
(255, 115, 11, 3),
(256, 116, 10, 3),
(257, 117, 5, 2),
(258, 117, 10, 2),
(259, 118, 5, 3),
(260, 118, 6, 3),
(261, 118, 7, 1),
(262, 118, 10, 1),
(263, 119, 10, 1),
(264, 120, 5, 2),
(265, 120, 6, 2),
(266, 121, 7, 1),
(267, 122, 5, 3),
(268, 122, 6, 1),
(269, 122, 10, 1),
(270, 122, 11, 3),
(271, 123, 8, 1),
(272, 124, 6, 3),
(273, 124, 7, 2),
(274, 124, 10, 1),
(275, 124, 11, 1),
(276, 125, 9, 3),
(277, 125, 11, 1),
(278, 126, 7, 2),
(279, 126, 9, 1),
(280, 126, 10, 2),
(281, 127, 5, 1),
(282, 127, 7, 3),
(283, 127, 9, 1),
(284, 127, 10, 3),
(285, 128, 6, 3),
(286, 128, 10, 2),
(287, 129, 7, 1),
(288, 129, 10, 3),
(289, 129, 11, 1),
(290, 130, 5, 2),
(291, 130, 6, 2),
(292, 130, 7, 1),
(293, 130, 8, 3),
(294, 131, 6, 2),
(295, 131, 11, 1),
(296, 132, 5, 2),
(297, 132, 6, 2),
(298, 132, 7, 2),
(299, 132, 11, 3),
(300, 133, 8, 2),
(301, 134, 6, 2),
(302, 134, 10, 2),
(303, 134, 11, 1),
(304, 135, 6, 2),
(305, 135, 9, 3),
(306, 135, 10, 2),
(307, 135, 11, 3),
(308, 136, 5, 3),
(309, 136, 8, 3),
(310, 136, 10, 2),
(311, 137, 8, 3),
(312, 138, 5, 3),
(313, 138, 9, 3),
(314, 138, 11, 3),
(315, 139, 7, 2),
(316, 139, 10, 3),
(317, 140, 6, 2),
(318, 140, 7, 2),
(319, 140, 9, 1),
(320, 140, 10, 3),
(321, 141, 11, 1),
(322, 142, 7, 3),
(323, 143, 6, 1),
(324, 143, 7, 3),
(325, 143, 8, 1),
(326, 144, 6, 2),
(327, 144, 9, 3),
(328, 144, 10, 2),
(329, 144, 11, 1),
(330, 145, 7, 3),
(331, 145, 8, 3),
(332, 145, 9, 1),
(333, 145, 10, 1),
(334, 146, 8, 3),
(335, 147, 7, 3),
(336, 147, 8, 2),
(337, 147, 9, 2),
(338, 147, 10, 1),
(339, 148, 8, 1),
(340, 148, 9, 1),
(341, 148, 11, 2),
(342, 149, 6, 1),
(343, 149, 7, 1),
(344, 149, 9, 1),
(345, 150, 5, 2),
(346, 150, 10, 3),
(347, 151, 5, 1),
(348, 151, 6, 3),
(349, 151, 7, 1),
(350, 152, 5, 3),
(351, 152, 6, 3),
(352, 152, 8, 2),
(353, 152, 10, 1),
(354, 153, 9, 1),
(355, 153, 11, 2),
(356, 154, 8, 3),
(357, 155, 5, 1),
(358, 155, 6, 1),
(359, 155, 8, 3),
(360, 156, 7, 1),
(361, 156, 8, 1),
(362, 156, 10, 1),
(363, 157, 5, 2),
(364, 157, 11, 3),
(365, 158, 5, 3),
(366, 158, 8, 1),
(367, 158, 11, 1),
(368, 159, 6, 1),
(369, 159, 10, 3),
(370, 160, 8, 1),
(371, 160, 9, 1),
(372, 160, 10, 3),
(373, 160, 11, 3),
(374, 161, 9, 2),
(375, 162, 8, 1),
(376, 163, 9, 3),
(377, 163, 10, 1),
(378, 163, 11, 2),
(379, 164, 5, 3),
(380, 164, 11, 3),
(381, 165, 8, 3),
(382, 166, 6, 2),
(383, 166, 8, 1),
(384, 166, 9, 2),
(385, 167, 5, 3),
(386, 167, 6, 1),
(387, 167, 9, 1),
(388, 168, 5, 3),
(389, 169, 9, 2),
(390, 170, 6, 2),
(391, 170, 8, 1),
(392, 170, 10, 3),
(393, 170, 11, 3),
(394, 171, 6, 1),
(395, 171, 7, 3),
(396, 171, 8, 3),
(397, 171, 9, 2),
(398, 172, 6, 1),
(399, 173, 7, 1),
(400, 173, 10, 3),
(401, 174, 5, 2),
(402, 174, 6, 3),
(403, 174, 10, 1),
(404, 174, 11, 3),
(405, 175, 12, 1),
(406, 176, 5, 1),
(407, 176, 11, 1),
(408, 176, 14, 1),
(409, 177, 5, 1),
(410, 177, 9, 1),
(411, 177, 14, 2),
(412, 178, 5, 1),
(413, 178, 8, 1),
(414, 178, 12, 1),
(415, 179, 14, 5),
(416, 180, 5, 1),
(417, 180, 7, 1),
(418, 181, 19, 1),
(419, 182, 14, 1),
(420, 183, 13, 1),
(421, 184, 19, 1),
(422, 185, 14, 1),
(423, 186, 7, 1),
(424, 187, 8, 1),
(425, 188, 6, 2),
(426, 189, 7, 1),
(427, 189, 11, 1),
(428, 190, 18, 10);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` bigint UNSIGNED NOT NULL,
  `product_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `supplier_id` bigint UNSIGNED DEFAULT NULL,
  `initial_price` decimal(10,2) DEFAULT NULL,
  `selling_price` decimal(10,2) DEFAULT NULL,
  `stock_quantity` int NOT NULL DEFAULT '0',
  `variant` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `description`, `category_id`, `supplier_id`, `initial_price`, `selling_price`, `stock_quantity`, `variant`, `is_active`, `deleted_at`) VALUES
(5, 'Quartus', 'Quartus is a fresh yet slightly woody fragrance that combines crisp notes with a gentle musky base. It gives off a clean, relaxed vibe that is both approachable and subtly refined.', 1, 1, 2500.00, 3000.00, 9, '50ml', 1, NULL),
(6, 'Quintus', 'Quintus is a rich, sophisticated fragrance featuring deep woods, amber, and a touch of sweetness. It delivers a warm, luxurious aura that feels confident, mature, and long-lasting.', 1, 1, 4000.00, 4500.00, 48, '100ml', 1, NULL),
(7, 'Sucundus', 'Sucundus is a balanced and refined fragrance that blends fresh citrus with soft woods and subtle spices. It offers a smooth, versatile scent that feels modern, clean, and effortlessly elegant.', 3, 1, 5600.00, 7000.00, 47, '50ml', 1, NULL),
(8, 'Fire', 'Fire is a bold, intense scent profile built around warm spices, smoky accords, and burning woods. It feels powerful and energetic, leaving a fiery, captivating trail that commands attention.', 1, 1, 300.00, 3050.00, 49, '100ml', 1, NULL),
(9, 'Elixir', 'Elixir is a rich, concentrated fragrance style known for its deep, intense blend of sweet, spicy, and woody notes. It feels bold and long-lasting, often leaving a warm, seductive trail with a luxurious, almost syrupy depth.', 3, 2, 900.00, 1000.00, 50, '50ml', 1, NULL),
(10, 'Naxos', 'Naxos is a warm, aromatic fragrance that blends honey, tobacco, and vanilla with fresh citrus and lavender for a rich yet smooth scent. It delivers a luxurious, slightly sweet and spicy profile that feels both elegant and comforting.', 1, 1, 9000.00, 10000.00, 10, '50ml', 1, NULL),
(11, 'Masc', 'Masc is a bold, masculine fragrance profile characterized by strong woody, spicy, and musky notes that create a confident and powerful scent. It often feels warm, deep, and long-lasting, giving off a rugged yet refined vibe.', 3, 1, 9000.00, 10500.00, 49, '100ml', 1, NULL),
(12, 'White', 'White is a light, clean fragrance profile often associated with fresh florals, soft musk, and powdery notes that create a pure and airy scent. It gives off a subtle, elegant vibe that feels calm, refined, and effortlessly fresh.', 2, 1, 900.00, 1100.00, 100, '50ml', 1, NULL),
(13, 'Initio', 'Initio is a luxury fragrance house known for its bold, sensual compositions that blend powerful ingredients like oud, musk, and spices into captivating scents. Its perfumes are designed to evoke emotion and attraction, often delivering long-lasting, intense, and mysterious olfactory experiences.', 2, 2, 4000.00, 5500.00, 99, '50ml', 1, NULL),
(14, 'Ice', 'Ice is a fresh, clean scent profile that captures the feeling of coolness and clarity, often featuring notes like mint, citrus, and aquatic accords. It gives off a crisp, energizing vibe that feels refreshing and modern, perfect for everyday wear.', 2, 1, 7000.00, 9000.00, 3, '50ml', 1, NULL),
(15, 'aa', 'asdwadsawssd', 3, 1, 2000.00, 4500.00, 10, '50ml', 1, '2026-03-18 20:24:53'),
(16, 'sample1', 'awdadnwaawdaawd', 1, 2, 50.00, 100.00, 15, '50ml', 1, '2026-03-20 19:07:13'),
(17, 'sample2', NULL, NULL, NULL, NULL, NULL, 10, NULL, 1, '2026-03-21 03:27:07'),
(18, 'Byredo', 'a hauntingly graceful composition that captures the resilient beauty of the xeric flower blooming in the arid desert. The scent opens with a transparent sweetness of ambrette and fresh sapodilla, eventually settling into a sophisticated, powdery finish of sandalwood and crisp amber.', 3, 2, 7000.00, 8000.00, 10, '100ml', 1, NULL),
(19, 'Oud Royale Intense', 'Oud Royal Intense is a rich, woody-amber fragrance built around deep oud, blended with warm spices, rose, and smoky incense for a bold and luxurious scent. It leaves a long-lasting, sensual trail of amber, sandalwood, and musk that feels both elegant and mysterious.', 1, 3, 9000.00, 10000.00, 25, '50ml', 1, NULL),
(20, 'category testing delete', 'awdafmwfiwfni', 4, 6, 50.00, 100.00, 10, '50ML', 0, '2026-03-21 20:32:13');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `image_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`image_id`, `product_id`, `image_path`, `uploaded_at`) VALUES
(7, 5, 'products/72FiGYjg9ecLyMajybvgaDTclMi1el2dcjVoAzZS.png', '2026-03-06 06:18:25'),
(18, 15, 'products/oQa4sjdQzRyioHg1UBJy8WKTOsLToHuiJjgogNJN.png', '2026-03-07 04:19:16'),
(19, 15, 'products/QPPOKHqzzMkGxcBeJ30ZGrYqSCwLRVp9vHkswiO6.png', '2026-03-07 04:19:39'),
(20, 15, 'products/bXwXUo95fizhjolK0V9J1FPsqcTQvjYyUWQvDTXt.png', '2026-03-07 04:19:40'),
(21, 6, 'products/03BjD1flpgwgL40WmQsJr7g51zc2v2OK4ZwInKsr.png', '2026-03-07 04:29:14'),
(22, 7, 'products/I7eT2ZVavd4R41fS19UoJML0PlTAGC1Zvtr1SLY0.png', '2026-03-07 04:30:23'),
(23, 8, 'products/htIm52oXfun6kmQ8W4tMdlicPKZQOnjZicKf2z1L.png', '2026-03-07 04:31:21'),
(24, 8, 'products/2wUqUfMAbeJNDq8ECBYWigcdoCmPJ3iNNjh4kthY.png', '2026-03-07 04:31:21'),
(25, 8, 'products/pz5v2Ep3V2rPgY62lJqq8t9SwN1RSlKrMmcQkQU0.png', '2026-03-07 04:31:21'),
(26, 9, 'products/Qxy7bVCLkpTdXQwA0Hx9L5Wc87xYMs89Ra0eAmbb.png', '2026-03-07 04:31:57'),
(27, 10, 'products/fS2zthplKN7ZDym0QoApGEJmSh7J4Ue2OqQsulv3.png', '2026-03-07 04:32:33'),
(28, 10, 'products/mcdfMzpeDY2E6xbLmX9n9AK8oxhycfee1RUYxQFe.png', '2026-03-07 04:32:33'),
(29, 10, 'products/2fJBi2PG6N8dSk9Nwz13Y9YNNQoxfdx2DezsUezK.png', '2026-03-07 04:32:33'),
(30, 11, 'products/RN5C6GE606F0PqaSTjvxvntvKbb5vGwZdvIlAJYv.png', '2026-03-07 04:33:10'),
(31, 11, 'products/LGPMZh8Dk2UcnSQmAshzd465hGeY9sIFC4QEDV6n.png', '2026-03-07 04:33:10'),
(32, 11, 'products/keSbdOaonAT9jSuZGMxuJswJrbd6dfOrWE5kXbGl.png', '2026-03-07 04:33:10'),
(33, 12, 'products/ZtRrn81XRxTmKyxL3QtPtin5vBfUBR7jsRQOmVFI.jpg', '2026-03-07 16:36:35'),
(34, 13, 'products/1iPBryWG53rZwSxnsfompfoPguwEhFHRT4Vt65pq.png', '2026-03-07 16:37:27'),
(36, 14, 'products/wScoDpPZuDyug2rpxnUnuZX7Jdp54NmSzoGoWUUw.png', '2026-03-07 16:38:45'),
(37, 14, 'products/CZy0t7h4kdiVoWey3QhRQPGhuFsnyS2qIN72ifgx.jpg', '2026-03-19 17:12:49'),
(38, 16, 'products/dMXdFiuOtggSdbTC912O5iOAmqJWwKyaSVrGpUDP.jpg', '2026-03-20 03:02:35'),
(41, 16, 'products/JGvpSdp0ERnL3Yu6wMjIeC4rX4Ka4mkGIUVfStBk.png', '2026-03-20 03:17:40'),
(42, 19, 'products/Q7m4HDVGoDZdWsqzN3BFDXPPQGC9A9yeW2HFMYO9.png', '2026-03-20 03:52:48'),
(44, 19, 'products/d7ZX1lrEKNg7l670SHZsTfLcdOzYQP9scGvUo4fC.png', '2026-03-20 03:52:48'),
(45, 18, 'products/h2sy4vtfEqcTclYhMf9JNYDnuXZyPDp3jClKS8DC.png', '2026-03-20 19:28:22'),
(46, 20, 'products/n86xjEnqCY8cx5ymzIGdB2p7yIxbHomYCuz0yRCQ.png', '2026-03-21 04:25:22'),
(48, 19, 'products/5JRpdGeLAVBOmvwkNQ5WlyxQuxd9pNbjpObn2iMl.png', '2026-03-21 04:30:05');

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `review_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `rating` tinyint DEFAULT NULL COMMENT '1 to 5',
  `review_text` text COLLATE utf8mb4_unicode_ci,
  `date_reviewed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`review_id`, `product_id`, `user_id`, `rating`, `review_text`, `date_reviewed`, `last_updated`) VALUES
(2, 5, 7, 3, 'Inventore vel deleniti debitis deleniti aut neque voluptatem. Ea nulla ut sunt.', '2026-01-29 16:48:53', '2026-03-08 00:48:53'),
(3, 7, 7, 3, 'Vero distinctio culpa neque accusamus quia.', '2026-02-05 16:48:53', '2026-03-08 00:48:53'),
(4, 8, 7, 4, 'Id assumenda suscipit qui magni fugit libero beatae eum. Vel magni repudiandae quibusdam.', '2025-09-24 16:48:53', '2026-03-08 00:48:53'),
(5, 7, 2, 5, 'Ipsum reiciendis velit ut dolores est atque eius.', '2025-09-07 16:48:53', '2026-03-08 00:48:53'),
(6, 10, 2, 4, 'Perferendis ipsam recusandae harum corporis veritatis voluptate.', '2025-11-04 16:48:53', '2026-03-08 00:48:53'),
(7, 11, 2, 3, 'Rerum incidunt eum fugiat error ducimus nostrum ea.', '2025-11-26 16:48:53', '2026-03-08 00:48:53'),
(8, 8, 3, 4, 'pogi panget', '2026-03-07 16:56:21', '2026-03-08 00:56:21'),
(9, 9, 3, 4, 'Porro velit sed incidunt temporibus molestias.', '2025-08-03 16:48:53', '2026-03-08 00:48:53'),
(10, 11, 3, 5, 'Qui reprehenderit libero ea expedita saepe esse aut. Reiciendis laborum illo aliquid. Saepe nam magnam possimus quia accusamus velit et.', '2025-08-23 16:48:53', '2026-03-08 00:48:53'),
(11, 9, 6, 3, 'Quae error cum omnis nihil. Et sed in incidunt error enim unde qui. Accusamus adipisci autem repellat voluptates voluptatem dolore harum.', '2026-01-23 16:48:53', '2026-03-08 00:48:53'),
(12, 5, 6, 5, 'Sequi aut ab libero ipsum.', '2025-03-24 16:48:53', '2026-03-08 00:48:53'),
(13, 10, 6, 4, 'Quia hic soluta non expedita eos voluptatibus.', '2026-01-06 16:48:53', '2026-03-08 00:48:53'),
(14, 11, 6, 3, 'Optio ut quaerat repellendus molestiae. Est itaque ipsam qui ducimus dicta. At sint vero et deleniti sint animi et.', '2026-02-06 16:48:53', '2026-03-08 00:48:53'),
(15, 6, 7, 3, 'Suscipit unde omnis quia rerum nihil fugit labore.', '2026-02-19 16:48:53', '2026-03-08 00:48:53'),
(16, 10, 7, 3, 'Sed et ut dignissimos sunt ducimus consequatur sunt. Facilis tempora sed saepe quisquam exercitationem iusto.', '2026-03-04 16:48:53', '2026-03-08 00:48:53'),
(17, 9, 7, 5, 'Et asperiores laboriosam aut et nemo ipsam repudiandae.', '2025-09-11 16:48:53', '2026-03-08 00:48:53'),
(18, 8, 8, 3, 'Quis quia labore ipsum libero et. Quisquam et eum eum doloremque molestiae nisi fugit. Quo voluptate facere a nihil.', '2025-11-16 16:48:53', '2026-03-08 00:48:53'),
(19, 11, 8, 5, 'Quibusdam optio consectetur sapiente rerum quis ea animi.', '2025-09-11 16:48:53', '2026-03-08 00:48:53'),
(20, 10, 8, 3, 'Vel molestiae hic nulla autem et qui.', '2025-04-19 16:48:53', '2026-03-08 00:48:53'),
(21, 7, 8, 3, 'Vel autem odio enim consequatur et necessitatibus non. Enim cum voluptas ducimus tenetur doloremque praesentium.', '2025-09-03 16:48:53', '2026-03-08 00:48:53'),
(22, 5, 9, 3, 'Doloribus incidunt blanditiis mollitia similique id odio.', '2025-08-29 16:48:53', '2026-03-08 00:48:53'),
(23, 6, 9, 5, 'Velit eaque cum ea totam et rem.', '2025-10-09 16:48:53', '2026-03-08 00:48:53'),
(24, 10, 9, 4, 'Ut qui dolores expedita nihil.', '2025-11-17 16:48:53', '2026-03-08 00:48:53'),
(25, 11, 9, 5, 'Molestias fuga quibusdam omnis fuga totam.', '2025-05-03 16:48:53', '2026-03-08 00:48:53'),
(26, 7, 9, 3, 'Qui vel dolore corporis.', '2025-05-29 16:48:53', '2026-03-08 00:48:53'),
(27, 8, 9, 3, 'Nostrum doloremque quis et deserunt ut esse.', '2025-10-28 16:48:53', '2026-03-08 00:48:53'),
(28, 8, 10, 3, 'Nihil qui officiis quis mollitia deleniti autem consequatur. Nam nobis pariatur reprehenderit ut.', '2025-04-04 16:48:53', '2026-03-08 00:48:53'),
(29, 9, 10, 5, 'Velit commodi quidem est odio aut et voluptas. Magni aut sed unde sunt minima.', '2025-12-14 16:48:53', '2026-03-08 00:48:53'),
(30, 6, 11, 4, 'Quaerat repellat reiciendis voluptatem odio.', '2025-09-28 16:48:53', '2026-03-08 00:48:53'),
(31, 7, 11, 3, 'Omnis culpa est magnam iusto cum ab in. Deserunt omnis quis sit fuga mollitia.', '2025-03-16 16:48:53', '2026-03-08 00:48:53'),
(32, 8, 11, 5, 'Eum numquam aliquam sequi ut mollitia. Vel id facilis perferendis fugit cupiditate voluptatem enim. Fugiat deserunt quod earum nihil.', '2025-10-28 16:48:53', '2026-03-08 00:48:53'),
(33, 9, 11, 5, 'Voluptatem mollitia iste consequatur aliquid nisi tempore. Rerum officia consequuntur debitis soluta quisquam fugit.', '2025-10-24 16:48:53', '2026-03-08 00:48:53'),
(34, 10, 11, 3, 'In nihil sapiente consequuntur accusamus.', '2025-07-20 16:48:53', '2026-03-08 00:48:53'),
(35, 7, 12, 5, 'Aliquam dolores nostrum alias sapiente quod.', '2025-06-25 16:48:53', '2026-03-08 00:48:53'),
(36, 8, 12, 3, 'Corrupti amet nemo et dolores velit recusandae. Eum qui et provident eos. Quibusdam rerum qui ut non optio mollitia.', '2025-03-21 16:48:53', '2026-03-08 00:48:53'),
(37, 7, 13, 5, 'Eum pariatur occaecati minima similique expedita. Doloribus quia et ullam reprehenderit ratione sunt amet. Ut est voluptas beatae debitis odit sequi recusandae.', '2025-04-30 16:48:53', '2026-03-08 00:48:53'),
(38, 8, 13, 4, 'Id cum dolor ipsum et doloremque sunt iste. Dicta ut temporibus qui quo ut.', '2025-05-21 16:48:53', '2026-03-08 00:48:53'),
(39, 10, 13, 4, 'Quibusdam repellendus maiores commodi sit quas atque. Vero nesciunt qui vero eum quibusdam.', '2025-11-03 16:48:53', '2026-03-08 00:48:53'),
(40, 6, 14, 3, 'Delectus at architecto voluptas necessitatibus saepe. Assumenda sit maxime aliquid harum natus neque magnam. Ut corrupti perspiciatis saepe aut maiores.', '2025-06-24 16:48:53', '2026-03-08 00:48:53'),
(41, 7, 14, 4, 'Quasi vitae id quibusdam dolores aut rem. Eaque deleniti natus eum necessitatibus. Nulla minima officia dolore est.', '2026-02-05 16:48:53', '2026-03-08 00:48:53'),
(42, 10, 14, 5, 'Nostrum quos rerum rerum. Tempora porro quos sint laborum eveniet inventore.', '2025-10-26 16:48:53', '2026-03-08 00:48:53'),
(43, 5, 14, 5, 'Aut laboriosam rem dolorem modi numquam possimus aut. Sint pariatur est rem impedit autem voluptatem.', '2025-09-08 16:48:53', '2026-03-08 00:48:53'),
(44, 9, 14, 4, 'Sequi quaerat eaque tenetur sit ipsum itaque est dignissimos. Nobis molestiae tempore rem. Aut quod nulla provident assumenda possimus.', '2026-02-07 16:48:53', '2026-03-08 00:48:53'),
(45, 5, 15, 4, 'Amet magni reiciendis enim perferendis facilis est maxime inventore.', '2025-12-08 16:48:53', '2026-03-08 00:48:53'),
(46, 10, 15, 5, 'Est ea ab dolor possimus voluptatum. Laudantium enim qui omnis sunt. Minus est sapiente asperiores non consequatur.', '2025-03-09 16:48:53', '2026-03-08 00:48:53'),
(47, 8, 16, 5, 'Id autem veniam cupiditate hic.', '2026-03-01 16:48:53', '2026-03-08 00:48:53'),
(48, 9, 16, 3, 'Commodi sed ut voluptas eius facere in dolores voluptatem. Eos facere consequatur asperiores ea.', '2026-02-07 16:48:53', '2026-03-08 00:48:53'),
(49, 5, 16, 5, 'Asperiores et qui officiis non numquam labore. Dolore fugiat sit consequatur libero id pariatur. Quia nulla enim magnam iure.', '2025-08-16 16:48:53', '2026-03-08 00:48:53'),
(50, 6, 16, 4, 'Sunt eum eos perferendis quia odio. Eos tempora necessitatibus alias natus quibusdam. Doloribus nostrum nostrum consequuntur ut laudantium ducimus.', '2025-09-16 16:48:53', '2026-03-08 00:48:53'),
(51, 5, 17, 3, 'Voluptas ut repellat et dicta dolorem consectetur atque. Ullam magnam molestias est.', '2025-03-19 16:48:53', '2026-03-08 00:48:53'),
(52, 6, 17, 5, 'Et debitis quod voluptatibus non doloremque.', '2026-01-14 16:48:53', '2026-03-08 00:48:53'),
(53, 10, 17, 3, 'Laudantium facere cupiditate explicabo natus omnis.', '2026-02-13 16:48:53', '2026-03-08 00:48:53'),
(54, 11, 17, 4, 'Velit dolore ipsum id qui esse quis ipsum. Quam dolor similique qui optio voluptatem.', '2026-02-13 16:48:53', '2026-03-08 00:48:53'),
(55, 8, 17, 4, 'Est nostrum odio sed quas deleniti impedit suscipit. Ratione voluptatem esse aut occaecati ipsam officiis.', '2026-02-04 16:48:53', '2026-03-08 00:48:53'),
(56, 6, 18, 3, 'Enim aut dicta aliquam repellat qui est vitae. Delectus qui reprehenderit sapiente molestias et.', '2025-04-07 16:48:53', '2026-03-08 00:48:53'),
(57, 8, 18, 4, 'Voluptatum qui quidem qui. Ex aliquid occaecati voluptas repellat sunt harum ut. Et modi labore ipsam velit.', '2025-07-05 16:48:53', '2026-03-08 00:48:53'),
(58, 10, 18, 5, 'Consequuntur iure quia molestias deserunt quas quia occaecati.', '2025-06-27 16:48:53', '2026-03-08 00:48:53'),
(59, 5, 19, 4, 'Alias aut dolorem labore quia non aut pariatur. Doloremque enim a porro voluptatem ex consequatur.', '2025-09-23 16:48:53', '2026-03-08 00:48:53'),
(60, 6, 19, 4, 'Consectetur quas molestiae placeat molestiae. Occaecati enim voluptate numquam quibusdam vero in.', '2025-04-29 16:48:53', '2026-03-08 00:48:53'),
(61, 8, 19, 5, 'Quisquam non voluptatem soluta quos. Nostrum qui qui consequatur qui sit quisquam ratione. Vitae odio sit saepe tenetur.', '2026-02-12 16:48:53', '2026-03-08 00:48:53'),
(62, 10, 19, 4, 'Ea odit dignissimos enim sed rerum recusandae.', '2026-01-20 16:48:53', '2026-03-08 00:48:53'),
(63, 5, 20, 4, 'Mollitia libero quaerat sit doloremque rem suscipit itaque. Qui dolor quis blanditiis esse voluptate molestias explicabo.', '2025-09-22 16:48:53', '2026-03-08 00:48:53'),
(64, 7, 20, 3, 'Laborum est neque dolorum et dignissimos sed quo.', '2025-10-20 16:48:53', '2026-03-08 00:48:53'),
(65, 9, 20, 5, 'Laborum magni iusto quis.', '2026-01-17 16:48:53', '2026-03-08 00:48:53'),
(66, 10, 20, 3, 'In optio quia a laudantium qui accusamus impedit laboriosam. Qui voluptas rerum fugiat labore expedita quibusdam rem laboriosam. Perferendis eius ea minima sint et molestiae odio.', '2026-01-19 16:48:53', '2026-03-08 00:48:53'),
(67, 6, 20, 4, 'Inventore omnis omnis et molestiae rerum dolores odit.', '2025-10-14 16:48:53', '2026-03-08 00:48:53'),
(68, 11, 20, 4, 'Est voluptatem dolores sunt.', '2025-04-03 16:48:53', '2026-03-08 00:48:53'),
(69, 8, 21, 5, 'Cupiditate quo numquam nam tempora commodi amet magnam aut.', '2025-07-16 16:48:53', '2026-03-08 00:48:53'),
(70, 9, 22, 3, 'Sint voluptates deleniti at eos ut placeat quam aliquam. Non libero reiciendis porro et deleniti. Explicabo a nulla deleniti ea ipsa labore.', '2025-09-24 16:48:53', '2026-03-08 00:48:53'),
(71, 10, 22, 5, 'Autem et possimus tenetur doloribus. Et in voluptatibus nulla laborum. Blanditiis ratione enim ut incidunt qui eaque.', '2025-10-31 16:48:53', '2026-03-08 00:48:53'),
(72, 6, 22, 4, 'Enim id esse occaecati assumenda. Perspiciatis est dolor id quo ipsum rerum.', '2025-08-03 16:48:53', '2026-03-08 00:48:53'),
(73, 8, 22, 3, 'Rem ratione quibusdam rem repellendus voluptatem neque corrupti. Accusamus id et accusamus aut.', '2025-09-03 16:48:53', '2026-03-08 00:48:53'),
(74, 11, 22, 3, 'Voluptas odio saepe pariatur aspernatur ut.', '2025-10-27 16:48:53', '2026-03-08 00:48:53'),
(75, 9, 23, 4, 'Quia eligendi voluptas itaque iste.', '2025-10-05 16:48:53', '2026-03-08 00:48:53'),
(76, 6, 24, 4, 'Fugit est aut consequatur voluptas. Culpa amet aut quisquam ut consequatur eaque sed.', '2025-05-12 16:48:53', '2026-03-08 00:48:53'),
(77, 9, 24, 5, 'Accusantium aut consequatur aliquid quo.', '2025-03-26 16:48:53', '2026-03-08 00:48:53'),
(78, 10, 24, 4, 'Voluptatum quaerat voluptatem iusto nostrum voluptate perspiciatis aperiam debitis.', '2025-08-09 16:48:53', '2026-03-08 00:48:53'),
(79, 11, 24, 4, 'Provident omnis sapiente sint accusantium quasi. Eum repellat itaque id voluptatem. Animi autem provident modi provident odit vel.', '2025-07-04 16:48:53', '2026-03-08 00:48:53'),
(80, 9, 25, 4, 'Aliquam consequatur consequuntur ipsam consequuntur ut eveniet ut cum. Nam possimus quia sapiente doloribus et consequatur.', '2025-06-13 16:48:53', '2026-03-08 00:48:53'),
(81, 11, 25, 3, 'Excepturi dignissimos in sit.', '2025-04-14 16:48:53', '2026-03-08 00:48:53'),
(82, 5, 26, 3, 'Eos quis quia id velit. Corporis deleniti iusto doloremque recusandae. Rerum quia enim molestias voluptates est facilis id.', '2025-09-24 16:48:53', '2026-03-08 00:48:53'),
(83, 9, 26, 4, 'Est fugit esse beatae dolor quod vitae et.', '2025-05-15 16:48:53', '2026-03-08 00:48:53'),
(84, 11, 26, 5, 'Qui dicta placeat et et omnis aliquid.', '2025-03-19 16:48:53', '2026-03-08 00:48:53'),
(85, 6, 26, 4, 'Qui cumque quod maxime accusantium. Ad quisquam cupiditate nihil alias similique iste. Perspiciatis quisquam velit et tempore illo inventore.', '2025-07-03 16:48:54', '2026-03-08 00:48:54'),
(86, 7, 26, 5, 'Mollitia quas perspiciatis non quod maiores et a. Omnis nemo eveniet quos necessitatibus corporis qui sunt.', '2025-11-14 16:48:54', '2026-03-08 00:48:54'),
(87, 5, 27, 4, 'Dolorem aut molestiae voluptas cum atque qui iure.', '2025-06-07 16:48:54', '2026-03-08 00:48:54'),
(88, 6, 27, 4, 'Quae nesciunt quasi quaerat ut.', '2025-05-14 16:48:54', '2026-03-08 00:48:54'),
(89, 9, 27, 3, 'Explicabo sint qui aut aut sit nisi labore. Molestiae voluptas a iste harum eum illo facere.', '2025-12-30 16:48:54', '2026-03-08 00:48:54'),
(91, 11, 27, 4, 'Maxime itaque dolorum quam consequatur commodi non mollitia. Impedit possimus et saepe eius. Delectus eius iure et ipsum odit maxime.', '2025-11-25 16:48:54', '2026-03-08 00:48:54'),
(92, 5, 2, 3, 'Odio repudiandae sunt accusamus consequatur. Nam sint quia quia inventore ipsum sequi aut. Veritatis dolorem animi exercitationem fugiat.', '2025-05-17 16:48:54', '2026-03-08 00:48:54'),
(93, 9, 2, 3, 'Velit rerum unde aut consequatur.', '2025-03-14 16:48:54', '2026-03-08 00:48:54'),
(94, 6, 2, 3, 'Et nihil sit molestiae eveniet assumenda est necessitatibus at. Vel similique cum voluptas quaerat quo id. Aut velit iure velit nesciunt illum natus animi error.', '2025-07-20 16:48:54', '2026-03-08 00:48:54'),
(95, 6, 3, 3, 'Maiores aperiam debitis omnis qui recusandae sed aliquam.', '2025-05-15 16:48:54', '2026-03-08 00:48:54'),
(96, 7, 3, 4, 'Et sit qui itaque alias qui quia.', '2025-05-31 16:48:54', '2026-03-08 00:48:54'),
(97, 5, 3, 3, 'Officia aliquam ad illo sed reprehenderit.', '2025-08-26 16:48:54', '2026-03-08 00:48:54'),
(98, 6, 6, 3, 'Eligendi voluptates molestiae a voluptas aut sint ut. Quo sequi sit labore est. Enim soluta dignissimos mollitia nulla hic.', '2025-06-24 16:48:54', '2026-03-08 00:48:54'),
(99, 7, 6, 5, 'Incidunt id blanditiis omnis provident ad. Asperiores laboriosam eos sunt qui illum aut dolores non.', '2025-09-24 16:48:54', '2026-03-08 00:48:54'),
(100, 8, 6, 4, 'Aliquam sint consequatur nesciunt praesentium non modi id iure. Odio ea magnam iure quod accusantium ullam.', '2025-04-01 16:48:54', '2026-03-08 00:48:54'),
(101, 9, 8, 3, 'Et voluptas ut labore rerum a voluptatem. Nobis repellat placeat tenetur modi dolorem.', '2026-01-22 16:48:54', '2026-03-08 00:48:54'),
(102, 5, 8, 5, 'Sint quas sed modi et est qui.', '2025-12-22 16:48:54', '2026-03-08 00:48:54'),
(103, 6, 8, 4, 'Et occaecati voluptatem non alias.', '2025-10-16 16:48:54', '2026-03-08 00:48:54'),
(104, 9, 9, 3, 'Qui exercitationem repellendus molestiae quo accusantium repellendus. Iusto adipisci deserunt inventore voluptatem. Nemo iste fugiat animi eaque id pariatur sit veritatis.', '2025-07-23 16:48:54', '2026-03-08 00:48:54'),
(105, 10, 10, 4, 'Eos et beatae et sequi ut. Nulla ex maiores corporis amet ex.', '2026-01-01 16:48:54', '2026-03-08 00:48:54'),
(106, 5, 10, 3, 'Nobis quia ex ea ea aut voluptas quis. Ipsam ratione maiores pariatur atque ratione et labore.', '2025-12-21 16:48:54', '2026-03-08 00:48:54'),
(107, 6, 10, 4, 'Eaque perferendis quis eligendi voluptatem tenetur. Atque maxime quia cupiditate qui et.', '2026-02-01 16:48:54', '2026-03-08 00:48:54'),
(108, 11, 10, 3, 'Inventore sunt qui facere voluptatibus vel. Neque quam qui dignissimos aliquid et aut culpa. Voluptas illum ut eaque rerum.', '2025-08-08 16:48:54', '2026-03-08 00:48:54'),
(109, 11, 11, 3, 'Dolores ut non nihil dolorum numquam ullam ea. Cum soluta nam et est commodi maxime.', '2025-06-05 16:48:54', '2026-03-08 00:48:54'),
(110, 5, 11, 4, 'Est sit ipsam ducimus sed ipsam dicta dolor.', '2026-01-18 16:48:54', '2026-03-08 00:48:54'),
(111, 6, 12, 3, 'Eos pariatur labore velit laboriosam aperiam esse ratione.', '2025-11-03 16:48:54', '2026-03-08 00:48:54'),
(112, 11, 12, 5, 'Rerum quo unde quia commodi dolore. Et saepe dolores hic consequuntur error perferendis occaecati voluptas.', '2025-11-13 16:48:54', '2026-03-08 00:48:54'),
(113, 10, 12, 5, 'Et consequatur quos sint corporis et.', '2025-04-17 16:48:54', '2026-03-08 00:48:54'),
(114, 9, 12, 4, 'Illo et eum voluptatem maxime voluptatibus. Doloremque aut nulla dolorum saepe nisi quia quam.', '2025-11-21 16:48:54', '2026-03-08 00:48:54'),
(115, 6, 13, 3, 'Non et dicta adipisci deserunt voluptatem ut officiis. Velit aut nesciunt id quia. Reiciendis in ipsum quo voluptates necessitatibus praesentium.', '2025-11-25 16:48:54', '2026-03-08 00:48:54'),
(116, 9, 13, 3, 'Et ut sit et nostrum enim rerum. Et accusantium ipsum accusamus eveniet. Error maxime voluptas quae vel et expedita.', '2025-03-29 16:48:54', '2026-03-08 00:48:54'),
(117, 5, 13, 4, 'Qui eius sed minima. Sed nisi enim nulla quia. Ea ut dolor modi.', '2026-01-13 16:48:54', '2026-03-08 00:48:54'),
(118, 11, 13, 3, 'Qui minima corporis maxime cupiditate veniam quos dolor quisquam. Molestiae aut minus est voluptatum dicta enim quia. Quis autem ullam fuga quia.', '2025-12-30 16:48:54', '2026-03-08 00:48:54'),
(119, 11, 14, 5, 'Sit et et nesciunt error maxime quibusdam possimus. Qui repudiandae illum rem officia. Molestias minima quia sequi amet.', '2025-11-10 16:48:54', '2026-03-08 00:48:54'),
(120, 8, 15, 5, 'Id ipsum qui voluptatibus nemo quaerat sint. Neque magni cumque numquam vel quis dolores et eos.', '2025-11-18 16:48:54', '2026-03-08 00:48:54'),
(121, 11, 15, 4, 'Ab omnis maxime officiis eum aliquid consequuntur accusantium.', '2026-02-16 16:48:54', '2026-03-08 00:48:54'),
(122, 6, 15, 3, 'Tempore fugit modi molestiae sint magnam atque. Fugit aut aut et adipisci. Voluptatum ipsa fugiat illum tempore.', '2025-09-06 16:48:54', '2026-03-08 00:48:54'),
(123, 9, 15, 4, 'Aut delectus nihil repellat magni. Eaque sapiente est cumque facere similique vero. Dignissimos sit qui fugiat et repellat tempora et quibusdam.', '2025-04-19 16:48:54', '2026-03-08 00:48:54'),
(124, 7, 16, 4, 'Doloribus voluptatem excepturi dolores laboriosam vel.', '2025-05-01 16:48:54', '2026-03-08 00:48:54'),
(125, 10, 16, 5, 'Possimus et quam at voluptatibus. Qui temporibus voluptatem illo aperiam explicabo quo. Et architecto dolorem rem nemo et voluptatem beatae.', '2026-01-29 16:48:54', '2026-03-08 00:48:54'),
(126, 11, 16, 3, 'Quisquam officiis cum reiciendis iste voluptas. Eveniet repudiandae occaecati velit dolorum iure dolor et. Aspernatur provident quo quasi tempora quod et aliquam explicabo.', '2025-10-04 16:48:54', '2026-03-08 00:48:54'),
(127, 7, 17, 5, 'Consectetur repellat magnam officiis dolorem corrupti. Quod magni nostrum fugit non aut laboriosam atque. Modi temporibus voluptas eligendi.', '2025-07-09 16:48:54', '2026-03-08 00:48:54'),
(128, 9, 17, 4, 'Maxime ut excepturi magni. Ut vel commodi nostrum ex voluptas aut. Et et explicabo dolorem dolores.', '2025-09-16 16:48:54', '2026-03-08 00:48:54'),
(129, 5, 18, 4, 'Ad aut id adipisci velit.', '2025-04-30 16:48:54', '2026-03-08 00:48:54'),
(130, 7, 18, 3, 'Nulla libero adipisci omnis.', '2025-05-23 16:48:54', '2026-03-08 00:48:54'),
(131, 9, 18, 3, 'Atque dolorum est deleniti atque. Fugiat commodi maxime ducimus ea esse itaque ipsa quasi. Nemo itaque esse voluptatem quam minima.', '2026-01-13 16:48:54', '2026-03-08 00:48:54'),
(132, 11, 18, 3, 'Saepe vero unde error molestiae ipsa debitis. Error minima consequatur consequatur aut voluptate dolores.', '2025-09-28 16:48:54', '2026-03-08 00:48:54'),
(133, 11, 19, 3, 'Eum dolor velit veniam id non et ea. Ipsum similique voluptates totam ex sed modi.', '2025-09-01 16:48:54', '2026-03-08 00:48:54'),
(134, 7, 19, 3, 'Ad ut dolor possimus dolorum blanditiis tempore sint.', '2025-08-07 16:48:54', '2026-03-08 00:48:54'),
(135, 8, 20, 5, 'Culpa provident ducimus laborum magnam suscipit quaerat. Recusandae eligendi quod distinctio exercitationem.', '2026-02-20 16:48:54', '2026-03-08 00:48:54'),
(136, 6, 21, 5, 'A delectus facere dolorum facere et.', '2025-05-22 16:48:54', '2026-03-08 00:48:54'),
(137, 7, 21, 5, 'Minus atque eius excepturi aliquid. Enim deleniti eum et eius sed sint ratione. Dolores itaque eum dolores exercitationem ducimus.', '2025-05-08 16:48:54', '2026-03-08 00:48:54'),
(138, 9, 21, 5, 'Et omnis unde autem autem eum. Excepturi sit doloremque minima.', '2025-12-02 16:48:54', '2026-03-08 00:48:54'),
(139, 10, 21, 4, 'Nihil excepturi consectetur inventore. Animi sit libero accusamus qui sint et. Enim ut in recusandae omnis.', '2025-03-13 16:48:54', '2026-03-08 00:48:54'),
(140, 11, 21, 5, 'Qui ducimus in magni aut repellendus aperiam.', '2026-01-18 16:48:54', '2026-03-08 00:48:54'),
(141, 7, 22, 5, 'Sit suscipit voluptatem ab quasi voluptatem quo. Assumenda cumque fugit qui nobis occaecati et.', '2025-10-28 16:48:54', '2026-03-08 00:48:54'),
(142, 5, 22, 3, 'Odio odit animi eum eum assumenda iure. Unde fuga eum tempora rerum voluptatem molestiae.', '2025-04-23 16:48:54', '2026-03-08 00:48:54'),
(143, 5, 23, 3, 'Non voluptatibus at impedit sit.', '2025-09-23 16:48:54', '2026-03-08 00:48:54'),
(144, 6, 23, 3, 'Similique sed omnis consequatur aut est. Molestiae consequuntur veniam voluptatem quis.', '2025-04-19 16:48:54', '2026-03-08 00:48:54'),
(145, 7, 23, 3, 'Sint et ad sed nemo. Consequatur ut dolorem cupiditate et. Praesentium ducimus tempora commodi delectus in.', '2025-04-23 16:48:54', '2026-03-08 00:48:54'),
(146, 8, 23, 3, 'Laudantium in qui praesentium dignissimos nisi delectus voluptate.', '2025-07-28 16:48:54', '2026-03-08 00:48:54'),
(148, 11, 23, 5, 'Voluptatibus repellendus eligendi a magni quis voluptate molestiae. Perspiciatis temporibus fugit odit delectus est ut ut consequatur. Saepe doloribus vel nemo et nemo aut.', '2025-10-30 16:48:54', '2026-03-08 00:48:54'),
(149, 7, 24, 3, 'Quis voluptatum laudantium voluptas sapiente sint vel. Labore ex exercitationem ut quidem.', '2025-04-10 16:48:54', '2026-03-08 00:48:54'),
(150, 8, 24, 5, 'Sunt corporis qui voluptates earum tenetur. Occaecati voluptatem aspernatur sunt consectetur deleniti.', '2025-05-03 16:48:54', '2026-03-08 00:48:54'),
(151, 5, 24, 4, 'Qui exercitationem et quam dignissimos iusto molestiae earum esse. Omnis consequatur quidem quo aut.', '2025-11-20 16:48:54', '2026-03-08 00:48:54'),
(153, 5, 25, 4, 'Quas dolore a assumenda quod dignissimos distinctio.', '2025-05-31 16:48:54', '2026-03-08 00:48:54'),
(154, 8, 25, 5, 'Amet omnis incidunt doloremque ea.', '2026-02-18 16:48:54', '2026-03-08 00:48:54'),
(155, 6, 25, 3, 'Rerum voluptatum eveniet eius reiciendis earum voluptas minima qui.', '2025-09-17 16:48:54', '2026-03-08 00:48:54'),
(156, 8, 27, 4, 'Hic ad et qui. Id repudiandae aut tempora accusamus sed explicabo.', '2025-10-20 16:48:54', '2026-03-08 00:48:54'),
(157, 7, 27, 4, 'Officia ab est eius accusantium recusandae laudantium perferendis hic. Ea sed aut quas quas dolorem perspiciatis.', '2025-03-07 16:48:54', '2026-03-08 00:48:54'),
(160, 14, 3, 4, 'joke 4 lang', '2026-03-21 19:10:07', '2026-03-22 03:10:07'),
(161, 18, 3, 5, 'hj', '2026-03-21 20:41:13', '2026-03-22 04:41:13');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('RsK5sGiQ6uZaxknVqiSO4de80aUwUcKd7MlFaGSp', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNmJVUWpkOTlWTDdYSHRUNlZKaFlia3BTRmNqa0NtQVVNMHNxMUI1NiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9wcmVzdGlnZXBlcmZ1bWUudGVzdC9jYXJ0IjtzOjU6InJvdXRlIjtzOjEwOiJjYXJ0LmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mzt9', 1774160956),
('ynSenpLPn2s5CkBTcGHdQpc4FyIwABD9XtWC1UWm', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidG5EcFVkcjhhd2pRWDVxNjZxSlFxenZ2ZzcxQ282M0lScDZqT1EwbCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly9wcmVzdGlnZXBlcmZ1bWUudGVzdC9hZG1pbi9jYXRlZ29yaWVzIjtzOjU6InJvdXRlIjtzOjIyOiJhZG1pbi5jYXRlZ29yaWVzLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1774162082);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` bigint UNSIGNED NOT NULL,
  `supplier_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `supplier_name`, `contact_person`, `contact_number`, `address`, `is_active`, `deleted_at`) VALUES
(1, 'Luxury Scents Inc.', 'Trisha Mia Morales', '+6392752342323', 'Tagik Cite', 1, NULL),
(2, 'Aroma Distributors', NULL, NULL, NULL, 1, NULL),
(3, 'Fragrantica', 'jaw jiawfj', '09726262789', 'taguig city 1630', 1, NULL),
(6, 'ngekngek', 'ngekngek', '0923247266', 'iawnaindw taguig', 1, '2026-03-21 20:00:39');

-- --------------------------------------------------------

--
-- Table structure for table `supply_logs`
--

CREATE TABLE `supply_logs` (
  `supply_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `supplier_id` bigint UNSIGNED NOT NULL,
  `quantity_added` int NOT NULL,
  `supplier_price` decimal(10,2) DEFAULT NULL,
  `supply_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remarks` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supply_logs`
--

INSERT INTO `supply_logs` (`supply_id`, `product_id`, `supplier_id`, `quantity_added`, `supplier_price`, `supply_date`, `remarks`) VALUES
(1, 16, 2, 5, 50.00, '2026-03-20 11:49:27', 'Stock increased via product update'),
(2, 19, 3, 10, 400.00, '2026-03-20 11:52:48', 'Initial stock on product creation'),
(3, 19, 3, 3, 9000.00, '2026-03-21 02:34:04', 'Stock increased via product update'),
(4, 20, 6, 10, 50.00, '2026-03-21 12:25:22', 'Initial stock on product creation'),
(5, 19, 3, 10, 9000.00, '2026-03-22 04:06:29', 'Stock increased via product update'),
(6, 19, 3, 4, 9000.00, '2026-03-22 04:06:40', 'Stock increased via product update'),
(7, 18, 2, 10, 7000.00, '2026-03-22 04:41:41', 'Stock increased via product update');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint UNSIGNED NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','customer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `full_name`, `contact_number`, `address`, `profile_picture`, `email`, `email_verified_at`, `password`, `remember_token`, `role`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Admin User', NULL, 'nice', NULL, 'admin@example.com', '2026-03-06 17:17:28', '$2y$12$Ae5kQm6EpHTUVE5UjTuB/.ykKHgMllTiz9ywehBTcy22Q3GiZXHRO', NULL, 'admin', 1, '2026-03-06 17:17:28', '2026-03-06 17:17:28'),
(2, 'customer', 'Customer User', NULL, NULL, NULL, 'customer@example.com', NULL, '$2y$12$Oc7g7OwAOmrqNRrdbN.RyOG6TCIvklD2Hsro3dGS6CmvZp1AfmU22', NULL, 'customer', 1, NULL, NULL),
(3, 'elixqc', 'nico barredo', '09392891165', '291 zamora st. brgy pinagsama taguig city 1630', 'profile_pictures/JVxDnFI93u4fDI1zavql2JQHOPBX6yCVrbpHK9B7.jpg', 'nicobarredo87@gmail.com', '2026-03-06 18:12:53', '$2y$12$KpArMlUJvuIyZUSSCfqCGO5LlsdPFaOH.sc2UmEUnfbLDOsemMV2K', 'I3xcrbIw3SWjQQTeXhfCAUVOV7bvjXTy22gDthVy4YdSQFNaGzzdEjUd7ujr', 'customer', 1, NULL, '2026-03-21 20:33:18'),
(6, 'elixqc1', 'nico barredo', NULL, NULL, NULL, 'nico.barredo@tup.edu.ph', '2026-03-06 18:28:09', '$2y$12$swYuJCqIMqJr9YU17EFrtutzzSsaECuE77pyBM3wGD3NZIqCu6ao2', NULL, 'customer', 1, '2026-03-06 18:27:48', '2026-03-06 18:28:09'),
(7, 'elixqc12', 'nico barredo', '09930536452', 'taguig city', 'profile_pictures/m08BJ6Lar4fT1ymZXExcJzofHpZlaUckxxL0Gn2R.jpg', 'spotifymod1020@gmail.com', '2026-03-06 18:43:07', '$2y$12$VZXBCJZiCqjSf51DApOtPuNTJN0Jkky9vAJ3ZE7zDAerUi5Lv9ARC', NULL, 'customer', 1, '2026-03-06 18:42:48', '2026-03-06 19:37:10'),
(8, 'considine.henry', 'Lorna Schamberger', '+14588076592', '22893 Adelle Junction\nMyleneville, IN 85339', NULL, 'christiansen.river@example.com', '2026-03-07 04:43:04', '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'Wbaq1VH26e', 'customer', 1, '2026-03-07 04:43:04', '2026-03-07 04:43:04'),
(9, 'harber.leif', 'Felicia Connelly', '1-667-537-5102', '66925 Grimes Ports Suite 591\nWhitefort, IL 37570-8316', NULL, 'mustafa38@example.net', '2026-03-07 04:43:04', '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'avE85RGbtF', 'customer', 1, '2026-03-07 04:43:04', '2026-03-07 04:43:04'),
(10, 'witting.edison', 'Ines Jaskolski', '(586) 596-5529', '60679 Borer Pine\nAldashire, KY 96453', NULL, 'bschaefer@example.net', '2026-03-07 04:43:04', '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'j69Xq3H3Lv', 'customer', 1, '2026-03-07 04:43:04', '2026-03-07 04:43:04'),
(11, 'kellie.purdy', 'Prof. Nannie Skiles', '1-442-735-7507', '17683 Ernie Valley Apt. 350\nChanelland, KY 96297', NULL, 'filiberto59@example.com', '2026-03-07 04:43:04', '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'mEyzShH1iA', 'customer', 1, '2026-03-07 04:43:04', '2026-03-07 04:43:04'),
(12, 'emiliano50', 'Fred Gottlieb DVM', '+1-463-890-8848', '7138 Alberta Freeway\nMullerton, RI 16271', NULL, 'mayer.ashlee@example.org', '2026-03-07 04:43:04', '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'Nxy2vzTUb1', 'customer', 1, '2026-03-07 04:43:04', '2026-03-07 04:43:04'),
(13, 'donny82', 'Abel Beier', '+19388295504', '9710 Bartoletti Street Suite 116\nNew Marlinton, IN 39300', NULL, 'kadin.marquardt@example.com', '2026-03-07 04:43:04', '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'DKneoVsDEk', 'customer', 1, '2026-03-07 04:43:04', '2026-03-07 04:43:04'),
(14, 'isabel71', 'Eloy Moen', '(220) 472-9214', '284 Hills Dam Apt. 615\nPort Berta, DC 19295-2352', NULL, 'ehahn@example.net', '2026-03-07 04:43:04', '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'K29WeTLDQd', 'customer', 1, '2026-03-07 04:43:04', '2026-03-07 04:43:04'),
(15, 'aschiller', 'Ms. Jannie Connelly PhD', '(832) 540-3489', '865 Davis Keys Apt. 668\nRaquelland, WY 02144-1598', NULL, 'bbins@example.com', '2026-03-07 04:43:04', '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'hV1wb1Dwrq', 'customer', 1, '2026-03-07 04:43:04', '2026-03-07 04:43:04'),
(16, 'sbrown', 'Raul Lebsack', '920-758-9662', '56810 Tatum Valleys\nPort Fosterfurt, NH 32996', NULL, 'fahey.abdul@example.com', '2026-03-07 04:43:04', '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'KbLIhdLvmY', 'customer', 1, '2026-03-07 04:43:04', '2026-03-07 04:43:04'),
(17, 'akuhn', 'Gilda Hegmann II', '1-682-602-4165', '74962 Upton Fort Suite 021\nWest Heavenfurt, KS 23631-0323', NULL, 'apollich@example.org', '2026-03-07 04:43:04', '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'CIDODkDDUa', 'customer', 1, '2026-03-07 04:43:04', '2026-03-07 04:43:04'),
(18, 'bret94', 'Mrs. Ardella Dooley', '+1-541-851-8147', '40293 Nicolas Terrace\nMuhammadside, MI 80256', NULL, 'arnoldo.mraz@example.net', '2026-03-07 04:43:04', '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'KK7c6o9RnO', 'customer', 1, '2026-03-07 04:43:04', '2026-03-07 04:43:04'),
(19, 'zhill', 'Louie Dickinson', '(248) 302-9986', '2922 McCullough Springs Apt. 937\nWest Heatherfort, TX 54880-5374', NULL, 'wgoldner@example.org', '2026-03-07 04:43:04', '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'VhjkjAtK0p', 'customer', 1, '2026-03-07 04:43:04', '2026-03-07 04:43:04'),
(20, 'marilie.lebsack', 'Israel Kuvalis III', '423-537-5882', '3586 Watsica Fork\nFeeneyfort, ID 84186', NULL, 'peyton73@example.com', '2026-03-07 04:43:04', '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'wpCpbCzlwH', 'customer', 1, '2026-03-07 04:43:04', '2026-03-07 04:43:04'),
(21, 'walker.maynard', 'Miss Lexie Smitham', '1-412-678-9104', '189 Nicolas Alley\nGennarostad, NY 08762', NULL, 'lucius37@example.org', '2026-03-07 04:43:04', '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', '0QJQ7zb1wz', 'customer', 1, '2026-03-07 04:43:04', '2026-03-07 04:43:04'),
(22, 'phahn', 'Sonny Marquardt', '+1 (682) 362-4085', '4341 Clementine Drives Suite 370\nSouth Jerrod, SD 62586', NULL, 'alysha83@example.org', '2026-03-07 04:43:04', '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'Oyz42hoewt', 'customer', 1, '2026-03-07 04:43:04', '2026-03-07 04:43:04'),
(23, 'greichel', 'Alexys Nitzsche', '1-678-882-3443', '80637 Hauck Cove Suite 584\nLake Jack, NE 98991', NULL, 'howard.erdman@example.org', '2026-03-07 04:43:04', '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'zUicPqV5CJ', 'customer', 1, '2026-03-07 04:43:04', '2026-03-07 04:43:04'),
(24, 'walker.reanna', 'Dr. Ena Smith Sr.', '848.673.1830', '11430 Eleazar Walk\nAnnabelfurt, WV 04208', NULL, 'keon12@example.org', '2026-03-07 04:43:04', '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'jhyPiN1E6l', 'customer', 1, '2026-03-07 04:43:04', '2026-03-07 04:43:04'),
(25, 'eli96', 'Reggie Morissette I', '+1-607-478-3481', '58537 Filomena Pass\nWest Lucasberg, CT 64456-2170', NULL, 'santina84@example.org', '2026-03-07 04:43:04', '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'MDzJbkz22S', 'customer', 1, '2026-03-07 04:43:04', '2026-03-07 04:43:04'),
(26, 'uconsidine', 'Juliet Kling', '+19518282729', '3138 Velda Turnpike Apt. 120\nArmandmouth, WA 93112-2372', NULL, 'ekoelpin@example.org', '2026-03-07 04:43:04', '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', '5PpwUldHgw', 'customer', 1, '2026-03-07 04:43:04', '2026-03-07 04:43:04'),
(27, 'gleason.modesto', 'Mrs. Brielle DuBuque III', '(715) 858-8755', '974 Schultz Village Suite 535\nPort Edmond, AK 78055', NULL, 'ncrona@example.com', '2026-03-07 04:43:04', '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'gZVdas7RmB', 'customer', 1, '2026-03-07 04:43:04', '2026-03-07 04:43:04'),
(30, 'awawaw1', 'awaw awffawfn', '0293204874', 'seknfs', NULL, 'josephlorenzcoronado@gmail.com', '2026-03-12 18:29:05', '$2y$12$rno7T4o3.qfA2tcbxm/R0u4aAh15vaj5dQPowAi56HXv8/iXBFZyO', NULL, 'customer', 1, '2026-03-12 18:28:15', '2026-03-21 07:47:45'),
(31, 'samplesample', 'samplesample', '2032932674', 'einfsnefnke tcity', 'profile_pictures/hYvkG79wr6xfjzhBJ5e79QWndq5t0bZz3d0Chslm.jpg', 'perfumeryprestige@gmail.com', '2026-03-20 04:29:42', '$2y$12$anr.fMkpOLdFON719le.JOXq6G4SPqH99hMv2HpDczzTCWcdZEa7y', NULL, 'customer', 1, '2026-03-20 04:29:30', '2026-03-21 03:16:28'),
(32, 'mawmawmaw', 'maw maw', '093427482463', 'taguig city', NULL, 'mawmaw@gmail.com', '2026-03-20 18:46:07', '$2y$12$SRCR6Cg2R56jQ9kDJzevQ.ehQkQqPs0ZAhL5Kj3rhYcZnSnOCs5iS', NULL, 'customer', 1, '2026-03-20 18:45:54', '2026-03-20 18:46:07'),
(33, 'ewan', 'ewan ewan', '09722462742', 'taguig city', NULL, 'ewan@gmail.om', NULL, '$2y$12$MivNibjDL/uMNukmMHisFu8/CprCBmTsiRYS83MLt6d8HxT9J4AjG', NULL, 'customer', 1, '2026-03-21 19:33:38', '2026-03-21 19:33:38'),
(34, 'ewan1', 'ewan ewan', '+639224324324', 'TAGUIG', 'profile_pictures/8KljDxtcVGeSiptyK043kl0fZ6Sstkhwhvw6R4Kq.png', 'ewan@gmail.com', '2026-03-21 19:37:12', '$2y$12$vrUYkzcVCCXC4yM5Ro2opeZb4egbTjw3go.2eVOuyY7ttMSfL59l.', NULL, 'customer', 1, '2026-03-21 19:36:31', '2026-03-21 19:38:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`user_id`,`product_id`),
  ADD KEY `cart_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `categories_category_name_unique` (`category_name`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `order_details_order_id_foreign` (`order_id`),
  ADD KEY `order_details_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `product_reviews_product_id_foreign` (`product_id`),
  ADD KEY `product_reviews_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`),
  ADD UNIQUE KEY `suppliers_supplier_name_unique` (`supplier_name`);

--
-- Indexes for table `supply_logs`
--
ALTER TABLE `supply_logs`
  ADD PRIMARY KEY (`supply_id`),
  ADD KEY `supply_logs_product_id_foreign` (`product_id`),
  ADD KEY `supply_logs_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_detail_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=429;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `image_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `review_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `supply_logs`
--
ALTER TABLE `supply_logs`
  MODIFY `supply_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`) ON DELETE SET NULL;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `product_reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `supply_logs`
--
ALTER TABLE `supply_logs`
  ADD CONSTRAINT `supply_logs_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `supply_logs_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
