-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2026 at 04:25 PM
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
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `hours` varchar(50) DEFAULT NULL,
  `late_after` varchar(20) DEFAULT NULL,
  `scan_window` varchar(100) DEFAULT NULL,
  `available_days` varchar(50) DEFAULT NULL,
  `assignments` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `name`, `hours`, `late_after`, `scan_window`, `available_days`, `assignments`, `status`) VALUES
(1, 'Tuesday AB202', '', '15', '60 min before 120 min after', 'Tue,Thu', 'BSCS 2B - 30 people', 'Active'),
(2, 'Thursday CL1', '', '15', '60 min before 120 min after', 'Tue,Thu', 'BSCS 2B - 30 people', 'Active');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_id`, `name`, `department`, `category`, `email`, `created_at`) VALUES
(1, '71202025', 'Yarcia John Paul B.', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(2, '66602025', 'Cinco Franklin Lei N.', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(3, '71562025', 'Jannica Jean C.DAVID', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(4, '71552025', 'Jillian Joy D. SAMBILE', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(5, '71362025', 'Jezzrah Jade M. PARAS', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(6, '71332025', 'Jernand T. ARCEO', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(7, '71292025', 'Francis Cedric V. DAYRIT', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(8, '71232025', 'Reiver M. GUTIERREZ', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(9, '71112025', 'Dustin M. GONZALES', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(10, '70322025', 'Jahred M. SULAY', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(11, '70232025', 'Warren G. CALIGAGAN', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(12, '70202025', 'Carl Michael S. POLICARPIO', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(13, '70102025', 'Prince Brix S. MUNGCAL', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(14, '69892025', 'Glaiza R. LACANLALE', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(15, '69782025', 'Cedrick A. SARMIENTO', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(16, '69602025', 'Kate Nicole M. DOMINGO', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(17, '69402025', 'Andrei S. MATAGA', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(18, '67802025', 'Avril Clain G. SANGUYO', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(19, '55162023', 'Estrada, gian NARCISO', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(20, '67482025', 'Razell M. SOLIMAN', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(21, '67142025', 'Tweetam Mariel V. MERCADO', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(22, '66932025', 'Lovely Faith R. ALFONSO', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(23, '66312025', 'Ma. Mirafe R. SUNGA', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(24, '66302025', 'Raizen D. TIPAY', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(25, '62452024', 'Marielle B. DELA PEÑA', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(26, '59832024', 'Charles G. SALUNGA', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(27, '46862022', 'Rjay P. ARIAS', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(28, '46242022', 'Traxxas D. SISON', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(29, '28062021', 'Jollina D. DIMATULAC', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14'),
(30, '66352025', 'Manalungsung Sammuel', 'BSCS 2B', 'Student', NULL, '2026-09-26 14:09:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`) VALUES
(1, 'admin', 'admin123', 'Yarcia John Paul');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance_logs`
--
ALTER TABLE `attendance_logs`
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
-- AUTO_INCREMENT for table `attendance_logs`
--
ALTER TABLE `attendance_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
