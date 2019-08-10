-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2019 at 03:56 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smoke-detector`
--

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `login` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(1, '2018_06_08_042331_add_button_status_field_in_machines_tbl', 1),
(2, '2018_06_13_154317_make_lat_long_double_fiels', 2),
(3, '2018_06_13_160445_add_lat_long_to_cust_addr_tbl', 2),
(4, '2018_08_01_120336_add_device_token_field_in_tank_auth_users', 3),
(5, '2019_01_21_102759_create_table_homes', 4),
(6, '2019_01_21_104033_create_floors_table', 5),
(7, '2019_01_21_104829_create_table_rooms', 6),
(9, '2019_01_21_111338_add_user_id_to_all_tables', 8),
(10, '2019_01_21_112501_drop_extra_tables', 9),
(13, '2019_01_21_114148_create_valves_tbl', 10),
(15, '2019_01_21_105200_create_table_machines', 11),
(19, '2019_02_26_050533_changelat_long_data_types_in_sdetect_homes', 13),
(20, '2019_02_26_044934_add_more_fields_to_sdetect_homes', 14),
(21, '2019_02_26_052930_remove_pin_code_field_from_sdetect_homes', 15),
(22, '2019_02_28_085410_add_pir_sensor_fields', 16),
(24, '2019_03_05_083145_add_is_admin_field_in_machines_table', 17),
(25, '2019_03_05_084011_create_shared_machines_table', 18),
(26, '2019_03_05_095331_change_device_name_string_size', 19),
(27, '2019_03_05_101958_add_is_approved_field_in_shared_machines', 20),
(28, '2019_05_09_154951_add_status_field_i_n_machines_tbl', 21),
(29, '2019_05_12_151953_add_profile_pic_in_users', 21),
(30, '2019_05_18_160051_add_m_otion_detectors_tbl', 21),
(31, '2019_05_20_154747_rename_and_drop_column', 22),
(32, '2019_06_03_140545_rename_column_user_id_insdetect_shared_machines', 23);

-- --------------------------------------------------------

--
-- Table structure for table `sdetect_floors`
--

CREATE TABLE `sdetect_floors` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `home_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sdetect_floors`
--

INSERT INTO `sdetect_floors` (`id`, `name`, `home_id`, `user_id`, `created_at`, `updated_at`) VALUES
(5, 'Floor2', 8, 84, '2019-02-28 23:40:54', '2019-02-28 23:40:54');

-- --------------------------------------------------------

--
-- Table structure for table `sdetect_homes`
--

CREATE TABLE `sdetect_homes` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(11,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sdetect_homes`
--

INSERT INTO `sdetect_homes` (`id`, `name`, `address`, `city`, `state`, `country`, `zip`, `latitude`, `longitude`, `user_id`, `created_at`, `updated_at`) VALUES
(8, '1sds', '123', '1sds', '1sds', '1sds', '', '35.34000000', '11.25000000', 84, '2019-02-28 23:32:43', '2019-02-28 23:32:43'),
(9, '5345', '123', '1sds', '1sds', '1sds', '', '35.34000000', '11.25000000', 82, '2019-02-28 23:32:43', '2019-02-28 23:32:43'),
(10, '1sds', '123', '1sds', '1sds', '1sds', '', '35.34000000', '11.25000000', 84, '2019-02-28 23:32:43', '2019-02-28 23:32:43');

-- --------------------------------------------------------

--
-- Table structure for table `sdetect_machines`
--

CREATE TABLE `sdetect_machines` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `carbon_monoxide` tinyint(1) NOT NULL,
  `lpg` tinyint(1) NOT NULL,
  `smoke` tinyint(1) NOT NULL,
  `air_purity` int(11) NOT NULL,
  `temperature` int(11) NOT NULL,
  `humidity` int(11) NOT NULL,
  `pir_status` tinyint(1) NOT NULL,
  `pir_data` tinyint(1) NOT NULL,
  `home_id` int(10) UNSIGNED DEFAULT NULL,
  `floor_id` int(10) UNSIGNED DEFAULT NULL,
  `room_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `machine_status` tinyint(1) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sdetect_machines`
