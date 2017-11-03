-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2017 at 10:46 AM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `courier-2`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `client_name` varchar(126) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_telephone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_address` varchar(126) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(11) NOT NULL,
  `currency` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `currency`) VALUES
(1, 'KSH'),
(2, 'TSH'),
(3, 'USH');

-- --------------------------------------------------------

--
-- Table structure for table `main_offices`
--

CREATE TABLE `main_offices` (
  `id` int(11) NOT NULL,
  `main_office` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `main_offices`
--

INSERT INTO `main_offices` (`id`, `main_office`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'Nakuru', 1, '2017-08-26 01:07:56', '2017-08-26 01:07:56', 1, NULL),
(2, 'Mombasa', 1, '2017-08-26 01:08:04', '2017-08-26 01:08:04', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `manifests`
--

CREATE TABLE `manifests` (
  `id` int(11) NOT NULL,
  `manifest_no` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `origin` int(11) NOT NULL,
  `destination` int(11) NOT NULL,
  `registration_no` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conductor` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manifests`
--

INSERT INTO `manifests` (`id`, `manifest_no`, `origin`, `destination`, `registration_no`, `driver`, `conductor`, `created_by`, `created_at`, `updated_at`, `updated_by`, `status`) VALUES
(1, 'ORG-DEST-MANIFEST:1', 1, 2, 'KBS258T', 'Hassan', 'John', 1, '2017-08-27 09:25:22', '2017-11-03 06:19:28', 1, 4),
(2, 'ORG-DEST-MANIFEST:2', 1, 2, 'KCL236P', 'Salma', 'Nawir', 1, '2017-08-27 10:58:48', '2017-11-02 19:42:51', 1, 2),
(9, NULL, 1, 2, 'KBQ052S', 'Halua', 'Shaban', 1, '2017-09-01 10:04:11', '2017-09-01 10:04:11', NULL, 1),
(10, 'ORG-DEST-MANIFEST:10', 1, 2, 'KSW589T', 'Hassan', 'Juma', 1, '2017-09-01 11:43:14', '2017-09-01 11:43:14', NULL, 1),
(11, 'ORG-DEST-MANIFEST:11', 1, 2, 'KAR456T', 'Juma', 'Harron', 1, '2017-09-01 11:44:47', '2017-09-01 11:44:58', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `manifest_statuses`
--

CREATE TABLE `manifest_statuses` (
  `id` int(11) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manifest_statuses`
--

