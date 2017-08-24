-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 24, 2017 at 04:31 AM
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
  `client_name` varchar(126) NOT NULL,
  `client_telephone` varchar(50) NOT NULL,
  `billing_address` varchar(126) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `client_name`, `client_telephone`, `billing_address`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'Clienty', '5687687', 'Address', 1, 1, '2017-08-23 20:44:39', 1, '2017-08-23 20:47:32');

-- --------------------------------------------------------

--
-- Table structure for table `loading_manifests`
--

CREATE TABLE `loading_manifests` (
  `id` int(11) NOT NULL,
  `origin` int(11) NOT NULL,
  `destination` int(11) NOT NULL,
  `registration_no` varchar(30) NOT NULL,
  `driver` varchar(30) NOT NULL,
  `conductor` varchar(30) NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` int(11) NOT NULL,
  `loaded` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loading_manifests`
--

INSERT INTO `loading_manifests` (`id`, `origin`, `destination`, `registration_no`, `driver`, `conductor`, `created_by`, `created_at`, `updated_by`, `updated_at`, `status`, `loaded`) VALUES
(1, 3, 1, 'KAR456T', 'Mohamed', 'Salim', 1, '2017-08-24 02:05:27', NULL, '2017-08-24 02:05:27', 1, 3),
(2, 3, 1, 'KAR456T', 'Mohamed', 'Salim', 1, '2017-08-24 02:21:57', NULL, '2017-08-24 02:21:57', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `main_offices`
--

CREATE TABLE `main_offices` (
  `id` int(11) NOT NULL,
  `main_office` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `main_offices`
--

INSERT INTO `main_offices` (`id`, `main_office`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'NAKURU', 1, '2017-08-23 20:00:29', 1, '2017-08-23 20:07:55', 1),
(3, 'MOMBASA', 1, '2017-08-23 20:00:29', 1, '2017-08-23 20:07:55', 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package_types`
--

CREATE TABLE `package_types` (
  `id` int(11) NOT NULL,
  `package_type` varchar(30) NOT NULL,
  `description` longtext,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `package_types`
--

INSERT INTO `package_types` (`id`, `package_type`, `description`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'BAGS', 'Description', 1, '2017-08-23 19:14:25', 1, '2017-08-23 19:15:27', 1),
(2, 'BAGS2', 'Description', 1, '2017-08-23 19:14:41', 1, '2017-08-23 19:14:41', NULL),
(5, 'Package Type', 'Des', 0, '2017-08-23 19:16:27', 1, '2017-08-23 19:16:40', 1);

-- --------------------------------------------------------

--
-- Table structure for table `stations`
--

CREATE TABLE `stations` (
  `id` int(11) NOT NULL,
  `office_name` varchar(126) NOT NULL,
  `office_code` varchar(30) NOT NULL,
  `telephone_number` varchar(30) NOT NULL,
  `currency` varchar(11) NOT NULL,
  `main_office` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stations`
--

INSERT INTO `stations` (`id`, `office_name`, `office_code`, `telephone_number`, `currency`, `main_office`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'NAKURU', 'NAK', '345678', 'TSH', 1, 1, '2017-08-23 00:00:00', 1, NULL, NULL),
(3, 'MOMBASA PICKUP', 'MSA', '3456789', 'TSH', 3, 1, '2017-08-23 00:00:00', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'staff', 'staff@courier.co.ke', '$2y$10$NV1X1MkXZwFDMw1Rh7XESuK1iCBl8UkpTJBqb9iAkeSMNIHi2cnwS', 'XS361K2vIoiWKcjM8sT5dbMsyqmTxH2VyKvIsOk2XKtgpVHm6x62pfzYw8v0', '2017-08-23 16:11:42', '2017-08-23 16:11:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `client_telephone` (`client_telephone`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `loading_manifests`
--
ALTER TABLE `loading_manifests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `origin` (`origin`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `destination` (`destination`);

--
-- Indexes for table `main_offices`
--
ALTER TABLE `main_offices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `main_office` (`main_office`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_types`
--
ALTER TABLE `package_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `package_type` (`package_type`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `stations`
--
ALTER TABLE `stations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `office_code` (`office_code`),
  ADD UNIQUE KEY `telephone_number` (`telephone_number`),
  ADD UNIQUE KEY `office_name` (`office_name`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `main_office` (`main_office`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `loading_manifests`
--
ALTER TABLE `loading_manifests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `main_offices`
--
ALTER TABLE `main_offices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `package_types`
--
ALTER TABLE `package_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `stations`
--
ALTER TABLE `stations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
-- Constraints for table `loading_manifests`
--
ALTER TABLE `loading_manifests`
  ADD CONSTRAINT `loading_manifests_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `loading_manifests_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `loading_manifests_ibfk_3` FOREIGN KEY (`origin`) REFERENCES `stations` (`id`),
  ADD CONSTRAINT `loading_manifests_ibfk_4` FOREIGN KEY (`destination`) REFERENCES `stations` (`id`);

--
-- Constraints for table `main_offices`
--
ALTER TABLE `main_offices`
  ADD CONSTRAINT `main_offices_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `main_offices_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `stations`
--
ALTER TABLE `stations`
  ADD CONSTRAINT `stations_ibfk_1` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `stations_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `stations_ibfk_3` FOREIGN KEY (`main_office`) REFERENCES `main_offices` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