--

INSERT INTO `sdetect_machines` (`id`, `name`, `serial_no`, `carbon_monoxide`, `lpg`, `smoke`, `air_purity`, `temperature`, `humidity`, `pir_status`, `pir_data`, `home_id`, `floor_id`, `room_id`, `user_id`, `machine_status`, `is_admin`, `created_at`, `updated_at`) VALUES
(24, 'Gps', '11133', 0, 0, 0, 0, 0, 0, 0, 0, 8, NULL, NULL, 85, 0, 1, '2019-03-05 04:11:56', '2019-03-05 04:11:56'),
(25, 'Gps', '12132211133', 0, 3, 0, 0, 0, 0, 0, 0, 8, NULL, NULL, 84, 0, 1, '2019-04-02 04:56:57', '2019-06-08 01:55:18');

-- --------------------------------------------------------

--
-- Table structure for table `sdetect_motion_detectors`
--

CREATE TABLE `sdetect_motion_detectors` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `machine_id` int(11) NOT NULL,
  `serial` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sdetect_motion_detectors`
--

INSERT INTO `sdetect_motion_detectors` (`id`, `user_id`, `machine_id`, `serial`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 85, 24, 545454, 'MDetect 1', 1, '2019-05-20 10:21:03', '2019-05-20 10:21:03');

-- --------------------------------------------------------

--
-- Table structure for table `sdetect_rooms`
--

CREATE TABLE `sdetect_rooms` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `floor_id` int(10) UNSIGNED NOT NULL,
  `home_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sdetect_rooms`
--

INSERT INTO `sdetect_rooms` (`id`, `name`, `floor_id`, `home_id`, `user_id`, `created_at`, `updated_at`) VALUES
(6, 'Room 2', 5, 8, 84, '2019-02-28 23:42:00', '2019-02-28 23:42:00'),
(7, 'Room 2', 5, 10, 84, '2019-02-28 23:42:00', '2019-02-28 23:42:00'),
(8, 'Room 2', 5, 9, 85, '2019-05-07 22:39:42', '2019-05-07 22:39:42'),
(9, 'Room 4', 5, 8, 85, '2019-05-07 22:39:42', '2019-05-07 22:39:42');

-- --------------------------------------------------------

--
-- Table structure for table `sdetect_shared_machines`
--

CREATE TABLE `sdetect_shared_machines` (
  `id` int(10) UNSIGNED NOT NULL,
  `machine_id` int(11) NOT NULL,
  `shared_with` int(11) NOT NULL,
  `shared_by` int(11) NOT NULL,
  `is_approved` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sdetect_shared_machines`
--

INSERT INTO `sdetect_shared_machines` (`id`, `machine_id`, `shared_with`, `shared_by`, `is_approved`, `created_at`, `updated_at`) VALUES
(4, 24, 84, 85, 0, '2019-03-05 04:12:26', '2019-03-05 04:12:26'),
(5, 24, 23, 84, 0, '2019-03-05 04:12:26', '2019-03-05 04:12:26');

-- --------------------------------------------------------

--
-- Table structure for table `sdetect_valves`
--

CREATE TABLE `sdetect_valves` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_id` int(10) UNSIGNED NOT NULL,
  `alarm` tinyint(1) NOT NULL,
  `valve_status` tinyint(1) NOT NULL,
  `reset` tinyint(1) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tank_auth_users`
--