INSERT INTO `manifest_statuses` (`id`, `status`) VALUES
(1, 'ACTIVE'),
(3, 'CANCELLED'),
(2, 'DISPATCHED'),
(4, 'OFFLOADED');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(32, '2014_10_12_100000_create_password_resets_table', 1),
(33, '2017_08_26_025135_create_clients_table', 1),
(34, '2017_08_26_025135_create_loading_manifests_table', 1),
(35, '2017_08_26_025135_create_main_offices_table', 1),
(36, '2017_08_26_025135_create_package_types_table', 1),
(37, '2017_08_26_025135_create_payment_modes_table', 1),
(38, '2017_08_26_025135_create_stations_table', 1),
(39, '2017_08_26_025135_create_test_tables_table', 1),
(40, '2017_08_26_025135_create_users_table', 1),
(41, '2017_08_26_025135_create_waybills_table', 1),
(42, '2017_08_26_025137_add_foreign_keys_to_clients_table', 1),
(43, '2017_08_26_025137_add_foreign_keys_to_loading_manifests_table', 1),
(44, '2017_08_26_025137_add_foreign_keys_to_main_offices_table', 1),
(45, '2017_08_26_025137_add_foreign_keys_to_payment_modes_table', 1),
(46, '2017_08_26_025137_add_foreign_keys_to_stations_table', 1),
(47, '2017_08_26_025137_add_foreign_keys_to_waybills_table', 1),
(48, '2017_08_26_030315_create_clients_table', 1),
(49, '2017_08_26_030315_create_loading_manifests_table', 1),
(50, '2017_08_26_030315_create_main_offices_table', 1),
(51, '2017_08_26_030315_create_package_types_table', 1),
(52, '2017_08_26_030315_create_password_resets_table', 1),
(53, '2017_08_26_030315_create_payment_modes_table', 1),
(54, '2017_08_26_030315_create_stations_table', 1),
(55, '2017_08_26_030315_create_test_tables_table', 1),
(56, '2017_08_26_030315_create_users_table', 1),
(57, '2017_08_26_030315_create_waybills_table', 1),
(58, '2017_08_26_030317_add_foreign_keys_to_clients_table', 1),
(59, '2017_08_26_030317_add_foreign_keys_to_loading_manifests_table', 1),
(60, '2017_08_26_030317_add_foreign_keys_to_main_offices_table', 1),
(61, '2017_08_26_030317_add_foreign_keys_to_payment_modes_table', 1),
(62, '2017_08_26_030317_add_foreign_keys_to_stations_table', 1),
(63, '2017_08_26_030317_add_foreign_keys_to_waybills_table', 1),
(64, '2017_09_08_183253_create_clients_table', 0),
(65, '2017_09_08_183253_create_main_offices_table', 0),
(66, '2017_09_08_183253_create_manifests_table', 0),
(67, '2017_09_08_183253_create_package_types_table', 0),
(68, '2017_09_08_183253_create_password_resets_table', 0),
(69, '2017_09_08_183253_create_payment_modes_table', 0),
(70, '2017_09_08_183253_create_stations_table', 0),
(71, '2017_09_08_183253_create_test_tables_table', 0),
(72, '2017_09_08_183253_create_users_table', 0),
(73, '2017_09_08_183253_create_waybill_manifests_table', 0),
(74, '2017_09_08_183253_create_waybill_statuses_table', 0),
(75, '2017_09_08_183253_create_waybills_table', 0),
(76, '2017_09_08_183256_add_foreign_keys_to_clients_table', 0),
(77, '2017_09_08_183256_add_foreign_keys_to_main_offices_table', 0),
(78, '2017_09_08_183256_add_foreign_keys_to_manifests_table', 0),
(79, '2017_09_08_183256_add_foreign_keys_to_payment_modes_table', 0),
(80, '2017_09_08_183256_add_foreign_keys_to_stations_table', 0),
(81, '2017_09_08_183256_add_foreign_keys_to_users_table', 0),
(82, '2017_09_08_183256_add_foreign_keys_to_waybill_manifests_table', 0),
(83, '2017_09_08_183256_add_foreign_keys_to_waybill_statuses_table', 0),
(84, '2017_09_08_183256_add_foreign_keys_to_waybills_table', 0),
(85, '2017_09_08_183423_create_clients_table', 0),
(86, '2017_09_08_183423_create_main_offices_table', 0),
(87, '2017_09_08_183423_create_manifests_table', 0),
(88, '2017_09_08_183423_create_package_types_table', 0),
(89, '2017_09_08_183423_create_password_resets_table', 0),
(90, '2017_09_08_183423_create_payment_modes_table', 0),
(91, '2017_09_08_183423_create_stations_table', 0),
(92, '2017_09_08_183423_create_test_tables_table', 0),
(93, '2017_09_08_183423_create_users_table', 0),
(94, '2017_09_08_183423_create_waybill_manifests_table', 0),
(95, '2017_09_08_183423_create_waybill_statuses_table', 0),
(96, '2017_09_08_183423_create_waybills_table', 0),
(97, '2017_09_08_183428_add_foreign_keys_to_clients_table', 0),
(98, '2017_09_08_183428_add_foreign_keys_to_main_offices_table', 0),
(99, '2017_09_08_183428_add_foreign_keys_to_manifests_table', 0),
(100, '2017_09_08_183428_add_foreign_keys_to_payment_modes_table', 0),
(101, '2017_09_08_183428_add_foreign_keys_to_stations_table', 0),
(102, '2017_09_08_183428_add_foreign_keys_to_users_table', 0),
(103, '2017_09_08_183428_add_foreign_keys_to_waybill_manifests_table', 0),
(104, '2017_09_08_183428_add_foreign_keys_to_waybill_statuses_table', 0),
(105, '2017_09_08_183428_add_foreign_keys_to_waybills_table', 0);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_id`, `model_type`) VALUES
(1, 3, 'App\\User'),
(1, 4, 'App\\User'),
(1, 5, 'App\\User'),
(2, 1, 'App\\User');

-- --------------------------------------------------------

--
-- Table structure for table `package_types`
--

CREATE TABLE `package_types` (
  `id` int(11) NOT NULL,
  `package_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `package_types`
--

