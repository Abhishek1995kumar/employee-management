-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 10, 2025 at 04:34 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employees_hrms`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_branches`
--

CREATE TABLE `customer_branches` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint DEFAULT '1' COMMENT '1=active, 0=inactive',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_branches`
--

INSERT INTO `customer_branches` (`id`, `customer_id`, `branch_id`, `branch_name`, `branch_city`, `branch_state`, `branch_country`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '1', 'branch_1002', 'Tilak Nagar', 'New Delhi', 'Delhi', 'Bharat', 1, NULL, NULL, NULL),
(2, '1', 'branch_1003', 'Subhash Nagar', 'New Delhi', 'Delhi', 'Bharat', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Name of the department',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Description of the department',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active' COMMENT '1=active, 2=archived, 0=inactive',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'User ID of the creator',
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'User ID of the last updater',
  `deleted_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Reason for deletion, if applicable',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'For soft delete functionality',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `slug`, `description`, `status`, `created_by`, `updated_by`, `deleted_reason`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Human Resources', 'human_resources', 'Handles employee relations and benefits.', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Finance', 'finance', 'Manages financial records and budgets.', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'IT', 'it', 'Responsible for technology and systems.', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Marketing', 'marketing', 'Oversees marketing strategies and campaigns.', 'active', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Sales', 'sales', 'Handles sales and customer relationships.', 'active', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint UNSIGNED NOT NULL,
  `department_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` tinyint DEFAULT NULL,
  `updated_by` tinyint DEFAULT NULL,
  `deleted_by` tinyint DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `department_id`, `name`, `slug`, `description`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'HR', 'hr', 'human resource', 1, NULL, NULL, NULL, '2025-07-05 13:02:15', '2025-07-05 13:02:15'),
(2, 3, 'Manager', 'manager', 'manager', 1, NULL, NULL, NULL, '2025-07-05 13:02:15', '2025-07-05 13:02:15');

-- --------------------------------------------------------

--
-- Table structure for table `dump_holidays`
--