CREATE TABLE `tank_auth_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `profile_pic` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `device_id` text COLLATE utf8_unicode_ci NOT NULL,
  `device_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `device_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `activated` tinyint(4) NOT NULL,
  `role` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `banned` tinyint(4) NOT NULL,
  `ban_reason` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `new_password_key` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `new_password_requested` datetime NOT NULL,
  `new_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `new_email_key` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tank_auth_users`
--

INSERT INTO `tank_auth_users` (`id`, `username`, `password`, `email`, `phone`, `name`, `profile_pic`, `device_id`, `device_token`, `device_type`, `activated`, `role`, `banned`, `ban_reason`, `password_reset_token`, `new_password_key`, `new_password_requested`, `new_email`, `new_email_key`, `last_ip`, `last_login`, `created_at`, `updated_at`, `modified`) VALUES
(1, 'admin', '$2y$10$N3A8m7NuIH5AOpOOCmRl4e1jr1A9orIQA1XE0MfWEiUM7Ft9qYt.m', 'admin1@admin.com', '9814158141', 'Amanpreet', '', '534553', '534654345', 'IOS', 1, 'ADMIN', 0, '', '', '', '0000-00-00 00:00:00', '', '', '124.253.134.1', '2018-12-04 12:37:54', '2018-08-02 06:42:45', '2018-08-02 06:42:45', '0000-00-00 00:00:00'),
(84, 'gurpreet2', '$2y$10$LKfQP78qDxB6rEl9K1KLieCpsOYhS6r8lQCwi29lUgCoQ1P4HFj0W', 'gurpreet2501@gmail.com', '9814158141', 'Amanpreet', '', 'ce64107bab008b7d12b0f6096dcd580cbbee7f4a7cd0b827408ed67b0aa65a3b', 'ce64107bab008b7d12b0f6096dcd580cbbee7f4a7cd0b827408ed67b0aa65a3b', 'IOS', 1, 'CUSTOMER', 0, '', '', '', '0000-00-00 00:00:00', '', '', '', '0000-00-00 00:00:00', '2019-03-01 05:00:28', '2019-06-08 07:10:48', '0000-00-00 00:00:00'),
(85, 'test', '$2y$10$RCLXYuNMsTh0mM1Hhd8.YufJ1tnW1ZSMNqsI95ofC.U9nG4ANgsyW', 'gurpreet2502@gmail.com', '9814158141', 'Amanpreet', '', '43535435', '4324324324232', 'ANDROID', 1, 'CUSTOMER', 0, '', '', '', '0000-00-00 00:00:00', '', '', '', '0000-00-00 00:00:00', '2019-03-05 08:29:10', '2019-03-05 08:29:24', '0000-00-00 00:00:00'),
(86, 'testd', '$2y$10$.EMNznLxAB5vqtvEahIzQOZI5TyURJSKn3TwvLTS6HLQvGyhO6G.u', 'gurpreet250s1@gmail.com', '9814158141', 'Amanpreet', '', '342424', '78346583456356385635', 'ANDROID', 1, 'CUSTOMER', 0, '', '', '', '0000-00-00 00:00:00', '', '', '', '0000-00-00 00:00:00', '2019-04-27 15:58:11', '2019-04-27 15:58:11', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tank_auth_user_autologin`
--