INSERT INTO `package_types` (`id`, `package_type`, `description`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'BAGS', 'Dec', 1, '2017-08-26 01:02:26', '2017-08-26 01:02:26', 1, NULL),
(2, 'SACS', 'Description', 1, '2017-08-26 01:02:43', '2017-08-26 01:02:43', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_modes`
--

CREATE TABLE `payment_modes` (
  `id` int(11) NOT NULL,
  `payment_mode` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_modes`
--

INSERT INTO `payment_modes` (`id`, `payment_mode`, `status`, `created_by`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 'MPESA', 1, 1, '2017-08-26 01:06:42', '2017-08-26 01:06:42', NULL),
(2, 'CASH ON DELIVERY', 1, 1, '2017-08-26 01:06:48', '2017-08-26 01:06:48', NULL),
(3, 'CASH PAYMENT', 1, 1, '2017-08-26 01:06:55', '2017-08-26 01:06:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Administer roles & permissions', 'web', '2017-09-08 16:42:52', '2017-09-08 16:42:52'),
(2, 'view waybill', 'web', '2017-09-08 16:45:28', '2017-09-08 16:45:28'),
(3, 'create waybill', 'web', '2017-09-08 16:45:52', '2017-09-08 16:45:52'),
(4, 'view manifests', 'web', '2017-09-08 16:46:22', '2017-09-08 16:46:22'),
(5, 'create manifest', 'web', '2017-09-08 16:46:34', '2017-09-08 19:39:49'),
(6, 'view package types', 'web', '2017-09-08 16:50:48', '2017-09-08 16:50:48'),
(7, 'add package types', 'web', '2017-09-08 16:51:05', '2017-09-08 16:51:16'),
(8, 'edit package types', 'web', '2017-09-08 16:51:22', '2017-09-08 16:51:22'),
(9, 'edit waybill', 'web', '2017-09-08 19:32:42', '2017-09-08 19:32:42'),
(10, 'load waybills', 'web', '2017-09-08 19:46:14', '2017-09-08 19:46:14'),
(11, 'remove waybills', 'web', '2017-09-08 19:46:33', '2017-09-08 19:46:33'),
(12, 'dispatch manifest', 'web', '2017-09-08 19:47:09', '2017-09-08 19:47:09');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2017-09-08 16:44:21', '2017-09-08 16:44:21'),
(2, 'staff', 'web', '2017-09-08 16:50:07', '2017-09-08 16:50:07');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 1),
(7, 1),
(8, 1),
(9, 2),
(10, 2),
(11, 2),
(12, 2);

-- --------------------------------------------------------

--
-- Table structure for table `stations`
--

