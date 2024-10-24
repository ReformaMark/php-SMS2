-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 24, 2024 at 11:14 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sms-mis`
--

-- --------------------------------------------------------

--
-- Table structure for table `academiccalendar`
--

DROP TABLE IF EXISTS `academiccalendar`;
CREATE TABLE IF NOT EXISTS `academiccalendar` (
  `event_id` int NOT NULL AUTO_INCREMENT,
  `event_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `attendance_id` int NOT NULL AUTO_INCREMENT,
  `class_id` int NOT NULL,
  `student_id` int NOT NULL,
  `date` date NOT NULL,
  `status` enum('Present','Absent','Late') COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`attendance_id`),
  KEY `class_id` (`class_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
CREATE TABLE IF NOT EXISTS `classes` (
  `class_id` int NOT NULL AUTO_INCREMENT,
  `course_id` int NOT NULL,
  `faculty_id` int DEFAULT NULL,
  `semester` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `current_year` year NOT NULL,
  `schedule` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `room` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`class_id`),
  KEY `course_id` (`course_id`),
  KEY `faculty_id` (`faculty_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `course_id` int NOT NULL AUTO_INCREMENT,
  `course_code` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `course_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `department_id` int DEFAULT NULL,
  `credits` int NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`course_id`),
  UNIQUE KEY `course_code` (`course_code`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `department_id` int NOT NULL AUTO_INCREMENT,
  `department_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `department_head` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

DROP TABLE IF EXISTS `enrollments`;
CREATE TABLE IF NOT EXISTS `enrollments` (
  `enrollment_id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `course_id` int NOT NULL,
  `semester` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `current_year` year NOT NULL,
  `grade` decimal(3,2) DEFAULT NULL,
  `current_status` enum('Enrolled','Completed','Dropped') COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`enrollment_id`),
  KEY `student_id` (`student_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

DROP TABLE IF EXISTS `faculty`;
CREATE TABLE IF NOT EXISTS `faculty` (
  `faculty_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone_number` varchar(11) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  PRIMARY KEY (`faculty_id`),
  UNIQUE KEY `email` (`email`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `financialtransactions`
--

DROP TABLE IF EXISTS `financialtransactions`;
CREATE TABLE IF NOT EXISTS `financialtransactions` (
  `transaction_id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_type` enum('Payment','Charge','Refund') COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

DROP TABLE IF EXISTS `grades`;
CREATE TABLE IF NOT EXISTS `grades` (
  `grade_id` int NOT NULL AUTO_INCREMENT,
  `enrollment_id` int NOT NULL,
  `grade_type` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `grade_value` decimal(5,2) NOT NULL,
  `date_recorded` datetime NOT NULL,
  PRIMARY KEY (`grade_id`),
  KEY `enrollment_id` (`enrollment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
CREATE TABLE IF NOT EXISTS `reports` (
  `report_id` int NOT NULL AUTO_INCREMENT,
  `report_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `report_type` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `generated_by` int NOT NULL,
  `generation_date` datetime NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`report_id`),
  KEY `generated_by` (`generated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `student_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `gender` enum('Male','Female','Other') COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `enrollment_date` date NOT NULL,
  `status` enum('Active','Inactive','Graduated','On Leave') COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `first_name`, `last_name`, `date_of_birth`, `created_at`, `gender`, `email`, `phone_number`, `address`, `enrollment_date`, `status`) VALUES
(1, 'John', 'Wick', '0000-00-00', '2024-10-11 06:45:10', '', 'john.wick.babayaga1@gmail.com', '09273658381', NULL, '2023-11-16', 'Active'),
(2, 'dasdasnion', 'nidosandoias', '2001-02-02', '2024-10-24 15:56:05', 'Male', 'ndsioandioas@gmail.com', '09173636251', NULL, '2024-10-18', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `gender` enum('Male','Female','Others','') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `enrollment_date` date DEFAULT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('Admin','Faculty','Student','Staff') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Student',
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('Active','Inactive','Graduated','On Leave') COLLATE utf8mb4_general_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `is_archived` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `first_name`, `last_name`, `date_of_birth`, `created_at`, `gender`, `phone_number`, `address`, `enrollment_date`, `password_hash`, `role`, `email`, `status`, `last_login`, `is_archived`) VALUES
(1, 'mirchea', 'System', 'Admin', NULL, '2024-10-24 14:23:55', NULL, NULL, NULL, NULL, '$2y$12$OFvwocqb4DyvVo1G3ovW9..Y4ehDMKvYaAbffK8kNqp9RHgoNSxKO', 'Admin', NULL, 'Active', NULL, 0),
(2, 's21015551', 'Darryl', 'Panis', '2001-11-22', '2024-10-24 14:23:55', 'Male', '09179615821', 'Blk 69 Lot 420 Street Streetan Q.C', NULL, '$2y$12$XWKf5ywjAvvYTBgftKrIj.yVuRjviZqQC4fDUyhiRdU2yASiqV9WW', 'Student', 'darrylpaniss@gmail.com', 'Active', NULL, 0),
(3, 's21015552', 'Fernan', 'Manaog', '2001-11-20', '2024-10-24 15:24:34', 'Male', '09179615821', 'street streetan', NULL, '$2y$12$3F98XwYguVD.8Nmrbtl1gu6bxDUJtCWH5uGs.TPz3Os0SwgyjGoD6', 'Student', 'fernan.manaog.123@gmail.com', 'Active', NULL, 0),
(4, 'test1', 'Duke', 'Dennis', NULL, '2024-10-24 19:47:09', NULL, NULL, NULL, NULL, '$2y$12$QPEVIjs7HQ6mFwGSrHVtP.RzzHeRCqEzv7PGKKIIyIOSWIITNYlKm', 'Admin', NULL, 'Active', NULL, 0),
(5, 's21015553', 'Joshua', 'Cillo', NULL, '2024-10-24 19:50:12', NULL, NULL, NULL, NULL, '$2y$12$KT38Jy2JHLr76rSAWY/sSe2Axx5hdkpqawa8tcPntlry93x2wWQyu', 'Student', NULL, 'Active', NULL, 1),
(6, 's21015554', 'Jose', 'Mainipin', NULL, '2024-10-24 19:50:25', NULL, NULL, NULL, NULL, '$2y$12$uFpQqZGhwyoXGrAlr6hRV.tWmNG/9bW09yev0YF.G6etdGWE8sShW', 'Student', NULL, 'Active', NULL, 0),
(7, 's2021212', NULL, NULL, NULL, '2024-10-24 22:37:41', NULL, NULL, NULL, NULL, '$2y$12$GPDB9U.HfPIVOKidgcm6ie9r9e9aI26Q0z4lZrKBp2v7joeUx774a', 'Student', NULL, 'Active', NULL, 0),
(8, 's21015541', 'Hans', 'Rivas', '2001-11-22', '2024-10-24 22:45:49', 'Male', '09179615929', 'Blk 56, Lot 7, Corianna, Bulacan City', NULL, '$2y$12$2VFZxDUvQ2PBJkg84rjBfu.2jXQPLPEZPokTxxFLwYxNQo.0YwwqK', 'Student', 'hans.rivas.333@gmail.com', 'Active', NULL, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE;

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `classes_ibfk_2` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`) ON DELETE SET NULL;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`) ON DELETE SET NULL;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Constraints for table `faculty`
--
ALTER TABLE `faculty`
  ADD CONSTRAINT `faculty_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`) ON DELETE SET NULL;

--
-- Constraints for table `financialtransactions`
--
ALTER TABLE `financialtransactions`
  ADD CONSTRAINT `financialtransactions_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollments` (`enrollment_id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`generated_by`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
