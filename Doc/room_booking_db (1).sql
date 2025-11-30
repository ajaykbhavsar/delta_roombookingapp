-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2025 at 11:11 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `room_booking_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `room_type_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone_number` varchar(30) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `id_proof_type` varchar(50) NOT NULL,
  `id_number` varchar(255) NOT NULL,
  `location` varchar(50) NOT NULL,
  `room_status` varchar(30) NOT NULL,
  `room_location` text DEFAULT NULL,
  `occupancy_status` varchar(30) NOT NULL,
  `additional_description` text DEFAULT NULL,
  `booking_type` varchar(30) NOT NULL,
  `check_in_at` datetime NOT NULL,
  `check_out_at` datetime NOT NULL,
  `guest_count` tinyint(3) UNSIGNED NOT NULL,
  `room_rate` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `service_charges` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_type` varchar(30) NOT NULL,
  `payment_status` varchar(30) NOT NULL DEFAULT 'pending',
  `payment_details` text DEFAULT NULL,
  `is_repeat_customer` tinyint(1) NOT NULL DEFAULT 0,
  `notes` text DEFAULT NULL,
  `booking_status` varchar(30) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `reference_no`, `room_id`, `room_type_id`, `created_by`, `first_name`, `last_name`, `phone_number`, `email`, `address`, `id_proof_type`, `id_number`, `location`, `room_status`, `room_location`, `occupancy_status`, `additional_description`, `booking_type`, `check_in_at`, `check_out_at`, `guest_count`, `room_rate`, `discount`, `service_charges`, `total_amount`, `payment_type`, `payment_status`, `payment_details`, `is_repeat_customer`, `notes`, `booking_status`, `created_at`, `updated_at`) VALUES