CREATE TABLE `dump_holidays` (
  `id` bigint UNSIGNED NOT NULL,
  `error_excel_report_id` bigint UNSIGNED NOT NULL,
  `branch_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holiday_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holiday_category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holiday_day` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holiday_month` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holiday_year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holiday_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `holiday_image` longtext COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `has_errors` tinyint NOT NULL COMMENT '1=find error, 0=success',
  `errors` longtext COLLATE utf8mb4_unicode_ci,
  `is_processed` tinyint NOT NULL COMMENT '0=process complete, 1=process failed, 2=process pending',
  `is_validated` tinyint NOT NULL DEFAULT '0' COMMENT '0=validation failed, 1=validate',
  `status` tinyint NOT NULL COMMENT '0=error, 1=success',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dump_holidays`
--

INSERT INTO `dump_holidays` (`id`, `error_excel_report_id`, `branch_id`, `branch_name`, `holiday_name`, `holiday_category`, `holiday_day`, `holiday_month`, `holiday_year`, `holiday_color`, `start_date`, `end_date`, `holiday_image`, `description`, `has_errors`, `errors`, `is_processed`, `is_validated`, `status`, `created_at`, `updated_at`) VALUES
(1, 22, 'branch_1002', 'Tilak Nagar', 'Republic Day', 'National Holiday', 'Sunday', 'January', '2025', '#FF6F61', '2025-01-26', '2025-01-26', NULL, NULL, 1, '[\"Branch name is required.\",\"Holiday start date is required.\",\"Holiday end date is required.\"]', 0, 1, 1, '2025-10-03 12:33:36', '2025-10-03 12:33:36'),
(2, 22, 'branch_1002', 'Tilak Nagar', 'Maha Shivaratri', 'National Holiday', 'Wednesday', 'February', '2025', '#6B5B95', '2025-02-26', '2025-02-26', NULL, NULL, 1, '[\"Branch name is required.\",\"Holiday start date is required.\",\"Holiday end date is required.\"]', 0, 1, 1, '2025-10-03 12:33:36', '2025-10-03 12:33:36'),
(3, 22, 'branch_1002', 'Tilak Nagar', 'Holi / Dhulivandan', 'National Holiday', 'Friday', 'March', '2025', '#88B04B', '2025-03-14', '2025-03-15', NULL, NULL, 1, '[\"Branch name is required.\",\"Holiday start date is required.\",\"Holiday end date is required.\"]', 0, 1, 1, '2025-10-03 12:33:36', '2025-10-03 12:33:36'),
(4, 22, 'branch_1002', 'Tilak Nagar', 'Id-ul-Fitr', 'Regional Holiday', 'Monday', 'March', '2025', '#F7CAC9', '2025-03-31', '2025-03-31', NULL, NULL, 1, '[\"Branch name is required.\",\"Holiday start date is required.\",\"Holiday end date is required.\"]', 0, 1, 1, '2025-10-03 12:33:36', '2025-10-03 12:33:36'),
(5, 22, 'branch_1002', 'Tilak Nagar', 'Mahavir Jayanti', 'Regional Holiday', 'Thursday', 'April', '2025', '#92A8D1', '2025-04-10', '2025-04-10', NULL, NULL, 1, '[\"Branch name is required.\",\"Holiday start date is required.\",\"Holiday end date is required.\"]', 0, 1, 1, '2025-10-03 12:33:36', '2025-10-03 12:33:36'),
(6, 22, 'branch_1002', 'Tilak Nagar', 'Vaisakhadi (Bengal)/Bahag Bihu (Assam) (RH)', 'Regional Holiday', 'Tuesday', 'April', '2025', '#955251', '2025-04-15', '2025-04-15', NULL, NULL, 1, '[\"Branch name is required.\",\"Holiday start date is required.\",\"Holiday end date is required.\"]', 0, 1, 1, '2025-10-03 12:33:36', '2025-10-03 12:33:36'),
(7, 22, 'branch_1002', 'Tilak Nagar', 'Good Friday', 'National Holiday', 'Friday', 'April', '2025', '#B565A7', '2025-04-18', '2025-04-18', NULL, NULL, 1, '[\"Branch name is required.\",\"Holiday start date is required.\",\"Holiday end date is required.\"]', 0, 1, 1, '2025-10-03 12:33:36', '2025-10-03 12:33:36'),
(8, 22, 'branch_1002', 'Tilak Nagar', 'Buddha Purnima', 'Local Holiday', 'Monday', 'May', '2025', '#009B77', '2025-05-12', '2025-05-12', NULL, NULL, 1, '[\"Branch name is required.\",\"Holiday start date is required.\",\"Holiday end date is required.\"]', 0, 1, 1, '2025-10-03 12:33:36', '2025-10-03 12:33:36'),
(9, 22, 'branch_1002', 'Tilak Nagar', 'Id-ul-Zuha (Bakri-id)', 'Regional Holiday', 'Saturday', 'June', '2025', '#DD4124', '2025-06-07', '2025-06-07', NULL, NULL, 1, '[\"Branch name is required.\",\"Holiday start date is required.\",\"Holiday end date is required.\"]', 0, 1, 1, '2025-10-03 12:33:36', '2025-10-03 12:33:36'),
(10, 22, 'branch_1002', 'Tilak Nagar', 'Muharram', 'Regional Holiday', 'Sunday', 'July', '2025', '#D65076', '2025-07-06', '2025-07-06', NULL, NULL, 1, '[\"Branch name is required.\",\"Holiday start date is required.\",\"Holiday end date is required.\"]', 0, 1, 1, '2025-10-03 12:33:36', '2025-10-03 12:33:36'),
(11, 22, 'branch_1002', 'Tilak Nagar', 'Independence Day', 'National Holiday', 'Friday', 'August', '2025', '#45B8AC', '2025-08-15', '2025-08-15', NULL, NULL, 1, '[\"Branch name is required.\",\"Holiday start date is required.\",\"Holiday end date is required.\"]', 0, 1, 1, '2025-10-03 12:33:36', '2025-10-03 12:33:36'),
(12, 22, 'branch_1002', 'Tilak Nagar', 'Ganesh Chaturthi/ Vinayak Chaturthi', 'Regional Holiday', 'Wednesday', 'August', '2025', '#EFC050', '2025-08-27', '2025-08-27', NULL, NULL, 1, '[\"Branch name is required.\",\"Holiday start date is required.\",\"Holiday end date is required.\"]', 0, 1, 1, '2025-10-03 12:33:36', '2025-10-03 12:33:36'),
(13, 22, 'branch_1002', 'Tilak Nagar', 'Milad un Nabi or Id-e-Milad', 'Regional Holiday', 'Friday', 'September', '2025', '#5B5EA6', '2025-09-05', '2025-09-05', NULL, NULL, 1, '[\"Branch name is required.\",\"Holiday start date is required.\",\"Holiday end date is required.\"]', 0, 1, 1, '2025-10-03 12:33:36', '2025-10-03 12:33:36'),
(14, 22, 'branch_1002', 'Tilak Nagar', 'Anant Chaturdashi(RH)', 'Regional Holiday', 'Saturday', 'September', '2025', '#9B2335', '2025-09-06', '2025-09-06', NULL, NULL, 1, '[\"Branch name is required.\",\"Holiday start date is required.\",\"Holiday end date is required.\"]', 0, 1, 1, '2025-10-03 12:33:36', '2025-10-03 12:33:36'),
(15, 22, 'branch_1002', 'Tilak Nagar', 'Mahatma Gandhi’s Birthday', 'National Holiday', 'Thursday', 'October', '2025', '#BC243C', '2025-10-02', '2025-10-02', NULL, NULL, 1, '[\"Branch name is required.\",\"Holiday start date is required.\",\"Holiday end date is required.\"]', 0, 1, 1, '2025-10-03 12:33:36', '2025-10-03 12:33:36'),
(16, 22, 'branch_1002', 'Tilak Nagar', 'Dussehra (Vijayadashami)', 'National Holiday', 'Thursday', 'October', '2025', '#C3447A', '2025-10-02', '2025-10-02', NULL, NULL, 1, '[\"Branch name is required.\",\"Holiday start date is required.\",\"Holiday end date is required.\"]', 0, 1, 1, '2025-10-03 12:33:36', '2025-10-03 12:33:36'),
(17, 22, 'branch_1002', 'Tilak Nagar', 'Diwali (Deepavali) Dhantrayodashi', 'National Holiday', 'Monday', 'October', '2025', '#98B4D4', '2025-10-20', '2025-10-20', NULL, NULL, 1, '[\"Branch name is required.\",\"Holiday start date is required.\",\"Holiday end date is required.\"]', 0, 1, 1, '2025-10-03 12:33:36', '2025-10-03 12:33:36'),
(18, 22, 'branch_1002', 'Tilak Nagar', 'Diwali Amavasya (Laxmi Pujan) (RH)', 'National Holiday', 'Tuesday', 'October', '2025', '#DEEAEE', '2025-10-21', '2025-10-21', NULL, NULL, 1, '[\"Branch name is required.\",\"Holiday start date is required.\",\"Holiday end date is required.\"]', 0, 1, 1, '2025-10-03 12:33:36', '2025-10-03 12:33:36'),
(19, 22, 'branch_1002', 'Tilak Nagar', 'Govardhan Puja(RH)', 'Regional Holiday', 'Wednesday', 'October', '2025', '#7BC4C4', '2025-10-22', '2025-10-22', NULL, NULL, 1, '[\"Branch name is required.\",\"Holiday start date is required.\",\"Holiday end date is required.\"]', 0, 1, 1, '2025-10-03 12:33:36', '2025-10-03 12:33:36'),
(20, 22, 'branch_1002', 'Tilak Nagar', 'Bhaidooj/ Balipratipada(RH)', 'Regional Holiday', 'Thursday', 'October', '2025', '#E15D44', '2025-10-23', '2025-10-23', NULL, NULL, 1, '[\"Branch name is required.\",\"Holiday start date is required.\",\"Holiday end date is required.\"]', 0, 1, 1, '2025-10-03 12:33:36', '2025-10-03 12:33:36'),
(21, 22, 'branch_1002', 'Tilak Nagar', 'Guru Nanak’s Birthday', 'Regional Holiday', 'Wednesday', 'November', '2025', '#53B0AE', '2025-11-05', '2025-11-05', NULL, NULL, 1, '[\"Branch name is required.\",\"Holiday start date is required.\",\"Holiday end date is required.\"]', 0, 1, 1, '2025-10-03 12:33:36', '2025-10-03 12:33:36'),
(22, 22, 'branch_1002', 'Tilak Nagar', 'Christmas Day', 'National Holiday', 'Thursday', 'December', '2025', '#EFC7C2', '2025-12-25', '2025-12-25', NULL, NULL, 1, '[\"Branch name is required.\",\"Holiday start date is required.\",\"Holiday end date is required.\"]', 0, 1, 1, '2025-10-03 12:33:36', '2025-10-03 12:33:36');

-- --------------------------------------------------------

--
-- Table structure for table `excel_error_reports`
--

CREATE TABLE `excel_error_reports` (
  `id` bigint UNSIGNED NOT NULL,
  `branch_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_id` bigint DEFAULT NULL,
  `document_type_id` bigint UNSIGNED NOT NULL,
  `original_document_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `error_document_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `has_errors` tinyint DEFAULT NULL,
  `errors` longtext COLLATE utf8mb4_unicode_ci,
  `is_processed` tinyint DEFAULT '2' COMMENT '1=Complete, 2=Pending',
  `is_validated` tinyint DEFAULT '2' COMMENT '1=Validate, 2=Not validate',
  `status` tinyint DEFAULT '2' COMMENT '1=Success, 2=Failed',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `firms`
--

CREATE TABLE `firms` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firm_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firm_location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firm_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firm_state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firm_country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint DEFAULT '1' COMMENT '1=active, 0=inactive',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` bigint UNSIGNED NOT NULL,
  `branch_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `created_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `holiday_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holiday_day` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holiday_month` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holiday_year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holiday_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `holiday_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holiday_category` tinyint DEFAULT '1' COMMENT '1=National Holiday, 2=State Holiday',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint DEFAULT '0' COMMENT '1=Active, 2=Inactive',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`id`, `branch_id`, `branch_name`, `created_by`, `updated_by`, `created_name`, `holiday_name`, `holiday_day`, `holiday_month`, `holiday_year`, `holiday_image`, `holiday_color`, `holiday_category`, `start_date`, `end_date`, `description`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'branch_1002', 'Tilak Nagar', 1, NULL, 'Abhishek', 'Republic Day', 'Sunday', 'January', '2025', NULL, '#FF6F61', 0, '2025-01-26', '2025-01-26', NULL, 1, NULL, '2025-10-03 12:33:36', NULL),
(2, 'branch_1002', 'Tilak Nagar', 1, NULL, 'Abhishek', 'Maha Shivaratri', 'Wednesday', 'February', '2025', NULL, '#6B5B95', 0, '2025-02-26', '2025-02-26', NULL, 1, NULL, '2025-10-03 12:33:36', NULL),
(3, 'branch_1002', 'Tilak Nagar', 1, NULL, 'Abhishek', 'Holi', 'Friday', 'March', '2025', NULL, '#88B04B', 0, '2025-03-14', '2025-03-15', NULL, 1, NULL, '2025-10-03 12:33:36', NULL),
(4, 'branch_1002', 'Tilak Nagar', 1, NULL, 'Abhishek', 'Id-ul-Fitr', 'Monday', 'March', '2025', NULL, '#F7CAC9', 0, '2025-03-31', '2025-03-31', NULL, 1, NULL, '2025-10-03 12:33:36', NULL),
(5, 'branch_1002', 'Tilak Nagar', 1, NULL, 'Abhishek', 'Mahavir Jayanti', 'Thursday', 'April', '2025', NULL, '#92A8D1', 0, '2025-04-10', '2025-04-10', NULL, 1, NULL, '2025-10-03 12:33:36', NULL),
(6, 'branch_1002', 'Tilak Nagar', 1, NULL, 'Abhishek', 'Vaisakhadi/Bahag Bihu', 'Tuesday', 'April', '2025', NULL, '#955251', 0, '2025-04-15', '2025-04-15', NULL, 1, NULL, '2025-10-03 12:33:36', NULL),
(7, 'branch_1002', 'Tilak Nagar', 1, NULL, 'Abhishek', 'Good Friday', 'Friday', 'April', '2025', NULL, '#B565A7', 0, '2025-04-18', '2025-04-18', NULL, 1, NULL, '2025-10-03 12:33:36', NULL),
(8, 'branch_1002', 'Tilak Nagar', 1, NULL, 'Abhishek', 'Buddha Purnima', 'Monday', 'May', '2025', NULL, '#009B77', 0, '2025-05-12', '2025-05-12', NULL, 1, NULL, '2025-10-03 12:33:36', NULL),
(9, 'branch_1002', 'Tilak Nagar', 1, NULL, 'Abhishek', 'Id-ul-Zuha (Bakri-id)', 'Saturday', 'June', '2025', NULL, '#DD4124', 0, '2025-06-07', '2025-06-07', NULL, 1, NULL, '2025-10-03 12:33:36', NULL),
(10, 'branch_1002', 'Tilak Nagar', 1, NULL, 'Abhishek', 'Muharram', 'Sunday', 'July', '2025', NULL, '#D65076', 0, '2025-07-06', '2025-07-06', NULL, 1, NULL, '2025-10-03 12:33:36', NULL),
(11, 'branch_1002', 'Tilak Nagar', 1, NULL, 'Abhishek', 'Independence Day', 'Friday', 'August', '2025', NULL, '#45B8AC', 0, '2025-08-15', '2025-08-15', NULL, 1, NULL, '2025-10-03 12:33:36', NULL),
(12, 'branch_1002', 'Tilak Nagar', 1, NULL, 'Abhishek', 'Ganesh Chaturthi', 'Wednesday', 'August', '2025', NULL, '#EFC050', 0, '2025-08-27', '2025-08-27', NULL, 1, NULL, '2025-10-03 12:33:36', NULL),
(13, 'branch_1002', 'Tilak Nagar', 1, NULL, 'Abhishek', 'Id-e-Milad', 'Friday', 'September', '2025', NULL, '#5B5EA6', 0, '2025-09-05', '2025-09-05', NULL, 1, NULL, '2025-10-03 12:33:36', NULL),
(14, 'branch_1002', 'Tilak Nagar', 1, NULL, 'Abhishek', 'Anant Chaturdashi', 'Saturday', 'September', '2025', NULL, '#9B2335', 0, '2025-09-06', '2025-09-06', NULL, 1, NULL, '2025-10-03 12:33:36', NULL),
(16, 'branch_1002', 'Tilak Nagar', 1, NULL, 'Abhishek', 'Dussehra (Vijayadashami)', 'Thursday', 'October', '2025', NULL, '#C3447A', 0, '2025-10-02', '2025-10-02', NULL, 1, NULL, '2025-10-03 12:33:36', NULL),
(17, 'branch_1002', 'Tilak Nagar', 1, NULL, 'Abhishek', 'Diwali (Deepavali)', 'Monday', 'October', '2025', NULL, '#98B4D4', 0, '2025-10-20', '2025-10-20', NULL, 1, NULL, '2025-10-03 12:33:36', NULL),
(18, 'branch_1002', 'Tilak Nagar', 1, NULL, 'Abhishek', 'Diwali Amavasya', 'Tuesday', 'October', '2025', NULL, '#DEEAEE', 0, '2025-10-21', '2025-10-21', NULL, 1, NULL, '2025-10-03 12:33:36', NULL),
(19, 'branch_1002', 'Tilak Nagar', 1, NULL, 'Abhishek', 'Govardhan Puja', 'Wednesday', 'October', '2025', NULL, '#7BC4C4', 0, '2025-10-22', '2025-10-22', NULL, 1, NULL, '2025-10-03 12:33:36', NULL),
(20, 'branch_1002', 'Tilak Nagar', 1, NULL, 'Abhishek', 'Bhaidooj/ Balipratipada', 'Thursday', 'October', '2025', NULL, '#E15D44', 0, '2025-10-23', '2025-10-23', NULL, 1, NULL, '2025-10-03 12:33:36', NULL),
(21, 'branch_1002', 'Tilak Nagar', 1, NULL, 'Abhishek', 'Guru Nanak’s Birthday', 'Wednesday', 'November', '2025', NULL, '#53B0AE', 0, '2025-11-05', '2025-11-05', NULL, 1, NULL, '2025-10-03 12:33:36', NULL),
(22, 'branch_1002', 'Tilak Nagar', 1, NULL, 'Abhishek', 'Christmas Day', 'Thursday', 'December', '2025', NULL, '#EFC7C2', 0, '2025-12-25', '2025-12-25', NULL, 1, NULL, '2025-10-03 12:33:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `login_otp`
--

CREATE TABLE `login_otp` (
  `id` bigint UNSIGNED NOT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login_otp`
--

INSERT INTO `login_otp` (`id`, `otp`, `user_id`, `user_email`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '193110', '1', 'super.admin@gmail.com', '1', NULL, '2025-07-05 17:20:56', '2025-10-10 09:36:03'),
(2, '221172', '2', 'annaaryan936@gmail.com', '2', NULL, '2025-08-06 10:46:50', '2025-09-26 11:21:29'),
(3, '925703', '3', 'fatima93@gmail.com', '3', NULL, '2025-08-24 08:04:59', '2025-09-27 10:34:46');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `function_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` tinyint DEFAULT NULL,
  `updated_by` tinyint DEFAULT NULL,
  `deleted_by` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `action`, `function_name`, `data`, `ip`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:29:12', '2025-08-27 05:29:12'),
(2, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:29:45', '2025-08-27 05:29:45'),
(3, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:33:42', '2025-08-27 05:33:42'),
(4, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:34:22', '2025-08-27 05:34:22'),
(5, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:35:13', '2025-08-27 05:35:13'),
(6, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:46:06', '2025-08-27 05:46:06'),
(7, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:46:21', '2025-08-27 05:46:21'),
(8, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:46:35', '2025-08-27 05:46:35'),
(9, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:48:17', '2025-08-27 05:48:17'),
(10, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:48:29', '2025-08-27 05:48:29'),
(11, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:49:34', '2025-08-27 05:49:34'),
(12, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:49:50', '2025-08-27 05:49:50'),
(13, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:50:06', '2025-08-27 05:50:06'),
(14, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:50:21', '2025-08-27 05:50:21'),
(15, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:52:02', '2025-08-27 05:52:02'),
(16, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:52:54', '2025-08-27 05:52:54'),
(17, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:53:11', '2025-08-27 05:53:11'),
(18, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:53:36', '2025-08-27 05:53:36'),
(19, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:53:51', '2025-08-27 05:53:51'),
(20, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:54:10', '2025-08-27 05:54:10'),
(21, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:55:14', '2025-08-27 05:55:14'),
(22, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:55:35', '2025-08-27 05:55:35'),
(23, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:55:51', '2025-08-27 05:55:51'),
(24, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:56:09', '2025-08-27 05:56:09'),
(25, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:56:35', '2025-08-27 05:56:35'),
(26, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:57:37', '2025-08-27 05:57:37'),
(27, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:57:56', '2025-08-27 05:57:56'),
(28, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:58:15', '2025-08-27 05:58:15'),
(29, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:58:29', '2025-08-27 05:58:29'),
(30, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:58:48', '2025-08-27 05:58:48'),
(31, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:59:26', '2025-08-27 05:59:26'),
(32, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 05:59:46', '2025-08-27 05:59:46'),
(33, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 06:00:05', '2025-08-27 06:00:05'),
(34, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 06:00:20', '2025-08-27 06:00:20'),
(35, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-08-27 06:00:37', '2025-08-27 06:00:37'),
(36, 1, 'Role', 'save', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-08-27 06:02:38', '2025-08-27 06:02:38'),
(37, 1, 'Role', 'save', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-08-27 06:05:34', '2025-08-27 06:05:34'),
(38, 1, 'Role', 'save', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-08-27 06:06:15', '2025-08-27 06:06:15'),
(39, 3, 'Login', 'login', 'User', '127.0.0.1', 3, NULL, NULL, '2025-08-27 06:09:32', '2025-08-27 06:09:32'),
(40, 3, 'Logout', 'logout', 'User', '127.0.0.1', 3, NULL, NULL, '2025-08-27 06:17:03', '2025-08-27 06:17:03'),
(41, 2, 'Login', 'login', 'User', '127.0.0.1', 2, NULL, NULL, '2025-08-27 06:18:01', '2025-08-27 06:18:01'),
(42, 2, 'Logout', 'logout', 'User', '127.0.0.1', 2, NULL, NULL, '2025-08-27 06:47:03', '2025-08-27 06:47:03'),
(43, 2, 'Login', 'login', 'User', '127.0.0.1', 2, NULL, NULL, '2025-08-27 06:47:49', '2025-08-27 06:47:49'),
(44, 1, 'Login', 'login', 'User', '127.0.0.1', 1, NULL, NULL, '2025-08-29 22:58:01', '2025-08-29 22:58:01'),
(45, 1, 'Logout', 'logout', 'User', '127.0.0.1', 1, NULL, NULL, '2025-08-29 22:59:07', '2025-08-29 22:59:07'),
(46, 3, 'Login', 'login', 'User', '127.0.0.1', 3, NULL, NULL, '2025-09-08 09:55:26', '2025-09-08 09:55:26'),
(47, 3, 'Logout', 'logout', 'User', '127.0.0.1', 3, NULL, NULL, '2025-09-08 09:55:40', '2025-09-08 09:55:40'),
(48, 1, 'Login', 'login', 'User', '127.0.0.1', 1, NULL, NULL, '2025-09-08 09:56:10', '2025-09-08 09:56:10'),
(49, 1, 'Logout', 'logout', 'User', '127.0.0.1', 1, NULL, NULL, '2025-09-08 10:30:04', '2025-09-08 10:30:04'),
(50, 1, 'Login', 'login', 'User', '127.0.0.1', 1, NULL, NULL, '2025-09-08 10:32:05', '2025-09-08 10:32:05'),
(51, 1, 'Login', 'login', 'User', '127.0.0.1', 1, NULL, NULL, '2025-09-20 00:34:30', '2025-09-20 00:34:30'),
(52, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-20 00:37:19', '2025-09-20 00:37:19'),
(53, 1, 'Role', 'save', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-20 00:37:47', '2025-09-20 00:37:47'),
(54, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:05:35', '2025-09-20 10:05:35'),
(55, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:45:31', '2025-09-20 10:45:31'),
(56, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:46:08', '2025-09-20 10:46:08'),
(57, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:46:49', '2025-09-20 10:46:49'),
(58, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:49:13', '2025-09-20 10:49:13'),
(59, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:50:55', '2025-09-20 10:50:55'),
(60, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:51:24', '2025-09-20 10:51:24'),
(61, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:51:40', '2025-09-20 10:51:40'),
(62, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:51:57', '2025-09-20 10:51:57'),
(63, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:52:12', '2025-09-20 10:52:12'),
(64, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:52:38', '2025-09-20 10:52:38'),
(65, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:53:04', '2025-09-20 10:53:04'),
(66, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:53:26', '2025-09-20 10:53:26'),
(67, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:53:39', '2025-09-20 10:53:39'),
(68, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:53:57', '2025-09-20 10:53:57'),
(69, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:54:17', '2025-09-20 10:54:17'),
(70, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:54:32', '2025-09-20 10:54:32'),
(71, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:54:49', '2025-09-20 10:54:49'),
(72, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:55:04', '2025-09-20 10:55:04'),
(73, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:55:19', '2025-09-20 10:55:19'),
(74, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:56:13', '2025-09-20 10:56:13'),
(75, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:56:24', '2025-09-20 10:56:24'),
(76, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:56:37', '2025-09-20 10:56:37'),
(77, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:56:52', '2025-09-20 10:56:52'),
(78, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:57:08', '2025-09-20 10:57:08'),
(79, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:57:25', '2025-09-20 10:57:25'),
(80, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:57:36', '2025-09-20 10:57:36'),
(81, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:57:49', '2025-09-20 10:57:49'),
(82, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:58:04', '2025-09-20 10:58:04'),
(83, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:58:20', '2025-09-20 10:58:20'),
(84, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:58:47', '2025-09-20 10:58:47'),
(85, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:59:01', '2025-09-20 10:59:01'),
(86, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:59:14', '2025-09-20 10:59:14'),
(87, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:59:27', '2025-09-20 10:59:27'),
(88, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:59:38', '2025-09-20 10:59:38'),
(89, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 10:59:56', '2025-09-20 10:59:56'),
(90, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 11:00:08', '2025-09-20 11:00:08'),
(91, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 11:00:21', '2025-09-20 11:00:21'),
(92, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 11:00:39', '2025-09-20 11:00:39'),
(93, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-20 11:00:59', '2025-09-20 11:00:59'),
(94, 1, 'Logout', 'logout', 'User', '127.0.0.1', 1, NULL, NULL, '2025-09-20 13:05:18', '2025-09-20 13:05:18'),
(95, 1, 'Login', 'login', 'User', '127.0.0.1', 1, NULL, NULL, '2025-09-21 01:46:15', '2025-09-21 01:46:15'),
(96, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:37:24', '2025-09-21 05:37:24'),
(97, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:37:39', '2025-09-21 05:37:39'),
(98, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:38:03', '2025-09-21 05:38:03'),
(99, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:38:21', '2025-09-21 05:38:21'),
(100, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:38:33', '2025-09-21 05:38:33'),
(101, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:38:52', '2025-09-21 05:38:52'),
(102, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:39:04', '2025-09-21 05:39:04'),
(103, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:39:25', '2025-09-21 05:39:25'),
(104, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:39:35', '2025-09-21 05:39:35'),
(105, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:39:48', '2025-09-21 05:39:48'),
(106, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:39:58', '2025-09-21 05:39:58'),
(107, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:40:08', '2025-09-21 05:40:08'),
(108, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:40:19', '2025-09-21 05:40:19'),
(109, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:40:36', '2025-09-21 05:40:36'),
(110, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:40:46', '2025-09-21 05:40:46'),
(111, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:40:59', '2025-09-21 05:40:59'),
(112, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:41:08', '2025-09-21 05:41:08'),
(113, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:41:20', '2025-09-21 05:41:20'),
(114, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:41:31', '2025-09-21 05:41:31'),
(115, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:41:42', '2025-09-21 05:41:42'),
(116, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:42:02', '2025-09-21 05:42:02'),
(117, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:42:16', '2025-09-21 05:42:16'),
(118, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:42:30', '2025-09-21 05:42:30'),
(119, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:42:40', '2025-09-21 05:42:40'),
(120, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:42:49', '2025-09-21 05:42:49'),
(121, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:43:02', '2025-09-21 05:43:02'),
(122, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:43:11', '2025-09-21 05:43:11'),
(123, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:43:22', '2025-09-21 05:43:22'),
(124, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:43:37', '2025-09-21 05:43:37'),
(125, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:43:50', '2025-09-21 05:43:50'),
(126, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:44:02', '2025-09-21 05:44:02'),
(127, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:44:13', '2025-09-21 05:44:13'),
(128, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:44:37', '2025-09-21 05:44:37'),
(129, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:44:46', '2025-09-21 05:44:46'),
(130, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:44:56', '2025-09-21 05:44:56'),
(131, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:45:06', '2025-09-21 05:45:06'),
(132, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:45:15', '2025-09-21 05:45:15'),
(133, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:45:33', '2025-09-21 05:45:33'),
(134, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:45:43', '2025-09-21 05:45:43'),
(135, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:45:51', '2025-09-21 05:45:51'),
(136, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:46:03', '2025-09-21 05:46:03'),
(137, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-21 05:46:16', '2025-09-21 05:46:16'),
(138, 3, 'Login', 'login', 'User', '127.0.0.1', 3, NULL, NULL, '2025-09-21 06:13:56', '2025-09-21 06:13:56'),
(139, 1, 'Login', 'login', 'User', '127.0.0.1', 1, NULL, NULL, '2025-09-23 09:39:03', '2025-09-23 09:39:03'),
(140, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:15:07', '2025-09-23 10:15:07'),
(141, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:16:15', '2025-09-23 10:16:15'),
(142, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:16:31', '2025-09-23 10:16:31'),
(143, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:17:08', '2025-09-23 10:17:08'),
(144, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:18:05', '2025-09-23 10:18:05'),
(145, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:18:57', '2025-09-23 10:18:57'),
(146, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:19:25', '2025-09-23 10:19:25'),
(147, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:19:46', '2025-09-23 10:19:46'),
(148, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:20:05', '2025-09-23 10:20:05'),
(149, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:20:25', '2025-09-23 10:20:25'),
(150, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:20:48', '2025-09-23 10:20:48'),
(151, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:21:16', '2025-09-23 10:21:16'),
(152, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:21:33', '2025-09-23 10:21:33'),
(153, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:21:47', '2025-09-23 10:21:47'),
(154, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:21:59', '2025-09-23 10:21:59'),
(155, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:22:09', '2025-09-23 10:22:09'),
(156, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:22:44', '2025-09-23 10:22:44'),
(157, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:22:54', '2025-09-23 10:22:54'),
(158, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:23:31', '2025-09-23 10:23:31'),
(159, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:23:46', '2025-09-23 10:23:46'),
(160, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:24:06', '2025-09-23 10:24:06'),
(161, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:24:42', '2025-09-23 10:24:42'),
(162, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:24:49', '2025-09-23 10:24:49'),
(163, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:26:18', '2025-09-23 10:26:18'),
(164, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:26:30', '2025-09-23 10:26:30'),
(165, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:26:45', '2025-09-23 10:26:45'),
(166, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:28:00', '2025-09-23 10:28:00'),
(167, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:28:06', '2025-09-23 10:28:06'),
(168, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:28:18', '2025-09-23 10:28:18'),
(169, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:28:31', '2025-09-23 10:28:31'),
(170, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:28:48', '2025-09-23 10:28:48'),
(171, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:32:11', '2025-09-23 10:32:11'),
(172, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:32:17', '2025-09-23 10:32:17'),
(173, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:32:28', '2025-09-23 10:32:28'),
(174, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:32:42', '2025-09-23 10:32:42'),
(175, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:32:54', '2025-09-23 10:32:54'),
(176, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:36:07', '2025-09-23 10:36:07'),
(177, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:36:15', '2025-09-23 10:36:15'),
(178, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:36:37', '2025-09-23 10:36:37'),
(179, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:36:50', '2025-09-23 10:36:50'),
(180, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:37:05', '2025-09-23 10:37:05'),
(181, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:37:27', '2025-09-23 10:37:27'),
(182, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-23 10:37:51', '2025-09-23 10:37:51'),
(183, 3, 'Login', 'login', 'User', '127.0.0.1', 3, NULL, NULL, '2025-09-23 11:52:25', '2025-09-23 11:52:25'),
(184, 1, 'Logout', 'logout', 'User', '127.0.0.1', 1, NULL, NULL, '2025-09-23 12:40:54', '2025-09-23 12:40:54'),
(185, 3, 'Logout', 'logout', 'User', '127.0.0.1', 3, NULL, NULL, '2025-09-23 12:41:15', '2025-09-23 12:41:15'),
(186, 1, 'Login', 'login', 'User', '127.0.0.1', 1, NULL, NULL, '2025-09-24 09:54:54', '2025-09-24 09:54:54'),
(187, 3, 'Login', 'login', 'User', '127.0.0.1', 3, NULL, NULL, '2025-09-24 10:00:28', '2025-09-24 10:00:28'),
(188, 3, 'Logout', 'logout', 'User', '127.0.0.1', 3, NULL, NULL, '2025-09-24 11:01:07', '2025-09-24 11:01:07'),
(189, 2, 'Login', 'login', 'User', '127.0.0.1', 2, NULL, NULL, '2025-09-24 11:05:10', '2025-09-24 11:05:10'),
(190, 2, 'Logout', 'logout', 'User', '127.0.0.1', 2, NULL, NULL, '2025-09-24 12:45:37', '2025-09-24 12:45:37'),
(191, 1, 'Login', 'login', 'User', '127.0.0.1', 1, NULL, NULL, '2025-09-25 10:24:13', '2025-09-25 10:24:13'),
(192, 1, 'Module', 'save', 'Module', '127.0.0.1', 1, NULL, NULL, '2025-09-25 12:15:40', '2025-09-25 12:15:40'),
(193, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-25 12:16:37', '2025-09-25 12:16:37'),
(194, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-25 12:17:06', '2025-09-25 12:17:06'),
(195, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-25 12:18:20', '2025-09-25 12:18:20'),
(196, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-25 12:18:34', '2025-09-25 12:18:34'),
(197, 1, 'Login', 'login', 'User', '127.0.0.1', 1, NULL, NULL, '2025-09-26 09:04:25', '2025-09-26 09:04:25'),
(198, 3, 'Login', 'login', 'User', '127.0.0.1', 3, NULL, NULL, '2025-09-26 10:51:02', '2025-09-26 10:51:02'),
(199, 3, 'Logout', 'logout', 'User', '127.0.0.1', 3, NULL, NULL, '2025-09-26 11:21:16', '2025-09-26 11:21:16'),
(200, 2, 'Login', 'login', 'User', '127.0.0.1', 2, NULL, NULL, '2025-09-26 11:21:44', '2025-09-26 11:21:44'),
(201, 2, 'Logout', 'logout', 'User', '127.0.0.1', 2, NULL, NULL, '2025-09-26 11:25:05', '2025-09-26 11:25:05'),
(202, 3, 'Login', 'login', 'User', '127.0.0.1', 3, NULL, NULL, '2025-09-26 11:26:29', '2025-09-26 11:26:29'),
(203, 3, 'Logout', 'logout', 'User', '127.0.0.1', 3, NULL, NULL, '2025-09-26 11:27:36', '2025-09-26 11:27:36'),
(204, 3, 'Login', 'login', 'User', '127.0.0.1', 3, NULL, NULL, '2025-09-27 10:36:54', '2025-09-27 10:36:54'),
(205, 1, 'Login', 'login', 'User', '127.0.0.1', 1, NULL, NULL, '2025-09-27 12:13:28', '2025-09-27 12:13:28'),
(206, 1, 'Login', 'login', 'User', '127.0.0.1', 1, NULL, NULL, '2025-09-28 02:10:40', '2025-09-28 02:10:40'),
(207, 1, 'Module', 'save', 'Module', '127.0.0.1', 1, NULL, NULL, '2025-09-28 05:35:51', '2025-09-28 05:35:51'),
(208, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-28 05:36:39', '2025-09-28 05:36:39'),
(209, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-28 05:36:52', '2025-09-28 05:36:52'),
(210, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-28 05:37:40', '2025-09-28 05:37:40'),
(211, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-28 05:37:50', '2025-09-28 05:37:50'),
(212, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-28 05:38:18', '2025-09-28 05:38:18'),
(213, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-28 05:38:50', '2025-09-28 05:38:50'),
(214, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-28 05:40:18', '2025-09-28 05:40:18'),
(215, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-28 05:40:25', '2025-09-28 05:40:25'),
(216, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-28 05:40:40', '2025-09-28 05:40:40'),
(217, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-28 05:40:56', '2025-09-28 05:40:56'),
(218, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-28 05:42:02', '2025-09-28 05:42:02'),
(219, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-28 05:42:08', '2025-09-28 05:42:08'),
(220, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-28 05:42:24', '2025-09-28 05:42:24'),
(221, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-28 05:42:35', '2025-09-28 05:42:35'),
(222, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-09-28 05:42:51', '2025-09-28 05:42:51'),
(223, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-09-28 05:43:03', '2025-09-28 05:43:03'),
(224, 1, 'Holiday', 'save', 'Holiday', '127.0.0.1', 1, NULL, NULL, '2025-09-28 08:25:01', '2025-09-28 08:25:01'),
(225, 1, 'Login', 'login', 'User', '127.0.0.1', 1, NULL, NULL, '2025-09-29 08:07:20', '2025-09-29 08:07:20'),
(226, 1, 'Login', 'login', 'User', '127.0.0.1', 1, NULL, NULL, '2025-10-01 08:52:27', '2025-10-01 08:52:27'),
(227, 1, 'Holiday', 'save', 'Holiday', '127.0.0.1', 1, NULL, NULL, '2025-10-01 14:04:25', '2025-10-01 14:04:25'),
(228, 1, 'Holiday', 'save', 'Holiday', '127.0.0.1', 1, NULL, NULL, '2025-10-01 14:06:23', '2025-10-01 14:06:23'),
(229, 1, 'Holiday', 'save', 'Holiday', '127.0.0.1', 1, NULL, NULL, '2025-10-01 14:07:57', '2025-10-01 14:07:57'),
(230, 1, 'Holiday', 'save', 'Holiday', '127.0.0.1', 1, NULL, NULL, '2025-10-01 14:10:04', '2025-10-01 14:10:04'),
(231, 1, 'Holiday', 'save', 'Holiday', '127.0.0.1', 1, NULL, NULL, '2025-10-01 15:07:33', '2025-10-01 15:07:33'),
(232, 1, 'Holiday', 'save', 'Holiday', '127.0.0.1', 1, NULL, NULL, '2025-10-01 15:08:43', '2025-10-01 15:08:43'),
(233, 1, 'Holiday', 'save', 'Holiday', '127.0.0.1', 1, NULL, NULL, '2025-10-01 15:12:47', '2025-10-01 15:12:47'),
(234, 1, 'Holiday', 'save', 'Holiday', '127.0.0.1', 1, NULL, NULL, '2025-10-01 15:13:56', '2025-10-01 15:13:56'),
(235, 1, 'Logout', 'logout', 'User', '127.0.0.1', 1, NULL, NULL, '2025-10-01 15:19:05', '2025-10-01 15:19:05'),
(236, 1, 'Login', 'login', 'User', '127.0.0.1', 1, NULL, NULL, '2025-10-02 00:55:08', '2025-10-02 00:55:08'),
(237, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-10-02 01:59:24', '2025-10-02 01:59:24'),
(238, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-10-02 01:59:33', '2025-10-02 01:59:33'),
(239, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-10-02 02:02:34', '2025-10-02 02:02:34'),
(240, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-10-02 02:03:06', '2025-10-02 02:03:06'),
(241, 1, 'Logout', 'logout', 'User', '127.0.0.1', 1, NULL, NULL, '2025-10-02 05:22:11', '2025-10-02 05:22:11'),
(242, 1, 'Login', 'login', 'User', '127.0.0.1', 1, NULL, NULL, '2025-10-02 10:21:01', '2025-10-02 10:21:01'),
(243, 1, 'Logout', 'logout', 'User', '127.0.0.1', 1, NULL, NULL, '2025-10-02 13:28:11', '2025-10-02 13:28:11'),
(244, 1, 'Login', 'login', 'User', '127.0.0.1', 1, NULL, NULL, '2025-10-03 08:11:06', '2025-10-03 08:11:06'),
(245, 1, 'Login', 'login', 'User', '127.0.0.1', 1, NULL, NULL, '2025-10-03 11:55:55', '2025-10-03 11:55:55'),
(246, 1, 'Login', 'login', 'User', '127.0.0.1', 1, NULL, NULL, '2025-10-04 23:06:07', '2025-10-04 23:06:07'),
(247, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-10-05 03:58:23', '2025-10-05 03:58:23'),
(248, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-10-05 03:58:30', '2025-10-05 03:58:30'),
(249, 1, 'Permission', 'save', 'Permission', '127.0.0.1', 1, NULL, NULL, '2025-10-05 03:59:05', '2025-10-05 03:59:05'),
(250, 1, 'Role', 'update', 'Role', '127.0.0.1', 1, NULL, NULL, '2025-10-05 03:59:12', '2025-10-05 03:59:12'),
(251, 1, 'Logout', 'logout', 'User', '127.0.0.1', 1, NULL, NULL, '2025-10-05 09:06:49', '2025-10-05 09:06:49'),
(252, 1, 'Login', 'login', 'User', '127.0.0.1', 1, NULL, NULL, '2025-10-07 09:29:31', '2025-10-07 09:29:31'),
(253, 1, 'Logout', 'logout', 'User', '127.0.0.1', 1, NULL, NULL, '2025-10-07 09:39:16', '2025-10-07 09:39:16'),
(254, 1, 'Login', 'login', 'User', '127.0.0.1', 1, NULL, NULL, '2025-10-10 09:36:17', '2025-10-10 09:36:17');

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL COMMENT 'data getting from users table',
  `client_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meeting_time` int NOT NULL,
  `distance_time` int NOT NULL,
  `distance_in_km` int DEFAULT NULL COMMENT 'distance in kilometer',
  `duration_in_minutes` int DEFAULT NULL COMMENT 'distance coverd in total minutes',
  `meeting_date` date NOT NULL COMMENT 'which date meeting schedule',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meetings`
--

INSERT INTO `meetings` (`id`, `user_id`, `client_name`, `location`, `latitude`, `longitude`, `meeting_time`, `distance_time`, `distance_in_km`, `duration_in_minutes`, `meeting_date`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Akshay', 'Luck', '0', '0', 6, 0, 0, 0, '2025-09-26', NULL, '2025-09-26 13:23:32', '2025-09-26 13:23:32');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_07_04_172723_create_departments_table', 1),
(6, '2025_07_05_060511_create_designations_table', 1),
(7, '2025_07_05_094203_create_role_permission_table', 1),
(8, '2025_07_05_094227_create_route_permission_table', 1),
(9, '2025_07_05_094429_create_roles_table', 1),
(10, '2025_07_05_094438_create_permissions_table', 1),
(11, '2025_07_05_100329_create_logs_table', 1),
(12, '2025_07_05_193757_create_login_otp_table', 2),
(13, '2025_09_20_070915_create_modules_table', 3),
(14, '2025_08_24_073728_create_customers_table', 4),
(15, '2025_09_25_165708_create_meetings_table', 5),
(18, '2025_10_02_061857_create_firms_table', 7),
(19, '2025_10_02_092641_create_customer_branches_table', 8),
(20, '2025_10_02_173102_create_excel_error_reports_table', 9),
(22, '2025_10_02_180819_create_dump_holidays_table', 10),
(23, '2025_09_28_103611_create_holidays_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1=active, 0=inactive',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `slug`, `description`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'dashboard', 'dashboard', NULL, 1, NULL, '2025-09-20 05:36:25', NULL),
(2, 'department', 'department', NULL, 1, NULL, '2025-09-20 05:36:47', NULL),
(3, 'designation', 'designation', NULL, 1, NULL, '2025-09-20 05:37:21', NULL),
(4, 'role', 'role', NULL, 1, NULL, '2025-09-20 05:38:02', NULL),
(5, 'module', 'module', NULL, 1, NULL, '2025-09-20 06:03:11', NULL),
(6, 'permission', 'permission', NULL, 1, NULL, '2025-09-20 06:03:37', NULL),
(7, 'user', 'user', NULL, 1, NULL, '2025-09-20 06:16:54', NULL),
(8, 'role-permission-mapping', 'role_permission_mapping', NULL, 1, NULL, '2025-09-20 06:29:11', NULL),
(9, 'route-permission-mapping', 'route_permission_mapping', NULL, 1, NULL, '2025-09-20 06:29:41', NULL),
(10, 'meeting', 'meeting', NULL, 1, NULL, '2025-09-25 12:15:40', NULL),
(11, 'holiday', 'holiday', NULL, 1, NULL, '2025-09-28 05:35:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `module_id` int NOT NULL,
  `module_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_url_slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint DEFAULT '1' COMMENT '1=active permission, 0=inactive permission',
  `created_by` tinyint DEFAULT NULL,
  `updated_by` tinyint DEFAULT NULL,
  `deleted_by` tinyint DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `module_id`, `module_name`, `name`, `slug`, `app_url_slug`, `app_url`, `description`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'dashboard', 'Dashboard', 'dashboard', 'admin.dashboard', 'admin.dashboard', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:37:24', '2025-09-23 10:37:51'),
(2, 2, 'department', 'Department', 'department', 'admin.department.index', 'admin.department.index', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:37:39', '2025-09-23 10:36:15'),
(3, 2, 'department', 'Add Department', 'add_department', 'admin.department.save', 'admin.department.save', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:38:03', '2025-09-23 10:36:37'),
(4, 2, 'department', 'Edit Department', 'edit_department', 'admin.department.update', 'admin.department.update', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:38:21', '2025-09-23 10:36:50'),
(5, 2, 'department', 'Delete Department', 'delete_department', 'admin.department.delete', 'admin.department.delete', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:38:33', '2025-09-23 10:37:05'),
(6, 2, 'department', 'List Department', 'list_department', 'admin.department.index', 'admin.department.index', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:38:52', '2025-09-23 10:36:07'),
(7, 2, 'department', 'Show Department', 'show_department', 'admin.department.show', 'admin.department.show', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:39:04', '2025-09-23 10:37:27'),
(8, 3, 'designation', 'Designation', 'designation', 'admin.designation.index', 'admin.designation.index', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:39:25', '2025-09-23 10:32:17'),
(9, 3, 'designation', 'Add Designation', 'add_designation', 'admin.designation.save', 'admin.designation.save', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:39:35', '2025-09-23 10:32:28'),
(10, 3, 'designation', 'Edit Designation', 'edit_designation', 'admin.designation.update', 'admin.designation.update', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:39:48', '2025-09-23 10:32:42'),
(11, 3, 'designation', 'Delete Designation', 'delete_designation', 'admin.designation.delete', 'admin.designation.delete', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:39:58', '2025-09-23 10:32:54'),
(12, 3, 'designation', 'List Designation', 'list_designation', 'admin.designation.index', 'admin.designation.index', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:40:08', '2025-09-23 10:32:11'),
(13, 4, 'role', 'Role', 'role', 'admin.role.index', 'admin.role.index', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:40:19', '2025-09-23 10:28:06'),
(14, 4, 'role', 'Add Role', 'add_role', 'admin.role.save', 'admin.role.save', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:40:36', '2025-09-23 10:28:18'),
(15, 4, 'role', 'Edit Role', 'edit_role', 'admin.role.update', 'admin.role.update', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:40:46', '2025-09-23 10:28:31'),
(16, 4, 'role', 'Delete Role', 'delete_role', 'admin.role.delete', 'admin.role.delete', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:40:59', '2025-09-23 10:28:48'),
(17, 4, 'role', 'List Role', 'list_role', 'admin.role.index', 'admin.role.index', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:41:08', '2025-09-23 10:28:00'),
(18, 5, 'module', 'Module', 'module', 'admin.modules.index', 'admin.modules.index', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:41:20', '2025-09-23 10:24:48'),
(19, 5, 'module', 'Add Module', 'add_module', 'admin.modules.save', 'admin.modules.save', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:41:31', '2025-09-23 10:26:45'),
(20, 5, 'module', 'Edit Module', 'edit_module', 'admin.modules.update', 'admin.modules.update', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:41:42', '2025-09-23 10:26:30'),
(21, 5, 'module', 'Delete Module', 'delete_module', 'admin.modules.delete', 'admin.modules.delete', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:42:02', '2025-09-23 10:26:18'),
(22, 5, 'module', 'List Module', 'list_module', 'admin.modules.index', 'admin.modules.index', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:42:16', '2025-09-23 10:24:42'),
(23, 6, 'permission', 'Permission', 'permission', 'admin.permission.index', 'admin.permission.index', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:42:30', '2025-09-23 10:22:54'),
(24, 6, 'permission', 'Add Permission', 'add_permission', 'admin.permission.save', 'admin.permission.save', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:42:40', '2025-09-23 10:24:06'),
(25, 6, 'permission', 'Edi Permission', 'edi_permission', 'admin.permission.update', 'admin.permission.update', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:42:49', '2025-09-23 10:23:46'),
(26, 6, 'permission', 'Delete Permission', 'delete_permission', 'admin.permission.delete', 'admin.permission.delete', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:43:02', '2025-09-23 10:23:31'),
(27, 6, 'permission', 'List Permission', 'list_permission', 'admin.permission.index', 'admin.permission.index', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:43:11', '2025-09-23 10:22:44'),
(28, 7, 'user', 'User', 'user', 'admin.user', 'admin.user', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:43:22', '2025-09-23 10:22:09'),
(29, 7, 'user', 'Add User', 'add_user', 'admin.user.create', 'admin.user.create', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:43:37', '2025-09-23 10:21:33'),
(30, 7, 'user', 'Edit User', 'edit_user', 'admin.user.update', 'admin.user.update', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:43:50', '2025-09-23 10:21:47'),
(31, 7, 'user', 'Delete User', 'delete_user', 'admin.user.delete', 'admin.user.delete', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:44:02', '2025-09-23 10:21:59'),
(32, 7, 'user', 'List User', 'list_user', 'admin.user', 'admin.user', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:44:13', '2025-09-23 10:21:16'),
(33, 8, 'role-permission-mapping', 'Role Permission', 'role_permission', 'admin.role-permission-mapping.index', 'admin.role-permission-mapping.index', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:44:37', '2025-09-23 10:20:48'),
(34, 8, 'role-permission-mapping', 'Add Role Permission', 'add_role_permission', 'admin.role-permission-mapping.save', 'admin.role-permission-mapping.save', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:44:45', '2025-09-23 10:20:25'),
(35, 8, 'role-permission-mapping', 'Edit Role Permission', 'edit_role_permission', 'admin.role-permission-mapping.update', 'admin.role-permission-mapping.update', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:44:56', '2025-09-23 10:20:05'),
(36, 8, 'role-permission-mapping', 'Delete Role Permission', 'delete_role_permission', 'admin.role-permission-mapping.delete', 'admin.role-permission-mapping.delete', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:45:06', '2025-09-23 10:19:46'),
(37, 8, 'role-permission-mapping', 'List Role Permission', 'list_role_permission', 'admin.role-permission-mapping.index', 'admin.role-permission-mapping.index', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:45:15', '2025-09-23 10:19:25'),
(38, 9, 'route-permission-mapping', 'Route Permission', 'route_permission', 'admin.route-permission-mapping.index', 'admin.route-permission-mapping.index', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:45:33', '2025-09-23 10:18:57'),
(39, 9, 'route-permission-mapping', 'Add Route Permission', 'add_route_permission', 'admin.route-permission-mapping.save', 'admin.route-permission-mapping.save', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:45:43', '2025-09-23 10:17:08'),
(40, 9, 'route-permission-mapping', 'Edit Route Permission', 'edit_route_permission', 'admin.route-permission-mapping.update', 'admin.route-permission-mapping.update', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:45:51', '2025-09-23 10:16:31'),
(41, 9, 'route-permission-mapping', 'Delete Route Permission', 'delete_route_permission', 'admin.route-permission-mapping.delete', 'admin.route-permission-mapping.delete', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:46:03', '2025-09-23 10:16:15'),
(42, 9, 'route-permission-mapping', 'List Route Permission', 'list_route_permission', 'admin.route-permission-mapping.index', 'admin.route-permission-mapping.index', NULL, 1, 1, 1, NULL, NULL, '2025-09-21 05:46:16', '2025-09-23 10:15:07'),
(43, 10, 'meeting', 'Meeting', 'meeting', 'admin.meeting.index', 'admin.meeting.index', NULL, 1, 1, 1, NULL, NULL, '2025-09-25 12:16:37', '2025-09-25 12:18:20'),
(44, 10, 'meeting', 'Add Meeting', 'add_meeting', 'admin.meeting.save', 'admin.meeting.save', NULL, 1, 1, 1, NULL, NULL, '2025-09-25 12:17:06', '2025-09-25 12:18:34'),
(45, 11, 'holiday', 'List Holiday', 'list_holiday', 'admin.holiday.index', 'admin.holiday.index', NULL, 1, 1, 1, NULL, NULL, '2025-09-28 05:36:39', '2025-09-28 05:36:51'),
(46, 11, 'holiday', 'Add Holiday', 'add_holiday', 'admin.holiday.save', 'admin.holiday.save', NULL, 1, 1, 1, NULL, NULL, '2025-09-28 05:37:40', '2025-09-28 05:37:50'),
(47, 11, 'holiday', 'Edit Holiday', 'edit_holiday', 'admin.holiday.update', 'admin.holiday.update', NULL, 1, 1, 1, NULL, NULL, '2025-09-28 05:38:18', '2025-09-28 05:38:50'),
(48, 11, 'holiday', 'Delete Holiday', 'delete_holiday', 'admin.holiday.delete', 'admin.holiday.delete', NULL, 1, 1, 1, NULL, NULL, '2025-09-28 05:40:18', '2025-09-28 05:40:25'),
(49, 11, 'holiday', 'Show Holiday', 'show_holiday', 'admin.holiday.show', 'admin.holiday.show', NULL, 1, 1, 1, NULL, NULL, '2025-09-28 05:40:40', '2025-09-28 05:40:56'),
(50, 10, 'meeting', 'Edit Meeting', 'edit_meeting', 'admin.meeting.update', 'admin.meeting.update', NULL, 1, 1, 1, NULL, NULL, '2025-09-28 05:42:02', '2025-09-28 05:42:08'),
(51, 10, 'meeting', 'Delete Meeing', 'delete_meeing', 'admin.meeting.delete', 'admin.meeting.delete', NULL, 1, 1, 1, NULL, NULL, '2025-09-28 05:42:24', '2025-09-28 05:42:35'),
(52, 10, 'meeting', 'Show Meeting', 'show_meeting', 'admin.meeting.show', 'admin.meeting.show', NULL, 1, 1, 1, NULL, NULL, '2025-09-28 05:42:51', '2025-09-28 05:43:03'),
(53, 11, 'holiday', 'Excel Download', 'excel_download', 'admin.holiday.excel_generate', 'admin.holiday.excel_generate', NULL, 1, 1, 1, NULL, NULL, '2025-10-02 01:59:24', '2025-10-02 02:03:06'),
(54, 11, 'holiday', 'Fetch Year Wise Holiday', 'fetch_year_wise_holiday', 'admin.dashboard.holiday_year', 'admin.dashboard.holiday_year', NULL, 1, 1, 1, NULL, NULL, '2025-10-05 03:58:23', '2025-10-05 03:58:30'),
(55, 11, 'holiday', 'Fetch Id Wise Holiday', 'fetch_id_wise_holiday', 'admin.dashboard.holiday_id', 'admin.dashboard.holiday_id', NULL, 1, 1, 1, NULL, NULL, '2025-10-05 03:59:05', '2025-10-05 03:59:12');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint DEFAULT '1' COMMENT '1=active role, 0=inactive role',
  `created_by` tinyint DEFAULT NULL,
  `updated_by` tinyint DEFAULT NULL,
  `deleted_by` tinyint DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'super_admin', 'Access all website functionality', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Admin', 'admin', NULL, 1, 1, 1, NULL, NULL, '2025-08-27 02:57:38', '2025-09-20 00:37:19'),
(3, 'User', 'user', NULL, 1, 1, NULL, NULL, NULL, '2025-08-27 02:57:50', NULL),
(4, 'CTO', 'cto', NULL, 1, 1, NULL, NULL, NULL, '2025-08-27 06:02:38', NULL),
(5, 'IT Development', 'it_development', NULL, 1, 1, NULL, NULL, NULL, '2025-08-27 06:05:34', NULL),
(6, 'Marketing', 'marketing', NULL, 1, 1, NULL, NULL, NULL, '2025-08-27 06:06:15', NULL),
(7, 'Sales', 'sales', NULL, 1, 1, NULL, NULL, NULL, '2025-09-20 00:37:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

CREATE TABLE `role_permission` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permission_name` longtext COLLATE utf8mb4_unicode_ci,
  `route_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint DEFAULT '1' COMMENT '1=active role, 0=inactive role',
  `created_by` tinyint DEFAULT NULL,
  `updated_by` tinyint DEFAULT NULL,
  `deleted_by` tinyint DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_permission`
--

INSERT INTO `role_permission` (`id`, `role_id`, `permission_id`, `role_name`, `permission_name`, `route_url`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '3', '1', 'User', 'Dashboard', 'admin.dashboard', 1, 1, NULL, NULL, NULL, '2025-09-24 09:57:12', '2025-09-24 09:57:12'),
(2, '3', '2', 'User', 'Department', 'admin.department.index', 1, 1, NULL, NULL, NULL, '2025-09-24 09:57:12', '2025-09-24 09:57:12'),
(3, '3', '6', 'User', 'List Department', 'admin.department.index', 1, 1, NULL, NULL, NULL, '2025-09-24 09:57:12', '2025-09-24 09:57:12'),
(4, '3', '7', 'User', 'Show Department', 'admin.department.show', 1, 1, NULL, NULL, NULL, '2025-09-24 09:57:12', '2025-09-24 09:57:12'),
(5, '3', '28', 'User', 'User', 'admin.user', 1, 1, NULL, NULL, NULL, '2025-09-24 09:57:12', '2025-09-24 09:57:12'),
(7, '3', '30', 'User', 'Edit User', 'admin.user.update', 1, 1, NULL, NULL, NULL, '2025-09-24 09:57:12', '2025-09-24 09:57:12'),
(8, '3', '31', 'User', 'Delete User', 'admin.user.delete', 1, 1, NULL, NULL, NULL, '2025-09-24 09:57:12', '2025-09-24 09:57:12'),
(9, '3', '37', 'User', 'List Role Permission', 'admin.role-permission-mapping.index', 1, 1, NULL, NULL, NULL, '2025-09-24 09:57:12', '2025-09-24 09:57:12'),
(10, '2', '1', 'Admin', 'Dashboard', 'admin.dashboard', 1, 1, NULL, NULL, NULL, '2025-09-24 10:59:38', '2025-09-24 10:59:38'),
(11, '2', '2', 'Admin', 'Department', 'admin.department.index', 1, 1, NULL, NULL, NULL, '2025-09-24 10:59:38', '2025-09-24 10:59:38'),
(12, '2', '3', 'Admin', 'Add Department', 'admin.department.save', 1, 1, NULL, NULL, NULL, '2025-09-24 10:59:38', '2025-09-24 10:59:38'),
(13, '2', '4', 'Admin', 'Edit Department', 'admin.department.update', 1, 1, NULL, NULL, NULL, '2025-09-24 10:59:38', '2025-09-24 10:59:38'),
(14, '2', '5', 'Admin', 'Delete Department', 'admin.department.delete', 1, 1, NULL, NULL, NULL, '2025-09-24 10:59:38', '2025-09-24 10:59:38'),
(15, '2', '6', 'Admin', 'List Department', 'admin.department.index', 1, 1, NULL, NULL, NULL, '2025-09-24 10:59:38', '2025-09-24 10:59:38'),
(16, '2', '7', 'Admin', 'Show Department', 'admin.department.show', 1, 1, NULL, NULL, NULL, '2025-09-24 10:59:38', '2025-09-24 10:59:38'),
(17, '2', '8', 'Admin', 'Designation', 'admin.designation.index', 1, 1, NULL, NULL, NULL, '2025-09-24 10:59:38', '2025-09-24 10:59:38'),
(18, '2', '9', 'Admin', 'Add Designation', 'admin.designation.save', 1, 1, NULL, NULL, NULL, '2025-09-24 10:59:38', '2025-09-24 10:59:38'),
(19, '2', '10', 'Admin', 'Edit Designation', 'admin.designation.update', 1, 1, NULL, NULL, NULL, '2025-09-24 10:59:38', '2025-09-24 10:59:38'),
(20, '2', '11', 'Admin', 'Delete Designation', 'admin.designation.delete', 1, 1, NULL, NULL, NULL, '2025-09-24 10:59:38', '2025-09-24 10:59:38'),
(21, '2', '12', 'Admin', 'List Designation', 'admin.designation.index', 1, 1, NULL, NULL, NULL, '2025-09-24 10:59:38', '2025-09-24 10:59:38'),
(22, '2', '13', 'Admin', 'Role', 'admin.role.index', 1, 1, NULL, NULL, NULL, '2025-09-24 10:59:38', '2025-09-24 10:59:38'),
(23, '2', '14', 'Admin', 'Add Role', 'admin.role.save', 1, 1, NULL, NULL, NULL, '2025-09-24 10:59:38', '2025-09-24 10:59:38'),
(24, '2', '17', 'Admin', 'List Role', 'admin.role.index', 1, 1, NULL, NULL, NULL, '2025-09-24 10:59:38', '2025-09-24 10:59:38'),
(25, '2', '18', 'Admin', 'Module', 'admin.modules.index', 1, 1, NULL, NULL, NULL, '2025-09-24 10:59:38', '2025-09-24 10:59:38'),
(26, '2', '19', 'Admin', 'Add Module', 'admin.modules.save', 1, 1, NULL, NULL, NULL, '2025-09-24 10:59:38', '2025-09-24 10:59:38'),
(27, '2', '22', 'Admin', 'List Module', 'admin.modules.index', 1, 1, NULL, NULL, NULL, '2025-09-24 10:59:38', '2025-09-24 10:59:38'),
(28, '2', '23', 'Admin', 'Permission', 'admin.permission.index', 1, 1, NULL, NULL, NULL, '2025-09-24 10:59:38', '2025-09-24 10:59:38'),
(29, '2', '24', 'Admin', 'Add Permission', 'admin.permission.save', 1, 1, NULL, NULL, NULL, '2025-09-24 10:59:38', '2025-09-24 10:59:38'),
(30, '2', '27', 'Admin', 'List Permission', 'admin.permission.index', 1, 1, NULL, NULL, NULL, '2025-09-24 10:59:38', '2025-09-24 10:59:38'),
(31, '2', '28', 'Admin', 'User', 'admin.user', 1, 1, NULL, NULL, NULL, '2025-09-24 10:59:38', '2025-09-24 10:59:38'),
(32, '2', '29', 'Admin', 'Add User', 'admin.user.create', 1, 1, NULL, NULL, NULL, '2025-09-24 10:59:38', '2025-09-24 10:59:38'),
(33, '2', '30', 'Admin', 'Edit User', 'admin.user.update', 1, 1, NULL, NULL, NULL, '2025-09-24 10:59:38', '2025-09-24 10:59:38'),
(34, '2', '31', 'Admin', 'Delete User', 'admin.user.delete', 1, 1, NULL, NULL, NULL, '2025-09-24 10:59:38', '2025-09-24 10:59:38'),
(35, '2', '32', 'Admin', 'List User', 'admin.user', 1, 1, NULL, NULL, NULL, '2025-09-24 10:59:38', '2025-09-24 10:59:38');

-- --------------------------------------------------------

--
-- Table structure for table `route_permission`
--

CREATE TABLE `route_permission` (
  `id` bigint UNSIGNED NOT NULL,
  `route_name` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission_id` int NOT NULL,
  `status` tinyint DEFAULT '1' COMMENT '1=active role, 0=inactive role',
  `created_by` tinyint DEFAULT NULL,
  `updated_by` tinyint DEFAULT NULL,
  `deleted_by` tinyint DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` int DEFAULT NULL,
  `customer_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_id` int DEFAULT NULL COMMENT 'Department ID the user belongs to',
  `designation_id` int DEFAULT NULL COMMENT 'Designation ID the user holds',
  `role_id` int DEFAULT NULL COMMENT 'Role ID assigned to the user',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Unique username for the user',
  `profile_picture` longtext COLLATE utf8mb4_unicode_ci COMMENT 'URL of the user profile picture',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'User phone number',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'User address',
  `email_verified_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Timestamp when the email was verified',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1=active, 2=archived, 0=inactive',
  `created_by` int DEFAULT NULL COMMENT 'User ID of the creator',
  `updated_by` int DEFAULT NULL COMMENT 'User ID of the last updater',
  `api_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'API token for the user, used for authentication in API requests',
  `api_token_expiry` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Expiry date and time of the API token',
  `is_otp_verified` tinyint DEFAULT '0' COMMENT '0=not verify, 1=verified, 2=pending verification',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Timestamp when the user was deleted, if applicable',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Token for remembering the user session',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'IP address of the last login',
  `login_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '1' COMMENT '1=user is currently logged in, 2=user is currently logout, 0=user is currently inactive',
  `last_login_at` timestamp NULL DEFAULT NULL COMMENT 'Timestamp of the last login',
  `last_login_browser` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Browser used during the last login',
  `last_login_device` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Device used during the last login',
  `last_login_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Location of the last login',
  `last_login_country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Country of the last login',
  `last_login_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'City of the last login',
  `last_login_region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Region of the last login',
  `last_login_postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Postal code of the last login',
  `last_login_latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Latitude of the last login location',
  `last_login_longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Longitude of the last login location',
  `last_login_timezone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Timezone of the last login',
  `last_login_device_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Type of device used during the last login (e.g., desktop, mobile, tablet)',
  `last_login_os` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Operating system used during the last login',
  `last_login_os_version` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Version of the operating system used during the last login',
  `last_login_browser_version` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Version of the browser used during the last login',
  `deleted_by` int DEFAULT NULL COMMENT 'User ID of the person who deleted the user, if applicable',
  `deleted_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Reason for deletion, if applicable'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `customer_id`, `customer_code`, `branch_id`, `department_id`, `designation_id`, `role_id`, `name`, `username`, `profile_picture`, `phone`, `address`, `email_verified_at`, `email`, `password`, `date_of_birth`, `gender`, `default_password`, `status`, `created_by`, `updated_by`, `api_token`, `api_token_expiry`, `is_otp_verified`, `deleted_at`, `remember_token`, `created_at`, `updated_at`, `last_login_ip`, `login_status`, `last_login_at`, `last_login_browser`, `last_login_device`, `last_login_location`, `last_login_country`, `last_login_city`, `last_login_region`, `last_login_postal_code`, `last_login_latitude`, `last_login_longitude`, `last_login_timezone`, `last_login_device_type`, `last_login_os`, `last_login_os_version`, `last_login_browser_version`, `deleted_by`, `deleted_reason`) VALUES
(1, NULL, NULL, NULL, 1, 1, 1, 'Abhishek', 'abhishekkumar007', NULL, '9415058209', 'New Delhi', NULL, 'super.admin@gmail.com', '$2y$10$PEltPNDcCGrqglobD1uZyuGr8GWF.1hudDixEPGE.KlIxVmkcAk8e', NULL, NULL, 'admin', 1, 1, NULL, '8cdfb2d6d03c3797908a99ce42a1d664', NULL, 1, NULL, NULL, '2025-07-05 13:02:15', '2025-10-10 09:36:17', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, NULL, NULL, NULL, 1, 1, 2, 'Sakina', 'sakinabano', NULL, '8400046404', 'Kapoorthala', NULL, 'annaaryan93@gmail.com', '$2y$10$PEltPNDcCGrqglobD1uZyuGr8GWF.1hudDixEPGE.KlIxVmkcAk8e', '2025-08-05', NULL, 'admin', 1, 1, NULL, NULL, NULL, 0, NULL, NULL, '2025-08-05 08:41:54', '2025-09-26 11:25:05', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, NULL, NULL, NULL, NULL, NULL, 3, 'Fatima Ahmed', 'fatimakhan', NULL, '9415058274', 'Kapoorthala', NULL, 'fatima93@gmail.com', '$2y$10$PEltPNDcCGrqglobD1uZyuGr8GWF.1hudDixEPGE.KlIxVmkcAk8e', '2025-08-14', NULL, 'admin', 1, 2, NULL, '8d5605e205cb200d8ccf8899c03360e0', NULL, 0, NULL, NULL, '2025-08-24 08:03:40', '2025-09-27 10:36:53', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_branches`
--
ALTER TABLE `customer_branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_slug_unique` (`slug`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `dump_holidays`
--
ALTER TABLE `dump_holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `excel_error_reports`
--
ALTER TABLE `excel_error_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `firms`
--
ALTER TABLE `firms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_otp`
--
ALTER TABLE `login_otp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `modules_name_unique` (`name`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `route_permission`
--
ALTER TABLE `route_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_branches`
--
ALTER TABLE `customer_branches`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dump_holidays`
--
ALTER TABLE `dump_holidays`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `excel_error_reports`
--
ALTER TABLE `excel_error_reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `firms`
--
ALTER TABLE `firms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `login_otp`
--
ALTER TABLE `login_otp`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `role_permission`
--
ALTER TABLE `role_permission`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `route_permission`
--
ALTER TABLE `route_permission`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
