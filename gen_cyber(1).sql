-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2023 at 11:13 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gen_cyber`
--

-- --------------------------------------------------------

--
-- Table structure for table `abstracts_tbl`
--

CREATE TABLE `abstracts_tbl` (
  `project_id` tinyint(9) UNSIGNED NOT NULL,
  `project_name` tinytext NOT NULL,
  `event_of_project` tinytext NOT NULL,
  `project_status` tinytext DEFAULT NULL,
  `project_reviewers` tinytext DEFAULT NULL,
  `project_date_submitted` datetime NOT NULL,
  `project_attachments` int(11) NOT NULL,
  `project_author` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='need to set up project_attachments properly';

-- --------------------------------------------------------

--
-- Table structure for table `back-end_login_tbl`
--

CREATE TABLE `back-end_login_tbl` (
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `password_reset` varchar(50) DEFAULT NULL,
  `go_to_site` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='not sure what go_to_site or password_reset should be';

-- --------------------------------------------------------

--
-- Table structure for table `login_tbl`
--

CREATE TABLE `login_tbl` (
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `password_reset` varchar(50) NOT NULL,
  `user_account` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='user_account set to be J, A, or T';

--
-- Dumping data for table `login_tbl`
--

INSERT INTO `login_tbl` (`user_email`, `user_password`, `password_reset`, `user_account`) VALUES
('email@email.com', 'password', '', 'A'),
('admin@admin.com', 'admin', '', 'A'),
('sillyuser', 'silly', '', 'T');

-- --------------------------------------------------------

--
-- Table structure for table `members_tbl`
--

CREATE TABLE `members_tbl` (
  `users` text DEFAULT NULL,
  `school_name` tinytext DEFAULT NULL,
  `subject_area` tinytext DEFAULT NULL,
  `account_type` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `register_tbl`
--

CREATE TABLE `register_tbl` (
  `register_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `school_name` tinytext NOT NULL,
  `school_address` varchar(100) NOT NULL,
  `school_city` tinytext NOT NULL,
  `school_state` tinytext NOT NULL,
  `school_role` varchar(100) NOT NULL,
  `user_role` char(1) NOT NULL DEFAULT 'T'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register_tbl`
--

INSERT INTO `register_tbl` (`register_id`, `first_name`, `last_name`, `user_email`, `school_name`, `school_address`, `school_city`, `school_state`, `school_role`, `user_role`) VALUES
(8, 'bob', 'dylan', 'bobd@email.com', 'cyber', '1 cyber dr', 'city', '', 'teacher', 'T'),
(9, 'first', 'registration', 'reg@email.com', 'cyber school', '1 cyber dr', 'huntington', '', 'teacher', 'T');

-- --------------------------------------------------------

--
-- Table structure for table `users_tbl`
--

CREATE TABLE `users_tbl` (
  `user_id` tinyint(9) UNSIGNED NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(250) NOT NULL,
  `user_role` char(1) NOT NULL,
  `user_posts` text DEFAULT NULL,
  `user_status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_tbl`
--

INSERT INTO `users_tbl` (`user_id`, `user_name`, `name`, `user_email`, `user_password`, `user_role`, `user_posts`, `user_status`) VALUES
(1, 'Admin', 'Bobby', 'admin@admin.com', 'admin', 'A', NULL, ''),
(4, 'Teach', 'Teacher', 'teach@email.com', 'teach', 'T', NULL, ''),
(5, 'Judy', 'Judge', 'judge@email.com', 'judge', 'J', NULL, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abstracts_tbl`
--
ALTER TABLE `abstracts_tbl`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `register_tbl`
--
ALTER TABLE `register_tbl`
  ADD PRIMARY KEY (`register_id`);

--
-- Indexes for table `users_tbl`
--
ALTER TABLE `users_tbl`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abstracts_tbl`
--
ALTER TABLE `abstracts_tbl`
  MODIFY `project_id` tinyint(9) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `register_tbl`
--
ALTER TABLE `register_tbl`
  MODIFY `register_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users_tbl`
--
ALTER TABLE `users_tbl`
  MODIFY `user_id` tinyint(9) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