CREATE TABLE `tank_auth_user_autologin` (
  `key_id` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_agent` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_sessions`
--

INSERT INTO `user_sessions` (`id`, `user_id`, `token`, `created_at`, `updated_at`) VALUES
(1, 79, '2y10DnKbMwmCzGEj3wpFusbT1Oeke12Pve43YcgN6BAPXTrFffM5mye', '2019-02-26 03:19:16', '2019-02-26 03:24:47'),
(2, 80, '2y10DChMSqEiO9fCpdJxIKvQnMNHcqGr7mqdb9xGU3Z1drf25NphR', '2019-02-26 03:25:16', '2019-02-26 03:25:16'),
(3, 81, '2y10iKf3DKqfUQeXkLkgAnFeo2g9uQlypaS9azFy6GODFVFPaaARi', '2019-02-26 03:28:00', '2019-02-26 03:29:10'),
(4, 82, '2y10LnxnJBwqCg5Gxj4pglUOGuiP5rtqjEhoLEXOUqDGFT4tMRa6OU06', '2019-02-28 10:31:49', '2019-02-28 10:31:49'),
(5, 83, '2y10GGsLO8S0JxcPYGS3Cjk0xeTnFxbDtHeaJbY7TF75q2n1jNmhD4Oqe', '2019-02-28 09:49:09', '2019-02-28 09:49:09'),
(6, 84, '2y10MNNyaXXLU9riTNnqtE3CqHvm0ShN67rmSff9Ad6bd0Umc94n7IW', '2019-02-28 23:30:28', '2019-02-28 23:30:28'),
(7, 85, '2y10Dj4D3w7vHXslclpZtR328MI8gUffndWVpBlieTHzLLKAaPoYy', '2019-03-05 02:59:10', '2019-03-05 02:59:10'),
(8, 86, '2y10bUlxym9cwIgeSa003BgO78NZ191bCJTEgLlEKO1bDUAmluGiEa', '2019-04-27 10:28:11', '2019-04-27 10:28:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sdetect_floors`
--
ALTER TABLE `sdetect_floors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sdetect_floors_home_id_foreign` (`home_id`);

--
-- Indexes for table `sdetect_homes`
--
ALTER TABLE `sdetect_homes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sdetect_machines`
--
ALTER TABLE `sdetect_machines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sdetect_machines_floor_id_foreign` (`floor_id`),
  ADD KEY `sdetect_machines_room_id_foreign` (`room_id`),
  ADD KEY `sdetect_machines_home_id_foreign` (`home_id`);

--
-- Indexes for table `sdetect_motion_detectors`
--
ALTER TABLE `sdetect_motion_detectors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sdetect_rooms`
--
ALTER TABLE `sdetect_rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sdetect_rooms_floor_id_foreign` (`floor_id`),
  ADD KEY `sdetect_rooms_home_id_foreign` (`home_id`);

--
-- Indexes for table `sdetect_shared_machines`
--
ALTER TABLE `sdetect_shared_machines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sdetect_valves`
--
ALTER TABLE `sdetect_valves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tank_auth_users`
--
ALTER TABLE `tank_auth_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tank_auth_user_autologin`
--
ALTER TABLE `tank_auth_user_autologin`
  ADD PRIMARY KEY (`key_id`,`user_id`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_sessions_user_id_unique` (`user_id`),
  ADD UNIQUE KEY `user_sessions_token_unique` (`token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `sdetect_floors`
--
ALTER TABLE `sdetect_floors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sdetect_homes`
--
ALTER TABLE `sdetect_homes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sdetect_machines`
--
ALTER TABLE `sdetect_machines`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `sdetect_motion_detectors`
--
ALTER TABLE `sdetect_motion_detectors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sdetect_rooms`
--
ALTER TABLE `sdetect_rooms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sdetect_shared_machines`
--
ALTER TABLE `sdetect_shared_machines`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sdetect_valves`
--
ALTER TABLE `sdetect_valves`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tank_auth_users`
--
ALTER TABLE `tank_auth_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sdetect_floors`
--
ALTER TABLE `sdetect_floors`
  ADD CONSTRAINT `sdetect_floors_home_id_foreign` FOREIGN KEY (`home_id`) REFERENCES `sdetect_homes` (`id`);

--
-- Constraints for table `sdetect_machines`
--
ALTER TABLE `sdetect_machines`
  ADD CONSTRAINT `sdetect_machines_floor_id_foreign` FOREIGN KEY (`floor_id`) REFERENCES `sdetect_floors` (`id`),
  ADD CONSTRAINT `sdetect_machines_home_id_foreign` FOREIGN KEY (`home_id`) REFERENCES `sdetect_homes` (`id`),
  ADD CONSTRAINT `sdetect_machines_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `sdetect_rooms` (`id`);

--
-- Constraints for table `sdetect_rooms`
--
ALTER TABLE `sdetect_rooms`
  ADD CONSTRAINT `sdetect_rooms_floor_id_foreign` FOREIGN KEY (`floor_id`) REFERENCES `sdetect_floors` (`id`),
  ADD CONSTRAINT `sdetect_rooms_home_id_foreign` FOREIGN KEY (`home_id`) REFERENCES `sdetect_homes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