(1, 'BK-251124-BNFM', 1, 2, 3, 'Siddharth', 'sheth', '7405136625', NULL, 'test', 'aadhar', '1234567895555', 'first_floor', 'clean', NULL, 'occupied', 'test', 'daily', '2025-11-24 18:00:00', '2025-11-25 09:00:00', 2, 0.00, 0.00, 0.00, 0.00, 'cash', 'pending', 'test', 0, 'test', 'checked_out', '2025-11-24 12:17:29', '2025-11-26 05:48:04'),
(2, 'BK-251126-PPPA', 1, 2, 3, 'Krishna', 'Krishna', '01234567890', 'krishnarohit2201@gmail.com', 'Test\r\nTest', 'aadhar', '1212121212121221', 'first_floor', 'clean', NULL, 'occupied', NULL, 'daily', '2025-11-26 11:20:00', '2025-11-27 11:20:00', 1, 0.00, 0.00, 0.00, 0.00, 'cash', 'pending', NULL, 0, NULL, 'checked_in', '2025-11-26 05:50:42', '2025-11-26 06:03:48'),
(3, 'BK-251126-JGZ6', 1, 1, 3, 'Siddharth', 'sheth', '7405136625', 'krishnarohit2201@gmail.com', 'Test\r\nTest', 'aadhar', '1212121212122', 'first_floor', 'clean', NULL, 'occupied', NULL, 'daily', '2025-11-26 11:20:00', '2025-11-27 11:31:00', 1, 0.00, 0.00, 0.00, 0.00, 'cash', 'pending', NULL, 0, NULL, 'pending', '2025-11-26 06:02:45', '2025-11-26 06:02:45'),
(4, 'BK-251126-VFZO', 2, 1, 3, 'Krishna', 'Krishna', '01234567890', 'krishnarohit2201@gmail.com', 'Test\r\nTest', 'aadhar', '12121212', 'second_floor', 'clean', NULL, 'occupied', NULL, 'daily', '2025-11-26 11:34:00', '2025-11-27 11:34:00', 1, 300.00, 50.00, 20.00, 270.00, 'cash', 'pending', NULL, 0, NULL, 'pending', '2025-11-26 06:04:24', '2025-11-26 06:34:03'),
(5, 'BK-251126-JNNU', 3, 1, 3, 'Test', 'Krishna', '01234567890', 'krishnarohit2201@gmail.com', 'Test\r\nTest', 'aadhar', '1212121212', 'second_floor', 'clean', 'Left Side Near Reception', 'occupied', 'test', 'daily', '2025-11-27 13:54:00', '2025-11-28 13:54:00', 1, 300.00, 0.00, 18.00, 318.00, 'cash', 'paid', NULL, 0, NULL, 'confirmed', '2025-11-26 08:25:08', '2025-11-26 08:50:48'),
(6, 'BK-251126-D64L', 3, 2, 4, 'Krishna', 'Krishna', '01234567890', 'krishnarohit2201@gmail.com', 'Test\r\nTest', 'aadhar', '543535354354', 'first_floor', 'clean', 'Left Side Near Reception', 'reserved', NULL, 'weekly', '2025-11-29 00:00:00', '2025-12-01 00:00:00', 1, 800.00, 0.00, 0.00, 800.00, 'cash', 'pending', NULL, 0, NULL, 'confirmed', '2025-11-26 09:15:03', '2025-11-26 09:15:03');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('bokking-application-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:0:{}s:11:\"permissions\";a:0:{}s:5:\"roles\";a:0:{}}', 1764221976),
('coa-cache-cache-admin@gmail.com|127.0.0.1', 'i:2;', 1764136355),
('coa-cache-cache-admin@gmail.com|127.0.0.1:timer', 'i:1764136355;', 1764136355),
('coa-cache-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:0:{}s:11:\"permissions\";a:0:{}s:5:\"roles\";a:0:{}}', 1764222469);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_31_050020_create_permission_tables', 1),
(5, '2025_10_31_050024_create_templates_table', 1),
(6, '2025_10_31_050027_create_template_assignments_table', 1),
(7, '2025_10_31_050028_create_template_logs_table', 1),
(8, '2025_10_31_050031_add_role_to_users_table', 1),
(9, '2025_10_31_174659_create_products_table', 2),
(11, '2025_10_31_175512_create_grades_table', 3),
(12, '2025_10_31_180420_add_product_id_and_grade_id_to_templates_table', 4),
(13, '2025_11_03_094820_create_test_cases_table', 5),
(14, '2025_11_03_094821_create_test_case_logs_table', 5),
(15, '2025_11_03_094822_add_unique_constraint_to_test_cases_table', 6),
(16, '2025_11_03_123510_update_unique_constraint_to_include_user_id_in_test_cases_table', 7),
(17, '2025_11_24_000000_create_system_logs_table', 8),
(18, '2025_11_24_010000_create_rooms_table', 9),
(19, '2025_11_24_020000_create_room_types_table', 10),
(20, '2025_11_24_030100_add_base_rate_to_room_types_table', 11),
(21, '2025_11_24_040000_create_bookings_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unique_id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `unique_id`, `title`, `is_active`, `created_at`, `updated_at`) VALUES
(4, 'PRD-FDEDB5A1', 'Methyl Salicylate USP', 1, '2025-11-03 12:28:14', '2025-11-03 12:28:14');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-10-30 23:33:30', '2025-10-30 23:33:30'),
(2, 'user', 'web', '2025-10-30 23:33:30', '2025-10-30 23:33:30'),
(3, 'super_admin', 'web', '2025-11-24 09:29:30', '2025-11-24 09:29:30');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_no` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `location` text DEFAULT NULL,
  `room_status` varchar(200) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_no`, `description`, `location`, `room_status`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Room No 001', NULL, NULL, NULL, 1, '2025-11-24 09:42:30', '2025-11-24 09:42:30'),
(2, 'Room -2', 'test', NULL, NULL, 1, '2025-11-26 05:52:08', '2025-11-26 05:52:08'),
(3, 'Room 003', 'Two room and Two bad', 'Left Side Near Reception', 'clean', 1, '2025-11-26 06:48:56', '2025-11-26 07:08:31');

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

CREATE TABLE `room_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `base_rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_types`
--

INSERT INTO `room_types` (`id`, `name`, `description`, `base_rate`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'NK', NULL, 300.00, 1, '2025-11-24 09:55:35', '2025-11-26 06:33:17'),
(2, 'NK2', NULL, 800.00, 1, '2025-11-24 09:55:42', '2025-11-26 06:33:10'),
(3, 'NK3', NULL, 500.00, 1, '2025-11-24 09:55:53', '2025-11-26 06:33:01');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3xR6PrVlcp2P5OcpuYTMNGbMKJwnRWjs3xxVNK2i', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMXhkSXc1akVkN3NLSTJWejI2SWxTdk1EZjFpd0NNVGRVZ2N4N2RnciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi91c2Vycy9jcmVhdGUiO3M6NToicm91dGUiO3M6MTg6ImFkbWluLnVzZXJzLmNyZWF0ZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1764149321),
('fiIVYBR2PdY1REGeMiSx5d7dUn1gMyTA52mtVA1A', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiS2hzOThJcEVJMkphdmtCZDVITnJnbTNpQVloUm1OMG9EM0d4RFF1NCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1764150760),
('I0N4AFEBzMg6LJjfzLRy4hfHNCfT6kqgF91kCKXL', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTEg2WXNwVGRVcFZTdUMxV3k3S001bDA5MVZ4UlZyYnpGMnJLYnduViI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ib29raW5ncyI7czo1OiJyb3V0ZSI7czoxNDoiYm9va2luZ3MuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO30=', 1764151060),
('SQpVXmL1H3RXdwOtgJUPnXskbIIYhabgWSPERxiq', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia3pTMkQyNDhBWm9QMDJrOU0wUG5kVzZpemJtOXlySzNwNXFvbDhpMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=', 1764151068);

-- --------------------------------------------------------

--
-- Table structure for table `system_logs`
--

CREATE TABLE `system_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload`)),
  `performed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_logs`
--

INSERT INTO `system_logs` (`id`, `action`, `payload`, `performed_by`, `created_at`, `updated_at`) VALUES
(1, 'user_updated', '{\"summary\":\"Updated user Test User\",\"user_id\":2}', 1, '2025-11-24 09:30:23', '2025-11-24 09:30:23'),
(2, 'room_created', '{\"summary\":\"Created room Room No 001\",\"room_id\":1}', 1, '2025-11-24 09:42:30', '2025-11-24 09:42:30'),
(3, 'room_type_created', '{\"summary\":\"Created room type NK\",\"room_type_id\":1}', 1, '2025-11-24 09:55:35', '2025-11-24 09:55:35'),
(4, 'room_type_created', '{\"summary\":\"Created room type NK2\",\"room_type_id\":2}', 1, '2025-11-24 09:55:42', '2025-11-24 09:55:42'),
(5, 'room_type_created', '{\"summary\":\"Created room type NK3\",\"room_type_id\":3}', 1, '2025-11-24 09:55:53', '2025-11-24 09:55:53'),
(6, 'user_updated', '{\"summary\":\"Updated user Admin User\",\"user_id\":1}', 1, '2025-11-24 09:56:18', '2025-11-24 09:56:18'),
(7, 'booking_created', '{\"summary\":\"Created booking BK-251124-BNFM\",\"booking_id\":1,\"room_id\":1,\"room_type_id\":2}', 3, '2025-11-24 12:17:29', '2025-11-24 12:17:29'),
(8, 'booking_updated', '{\"summary\":\"Updated booking BK-251124-BNFM\",\"booking_id\":1,\"room_id\":1,\"room_type_id\":2}', 3, '2025-11-24 12:43:08', '2025-11-24 12:43:08'),
(9, 'booking_updated', '{\"summary\":\"Updated booking BK-251124-BNFM\",\"booking_id\":1,\"room_id\":1,\"room_type_id\":2}', 3, '2025-11-24 12:59:15', '2025-11-24 12:59:15'),
(10, 'booking_updated', '{\"summary\":\"Updated booking BK-251124-BNFM\",\"booking_id\":1,\"room_id\":1,\"room_type_id\":2}', 3, '2025-11-24 13:00:10', '2025-11-24 13:00:10'),
(11, 'booking_updated', '{\"summary\":\"Updated booking BK-251124-BNFM\",\"booking_id\":1,\"room_id\":1,\"room_type_id\":2}', 3, '2025-11-26 05:48:04', '2025-11-26 05:48:04'),
(12, 'booking_created', '{\"summary\":\"Created booking BK-251126-PPPA\",\"booking_id\":2,\"room_id\":1,\"room_type_id\":2}', 3, '2025-11-26 05:50:42', '2025-11-26 05:50:42'),
(13, 'room_created', '{\"summary\":\"Created room Room -2\",\"room_id\":2}', 1, '2025-11-26 05:52:08', '2025-11-26 05:52:08'),
(14, 'booking_created', '{\"summary\":\"Created booking BK-251126-JGZ6\",\"booking_id\":3,\"room_id\":1,\"room_type_id\":1}', 3, '2025-11-26 06:02:45', '2025-11-26 06:02:45'),
(15, 'booking_updated', '{\"summary\":\"Updated booking BK-251126-PPPA\",\"booking_id\":2,\"room_id\":1,\"room_type_id\":2}', 3, '2025-11-26 06:03:48', '2025-11-26 06:03:48'),
(16, 'booking_created', '{\"summary\":\"Created booking BK-251126-VFZO\",\"booking_id\":4,\"room_id\":1,\"room_type_id\":1}', 3, '2025-11-26 06:04:24', '2025-11-26 06:04:24'),
(17, 'room_type_updated', '{\"summary\":\"Updated room type NK3\",\"room_type_id\":3}', 1, '2025-11-26 06:33:01', '2025-11-26 06:33:01'),
(18, 'room_type_updated', '{\"summary\":\"Updated room type NK2\",\"room_type_id\":2}', 1, '2025-11-26 06:33:10', '2025-11-26 06:33:10'),
(19, 'room_type_updated', '{\"summary\":\"Updated room type NK\",\"room_type_id\":1}', 1, '2025-11-26 06:33:17', '2025-11-26 06:33:17'),
(20, 'booking_updated', '{\"summary\":\"Updated booking BK-251126-VFZO\",\"booking_id\":4,\"room_id\":2,\"room_type_id\":1}', 3, '2025-11-26 06:34:03', '2025-11-26 06:34:03'),
(21, 'room_created', '{\"summary\":\"Created room Room 003\",\"room_id\":3}', 1, '2025-11-26 06:48:56', '2025-11-26 06:48:56'),
(22, 'room_updated', '{\"summary\":\"Updated room Room 003\",\"room_id\":3}', 1, '2025-11-26 06:51:44', '2025-11-26 06:51:44'),
(23, 'room_updated', '{\"summary\":\"Updated room Room 003\",\"room_id\":3}', 1, '2025-11-26 06:52:30', '2025-11-26 06:52:30'),
(24, 'room_updated', '{\"summary\":\"Updated room Room 003\",\"room_id\":3}', 1, '2025-11-26 06:54:48', '2025-11-26 06:54:48'),
(25, 'room_updated', '{\"summary\":\"Updated room Room 003\",\"room_id\":3}', 1, '2025-11-26 07:08:31', '2025-11-26 07:08:31'),
(26, 'booking_created', '{\"summary\":\"Created booking BK-251126-JNNU\",\"booking_id\":5,\"room_id\":3,\"room_type_id\":1}', 3, '2025-11-26 08:25:08', '2025-11-26 08:25:08'),
(27, 'booking_updated', '{\"summary\":\"Updated booking BK-251126-JNNU\",\"booking_id\":5,\"room_id\":3,\"room_type_id\":1}', 3, '2025-11-26 08:25:33', '2025-11-26 08:25:33'),
(28, 'booking_updated', '{\"summary\":\"Updated booking BK-251126-JNNU\",\"booking_id\":5,\"room_id\":3,\"room_type_id\":1}', 3, '2025-11-26 08:39:15', '2025-11-26 08:39:15'),
(29, 'booking_updated', '{\"summary\":\"Updated booking BK-251126-JNNU\",\"booking_id\":5,\"room_id\":3,\"room_type_id\":1}', 3, '2025-11-26 08:48:14', '2025-11-26 08:48:14'),
(30, 'booking_updated', '{\"summary\":\"Updated booking BK-251126-JNNU\",\"booking_id\":5,\"room_id\":2,\"room_type_id\":1}', 3, '2025-11-26 08:49:49', '2025-11-26 08:49:49'),
(31, 'booking_updated', '{\"summary\":\"Updated booking BK-251126-JNNU\",\"booking_id\":5,\"room_id\":3,\"room_type_id\":1}', 3, '2025-11-26 08:50:48', '2025-11-26 08:50:48'),
(32, 'booking_created', '{\"summary\":\"Created booking BK-251126-D64L\",\"booking_id\":6,\"room_id\":3,\"room_type_id\":2}', 4, '2025-11-26 09:15:03', '2025-11-26 09:15:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@example.com', 'super_admin', NULL, '$2y$12$y9xQClgCvRf23HYjE9G3Muyn5b1KpnmVY0OIoc0vul62ZZWPzHv/6', NULL, '2025-10-30 23:33:30', '2025-11-24 12:12:04'),
(2, 'Test User', 'user@example.com', 'admin', NULL, '$2y$12$mgQu32eg/qqUUlHgdnPS/eJPhDab2ZgcmujnTis86OhL8cDhCqUvq', NULL, '2025-10-30 23:33:31', '2025-11-24 09:30:23'),
(3, 'Siddharth', 'siddharth.sheth@meghtechnologies.com', 'user', NULL, '$2y$12$Zrik0YiV.d6Qiwb0Ev3P8OXQa/QeLLcn8hcgihhUV39wrZUOTHpPS', NULL, '2025-10-30 23:47:59', '2025-10-30 23:47:59'),
(4, 'Siddharth', 'siddharth@meghtechnologies.com', 'user', NULL, '$2y$12$Zrik0YiV.d6Qiwb0Ev3P8OXQa/QeLLcn8hcgihhUV39wrZUOTHpPS', NULL, '2025-10-30 23:47:59', '2025-10-30 23:47:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bookings_reference_no_unique` (`reference_no`),
  ADD KEY `bookings_booking_status_index` (`booking_status`),
  ADD KEY `bookings_payment_status_index` (`payment_status`),
  ADD KEY `bookings_room_id_index` (`room_id`),
  ADD KEY `bookings_room_type_id_index` (`room_type_id`),
  ADD KEY `bookings_created_by_index` (`created_by`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_unique_id_unique` (`unique_id`),
  ADD UNIQUE KEY `products_title_unique` (`title`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rooms_room_no_unique` (`room_no`);

--
-- Indexes for table `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `room_types_name_unique` (`name`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `system_logs`
--
ALTER TABLE `system_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `system_logs_performed_by_foreign` (`performed_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `system_logs`
--
ALTER TABLE `system_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `bookings_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON UPDATE CASCADE;

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
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `system_logs`
--
ALTER TABLE `system_logs`
  ADD CONSTRAINT `system_logs_performed_by_foreign` FOREIGN KEY (`performed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