CREATE TABLE `stations` (
  `id` int(11) NOT NULL,
  `office_name` varchar(126) COLLATE utf8mb4_unicode_ci NOT NULL,
  `office_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone_number` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_id` int(11) NOT NULL,
  `main_office_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stations`
--

INSERT INTO `stations` (`id`, `office_name`, `office_code`, `telephone_number`, `currency_id`, `main_office_id`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'ORIGIN', 'ORG', 'dsfdsa', 3, 1, 1, '2017-08-26 01:12:41', '2017-11-02 10:47:41', 1, 5),
(2, 'DESTINATION', 'DEST', 'dlksf', 1, 1, 1, '2017-08-26 01:13:05', '2017-08-26 01:13:05', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `test_tables`
--

CREATE TABLE `test_tables` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `station` int(11) DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `station`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'staff', 1, 'staff@courier.co.ke', '$2y$10$xbaKLpfeaPE8AHBtjmw7feVp3ODcBGsvYDGjeI2H.3pAHjQQqwa4y', 'Ac5lRX2Dx4g5vAcF5ov7WiHwE2Ry16fxMy2I5rTJmwgLtwY8wLJXaBwWfAkY', '2017-08-26 00:12:39', '2017-09-08 16:55:19'),
(5, 'admin', NULL, 'admin@courier.co.ke', '$2y$10$lzB5g.ZxNHRO68akTV.hYudYaly119eXBmsImSeYVwXq5HN0QqOZ6', 'KEZROobQIGxcArGVHLY8y5Uv6N3eWTeUbxvIGemDjfArii5vB328YFWbck6w', '2017-09-08 18:15:47', '2017-09-08 18:15:47');

-- --------------------------------------------------------

--
-- Table structure for table `waybills`
--

CREATE TABLE `waybills` (
  `id` int(11) NOT NULL,
  `waybill_no` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consignor` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `consignor_tel` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `consignee` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `consignee_tel` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `origin` int(11) NOT NULL,
  `destination` int(11) NOT NULL,
  `package_type` int(11) NOT NULL,
  `quantity` double NOT NULL,
  `weight` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cbm` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consignor_email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_mode` int(11) NOT NULL,
  `amount_per_item` double NOT NULL,
  `vat` double NOT NULL,
  `amount` float NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `waybills`
--

INSERT INTO `waybills` (`id`, `waybill_no`, `consignor`, `consignor_tel`, `consignee`, `consignee_tel`, `origin`, `destination`, `package_type`, `quantity`, `weight`, `cbm`, `consignor_email`, `description`, `payment_mode`, `amount_per_item`, `vat`, `amount`, `created_by`, `created_at`, `updated_at`, `updated_by`, `status`) VALUES
(1, 'ORG-DEST-2017-SEP-KGUJ', 'John', 'dsfads', 'ssafd', '+2540716690166', 1, 2, 1, 50, '55kg', NULL, 'fdsaf', 'fdsaf', 1, 900, 16, 756, 1, '2017-08-26 01:13:57', '2017-09-01 09:56:44', 1, 4),
(2, 'DEST-DEST-2017-SEP-GPAD', 'Jane', '87u0324', '349u9854', '0716690166', 2, 2, 1, 10, '7kg', NULL, 'consigrnor@gmail.com', 'Description', 3, 900, 16, 756, 1, '2017-09-01 04:09:30', '2017-09-01 09:57:29', 1, 4),
(3, 'ORG-DEST-2017-SEP-RCUH', 'Kokko', '87u0324', 'SHaru', '3948324', 1, 2, 2, 15, '7kg', NULL, 'consigrnor@gmail.com', 'Description', 3, 900, 16, 756, 1, '2017-09-01 04:09:30', '2017-09-01 11:26:11', 1, 1),
(4, 'ORG-DEST-2017-SEP-WZHA', 'kllksdkl', 'jljlksdjal', 'jfkldsj', 'flkdsjaf', 1, 2, 1, 89, '989', '89', '898989', '89', 1, 100, 16, 84, 1, '2017-09-01 11:28:47', '2017-09-01 11:29:58', 1, 1),
(5, 'ORG-ORG-2017-SEP-SDCP', 'fkldajslfj', 'klfdjsla', 'ljlfdjsl', 'jljlsklj', 1, 1, 1, 9090, '98', '89', '899', '89', 1, 500, 16, 420, 1, '2017-09-01 11:30:25', '2017-09-01 11:30:25', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `waybill_manifests`
--

CREATE TABLE `waybill_manifests` (
  `id` int(11) NOT NULL,
  `manifest` int(11) NOT NULL,
  `waybill` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `waybill_manifests`
--

INSERT INTO `waybill_manifests` (`id`, `manifest`, `waybill`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 1, 1, 1, '2017-09-01 15:09:31', NULL, NULL),
(2, 1, 2, 1, 1, '2017-09-08 22:09:23', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `waybill_statuses`
--

CREATE TABLE `waybill_statuses` (
  `id` int(11) NOT NULL,
  `waybill_status` varchar(30) NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `waybill_statuses`
--

INSERT INTO `waybill_statuses` (`id`, `waybill_status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'ACTIVE', 1, '2017-08-27 11:11:06', NULL, '2017-08-27 11:11:06'),
(2, 'LOADED', 1, '2017-08-27 11:11:13', 1, '2017-08-27 11:11:26'),
(3, 'DELIVERED', 1, '2017-08-27 11:11:43', 1, '2017-08-27 11:12:11'),
(4, 'OFFLOADED', 1, '2017-08-27 11:11:43', 1, '2017-08-27 11:12:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `client_telephone` (`client_telephone`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `currency` (`currency`);

--
-- Indexes for table `main_offices`
--
ALTER TABLE `main_offices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `main_office` (`main_office`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `manifests`
--
ALTER TABLE `manifests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `manifest_no` (`manifest_no`),
  ADD KEY `origin` (`origin`),
  ADD KEY `destination` (`destination`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `manifest_statuses`
--
ALTER TABLE `manifest_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `status` (`status`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `package_types`
--
ALTER TABLE `package_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `package_type` (`package_type`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_modes`
--
ALTER TABLE `payment_modes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_mode` (`payment_mode`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `stations`
--
ALTER TABLE `stations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `office_name` (`office_name`),
  ADD UNIQUE KEY `office_code` (`office_code`),
  ADD UNIQUE KEY `telephone_number` (`telephone_number`),
  ADD KEY `main_office` (`main_office_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `currency` (`currency_id`);

--
-- Indexes for table `test_tables`
--
ALTER TABLE `test_tables`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `station` (`station`);

--
-- Indexes for table `waybills`
--
ALTER TABLE `waybills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `waybill_no` (`waybill_no`),
  ADD KEY `origin` (`origin`),
  ADD KEY `destination` (`destination`),
  ADD KEY `package_type` (`package_type`),
  ADD KEY `payment_mode` (`payment_mode`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `waybill_manifests`
--
ALTER TABLE `waybill_manifests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `waybill` (`waybill`),
  ADD KEY `manifest` (`manifest`);

--
-- Indexes for table `waybill_statuses`
--
ALTER TABLE `waybill_statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `main_offices`
--
ALTER TABLE `main_offices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `manifests`
--
ALTER TABLE `manifests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `manifest_statuses`
--
ALTER TABLE `manifest_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;
--
-- AUTO_INCREMENT for table `package_types`
--
ALTER TABLE `package_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `payment_modes`
--
ALTER TABLE `payment_modes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `stations`
--
ALTER TABLE `stations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `test_tables`
--
ALTER TABLE `test_tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `waybills`
--
ALTER TABLE `waybills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `waybill_manifests`
--
ALTER TABLE `waybill_manifests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `waybill_statuses`
--
ALTER TABLE `waybill_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `clients_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `main_offices`
--
ALTER TABLE `main_offices`
  ADD CONSTRAINT `main_offices_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `main_offices_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `manifests`
--
ALTER TABLE `manifests`
  ADD CONSTRAINT `manifests_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `manifests_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `manifests_ibfk_3` FOREIGN KEY (`origin`) REFERENCES `stations` (`id`),
  ADD CONSTRAINT `manifests_ibfk_4` FOREIGN KEY (`destination`) REFERENCES `stations` (`id`),
  ADD CONSTRAINT `manifests_ibfk_5` FOREIGN KEY (`status`) REFERENCES `manifest_statuses` (`id`);

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_modes`
--
ALTER TABLE `payment_modes`
  ADD CONSTRAINT `payment_modes_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `payment_modes_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stations`
--
ALTER TABLE `stations`
  ADD CONSTRAINT `stations_ibfk_1` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `stations_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `stations_ibfk_3` FOREIGN KEY (`main_office_id`) REFERENCES `main_offices` (`id`),
  ADD CONSTRAINT `stations_ibfk_4` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`station`) REFERENCES `stations` (`id`);

--
-- Constraints for table `waybills`
--
ALTER TABLE `waybills`
  ADD CONSTRAINT `waybills_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `waybills_ibfk_2` FOREIGN KEY (`destination`) REFERENCES `stations` (`id`),
  ADD CONSTRAINT `waybills_ibfk_3` FOREIGN KEY (`package_type`) REFERENCES `package_types` (`id`),
  ADD CONSTRAINT `waybills_ibfk_4` FOREIGN KEY (`payment_mode`) REFERENCES `payment_modes` (`id`),
  ADD CONSTRAINT `waybills_ibfk_5` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `waybills_ibfk_6` FOREIGN KEY (`origin`) REFERENCES `stations` (`id`),
  ADD CONSTRAINT `waybills_ibfk_7` FOREIGN KEY (`status`) REFERENCES `waybill_statuses` (`id`);

--
-- Constraints for table `waybill_manifests`
--
ALTER TABLE `waybill_manifests`
  ADD CONSTRAINT `waybill_manifests_ibfk_1` FOREIGN KEY (`manifest`) REFERENCES `manifests` (`id`),
  ADD CONSTRAINT `waybill_manifests_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `waybill_manifests_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `waybill_manifests_ibfk_4` FOREIGN KEY (`waybill`) REFERENCES `waybills` (`id`);

--
-- Constraints for table `waybill_statuses`
--
ALTER TABLE `waybill_statuses`
  ADD CONSTRAINT `waybill_statuses_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `waybill_statuses_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
