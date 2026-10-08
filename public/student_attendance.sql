-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2026 at 03:02 PM
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
-- Database: `student_attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'active',
  `starts_at` datetime DEFAULT NULL,
  `ends_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_logs`
--

CREATE TABLE `attendance_logs` (
  `id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `department` varchar(50) DEFAULT NULL,
  `time_in` datetime DEFAULT NULL,
  `time_out` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Present',
  `remarks` text DEFAULT NULL,
  `log_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'BSCS 1A'),
(2, 'BSCS 1B'),
(3, 'BSCS 2A'),
(4, 'BSCS 2B'),
(5, 'BSCS 3A'),
(6, 'BSCS 3B'),
(7, 'BSCS 4A'),
(8, 'BSCS 4B');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `head` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `code`, `head`) VALUES
(1, 'AppDev', 'CS', 'Harold Gonzales');

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `title`, `time_in`, `time_out`, `created_at`) VALUES
(5, 'Tuesday', '14:00:00', '17:00:00', '2026-10-06 14:12:47'),
(6, 'Thursday', '14:00:00', '17:00:00', '2026-10-06 14:12:47');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `department` varchar(50) NOT NULL,
  `category` varchar(50) DEFAULT 'Student',
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `course` varchar(50) DEFAULT 'BSCS 2B',
  `year` varchar(20) DEFAULT '2nd Year'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_id`, `name`, `department`, `category`, `email`, `created_at`, `course`, `year`) VALUES
(1, '71202025', 'Yarcia John Paul B.', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(2, '66602025', 'Cinco Franklin Lei N.', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(3, '71562025', 'Jannica Jean C.DAVID', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(4, '71552025', 'Jillian Joy D. SAMBILE', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(5, '71362025', 'Jezzrah Jade M. PARAS', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(6, '71332025', 'Jernand T. ARCEO', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(7, '71292025', 'Francis Cedric V. DAYRIT', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(8, '71232025', 'Reiver M. GUTIERREZ', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(9, '71112025', 'Dustin M. GONZALES', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(10, '70322025', 'Jahred M. SULAY', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(11, '70232025', 'Warren G. CALIGAGAN', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(12, '70202025', 'Carl Michael S. POLICARPIO', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(13, '70102025', 'Prince Brix S. MUNGCAL', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(14, '69892025', 'Glaiza R. LACANLALE', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(15, '69782025', 'Cedrick A. SARMIENTO', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(16, '69602025', 'Kate Nicole M. DOMINGO', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(17, '69402025', 'Andrei S. MATAGA', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(18, '67802025', 'Avril Clain G. SANGUYO', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(19, '55162023', 'Estrada, gian NARCISO', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(20, '67482025', 'Razell M. SOLIMAN', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(21, '67142025', 'Tweetam Mariel V. MERCADO', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(22, '66932025', 'Lovely Faith R. ALFONSO', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(23, '66312025', 'Ma. Mirafe R. SUNGA', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(24, '66302025', 'Raizen D. TIPAY', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(25, '62452024', 'Marielle B. DELA PEÑA', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(26, '59832024', 'Charles G. SALUNGA', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(27, '46862022', 'Rjay P. ARIAS', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(28, '46242022', 'Traxxas D. SISON', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(29, '28062021', 'Jollina D. DIMATULAC', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year'),
(30, '66352025', 'Manalungsung Sammuel', 'BSCS 2B', 'BSCS 2B', NULL, '2026-09-26 14:09:14', 'BSCS 2B', '2nd Year');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `role` varchar(20) DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `role`) VALUES
(1, 'admin', 'admin123', 'Yarcia John Paul', 'admin'),
(2, 'johnpaulyarcia', '1234', NULL, 'teacher');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance_logs`
--
ALTER TABLE `attendance_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance_logs`
--
ALTER TABLE `attendance_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
