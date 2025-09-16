-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2025 at 03:58 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cardzap`
--

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `card_id` int(11) NOT NULL,
  `deck_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `card_order` int(11) DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `card_decks`
--

CREATE TABLE `card_decks` (
  `deck_id` int(11) NOT NULL,
  `deck_name` varchar(100) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `card_color` varchar(20) DEFAULT 'blue',
  `game_mode` enum('classic','quiz') DEFAULT 'classic',
  `is_public` tinyint(1) DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coop_lobbies`
--

CREATE TABLE `coop_lobbies` (
  `lobby_id` int(11) NOT NULL,
  `lobby_name` varchar(100) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `deck_id` int(11) NOT NULL,
  `max_players` int(11) DEFAULT 4,
  `current_players` int(11) DEFAULT 1,
  `status` enum('waiting','playing','finished') DEFAULT 'waiting',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_started` timestamp NULL DEFAULT NULL,
  `date_finished` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coop_participants`
--

CREATE TABLE `coop_participants` (
  `participant_id` int(11) NOT NULL,
  `lobby_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `score` int(11) DEFAULT 0,
  `position` int(11) DEFAULT 0,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `enrollment_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `date_enrolled` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_approved` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `friends_id` int(11) UNSIGNED NOT NULL,
  `user_one` int(11) NOT NULL,
  `user_two` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`friends_id`, `user_one`, `user_two`, `date_created`) VALUES
(5, 6, 3, '2025-09-03 04:54:41');

-- --------------------------------------------------------

--
-- Table structure for table `friend_request`
--

CREATE TABLE `friend_request` (
  `fr_id` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `status` enum('pending','accepted','declined') DEFAULT 'pending',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friend_request`
--

INSERT INTO `friend_request` (`fr_id`, `sender`, `receiver`, `status`, `date_created`) VALUES
(4, 3, 6, 'accepted', '2025-09-03 04:10:49'),
(5, 6, 3, 'accepted', '2025-09-03 04:29:07');

-- --------------------------------------------------------

--
-- Table structure for table `login_logs`
--

CREATE TABLE `login_logs` (
  `login_id` int(11) NOT NULL,
  `user_info_id` int(11) NOT NULL,
  `date_login` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_logs`
--

INSERT INTO `login_logs` (`login_id`, `user_info_id`, `date_login`) VALUES
(1, 1, '2025-08-14 01:47:17'),
(2, 1, '2025-08-14 01:47:28'),
(3, 1, '2025-08-14 01:48:57'),
(4, 1, '2025-08-14 06:16:14'),
(5, 1, '2025-08-14 06:17:29'),
(6, 1, '2025-08-15 20:35:58'),
(7, 1, '2025-08-15 20:36:08'),
(8, 3, '2025-08-16 10:20:39'),
(9, 1, '2025-08-16 10:21:12'),
(10, 2, '2025-08-16 10:28:02'),
(11, 2, '2025-08-16 10:28:02'),
(12, 2, '2025-08-16 10:28:12'),
(13, 2, '2025-08-16 10:28:12'),
(14, 2, '2025-08-16 10:28:27'),
(15, 2, '2025-08-16 10:28:27'),
(16, 2, '2025-08-16 10:28:40'),
(17, 2, '2025-08-16 10:28:51'),
(18, 2, '2025-08-16 10:28:51'),
(19, 3, '2025-08-16 10:30:03'),
(20, 2, '2025-08-16 10:31:26'),
(21, 3, '2025-08-17 21:07:00'),
(22, 3, '2025-08-17 21:11:02'),
(23, 3, '2025-08-17 21:11:20'),
(24, 3, '2025-08-18 21:03:52'),
(25, 4, '2025-08-18 21:12:55'),
(26, 4, '2025-08-18 21:13:11'),
(27, 4, '2025-08-19 08:03:47'),
(28, 4, '2025-08-19 08:16:25'),
(29, 3, '2025-08-19 08:35:19'),
(30, 6, '2025-08-19 11:01:28'),
(31, 3, '2025-08-19 11:03:52'),
(32, 6, '2025-08-19 11:04:39'),
(33, 7, '2025-08-19 20:32:13'),
(34, 7, '2025-08-19 20:32:57'),
(35, 4, '2025-08-20 01:13:21'),
(36, 7, '2025-08-20 01:14:07'),
(37, 3, '2025-08-20 01:15:13'),
(38, 4, '2025-09-01 20:38:25'),
(39, 3, '2025-09-02 07:08:04'),
(40, 4, '2025-09-02 17:41:28'),
(41, 4, '2025-09-02 18:30:52'),
(42, 4, '2025-09-02 19:15:16'),
(43, 4, '2025-09-02 19:15:25'),
(44, 4, '2025-09-02 19:24:15'),
(45, 4, '2025-09-02 20:06:34'),
(46, 3, '2025-09-02 20:06:48'),
(47, 3, '2025-09-02 20:06:55'),
(48, 4, '2025-09-02 20:44:26'),
(49, 3, '2025-09-02 20:51:40'),
(50, 6, '2025-09-02 22:16:52'),
(51, 3, '2025-09-02 22:54:25'),
(52, 5, '2025-09-02 23:08:07'),
(53, 3, '2025-09-02 23:34:04'),
(54, 5, '2025-09-02 23:35:51'),
(55, 5, '2025-09-02 23:39:26'),
(56, 3, '2025-09-02 23:47:53'),
(57, 4, '2025-09-03 01:50:22'),
(58, 3, '2025-09-03 01:52:03');

-- --------------------------------------------------------

--
-- Table structure for table `recent_cards`
--

CREATE TABLE `recent_cards` (
  `recent_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `deck_id` int(11) NOT NULL,
  `last_accessed` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `study_sessions`
--

CREATE TABLE `study_sessions` (
  `session_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `deck_id` int(11) NOT NULL,
  `session_type` enum('classic','quiz') NOT NULL,
  `score` int(11) DEFAULT 0,
  `total_cards` int(11) DEFAULT 0,
  `completed_cards` int(11) DEFAULT 0,
  `start_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `end_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `subject_code` varchar(20) NOT NULL,
  `subject_photo` varchar(255) DEFAULT NULL,
  `teacher_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `user_info_id` int(11) NOT NULL,
  `photo` varchar(500) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `e_mail` text NOT NULL,
  `pass_word` varchar(255) NOT NULL,
  `contact_no` varchar(11) NOT NULL,
  `course` varchar(255) NOT NULL DEFAULT 'N/A',
  `user_type` char(1) NOT NULL,
  `user_status` char(1) NOT NULL DEFAULT 'A',
  `date _created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`user_info_id`, `photo`, `full_name`, `e_mail`, `pass_word`, `contact_no`, `course`, `user_type`, `user_status`, `date _created`, `date_updated`) VALUES
(3, '', 'Cheriz Bianca Morco', 'surely@gmail.com', '$2y$10$pZs7bTo1hBTszBZeSUKfsugkwkHVU7j7oGVd/iMDcbLwzQaOr4uk6', '09999999999', 'BSIT', 'S', 'A', '2025-08-16 15:51:41', '2025-08-19 03:10:44'),
(4, '', 'Adeline Gomez', 'adeline@gmail.com', '$2y$10$FMRY2uhMqBk6rMXvnDWZee4ROF55.X87DLEN54Uat8NXhIW0islUu', '09999999999', 'BSIT', 'A', 'A', '2025-08-19 03:01:33', '2025-08-19 03:10:31'),
(5, '', 'Alyssa Sumalpong', 'sumalpong@gmail.com', '$2y$10$zEWF/VQO/kVuv4/bCS.J3uVXHy1J.ZyxB9t1bC4cQFwgZZWwODymS', '09999999999', 'N/A', 'T', 'A', '2025-08-19 03:02:19', '2025-08-19 14:16:14'),
(6, '', 'Alyssa Gwyn Namora', 'namora@gmail.com', '$2y$10$I2SfWNZkFvN4keWYHbj7Lu6wQhFPFaadG1IPD23LOD980moqIOckK', '09999999999', 'NURSING', 'S', 'A', '2025-08-19 14:03:36', '2025-08-19 14:03:36'),
(7, '', 'Christine Boringot', 'boringot@gmail.com', '$2y$10$NZesYERylRjwCoyoxir/OOLnUJZgyOhsQzLyXg5zvkpjmaijbYWPi', '09876543212', 'N/A', 'T', 'A', '2025-08-19 14:04:40', '2025-08-19 14:16:14'),
(8, '', 'Mika Ella Mae Nuyles', 'nuyles@gmail.com', '$2y$10$L9DT7Qx7b92mV7Y..xtWmup.ygGJkeGrqnGTCFUl89Mu1YloPf9HG', '09876543212', 'N/A', 'T', 'A', '2025-08-19 14:15:06', '2025-08-19 14:15:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`card_id`),
  ADD KEY `deck_id` (`deck_id`);

--
-- Indexes for table `card_decks`
--
ALTER TABLE `card_decks`
  ADD PRIMARY KEY (`deck_id`),
  ADD KEY `creator_id` (`creator_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `coop_lobbies`
--
ALTER TABLE `coop_lobbies`
  ADD PRIMARY KEY (`lobby_id`),
  ADD KEY `creator_id` (`creator_id`),
  ADD KEY `deck_id` (`deck_id`);

--
-- Indexes for table `coop_participants`
--
ALTER TABLE `coop_participants`
  ADD PRIMARY KEY (`participant_id`),
  ADD UNIQUE KEY `unique_participant` (`lobby_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD UNIQUE KEY `unique_enrollment` (`student_id`,`subject_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`friends_id`),
  ADD UNIQUE KEY `user_one` (`user_one`,`user_two`),
  ADD UNIQUE KEY `user_one_2` (`user_one`,`user_two`),
  ADD KEY `friends_ibfk_2` (`user_two`);

--
-- Indexes for table `friend_request`
--
ALTER TABLE `friend_request`
  ADD PRIMARY KEY (`fr_id`),
  ADD KEY `sender` (`sender`),
  ADD KEY `receiver` (`receiver`);

--
-- Indexes for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD PRIMARY KEY (`login_id`);

--
-- Indexes for table `recent_cards`
--
ALTER TABLE `recent_cards`
  ADD PRIMARY KEY (`recent_id`),
  ADD UNIQUE KEY `unique_recent` (`user_id`,`deck_id`),
  ADD KEY `deck_id` (`deck_id`);

--
-- Indexes for table `study_sessions`
--
ALTER TABLE `study_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `deck_id` (`deck_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`),
  ADD UNIQUE KEY `subject_code` (`subject_code`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`user_info_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `card_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `card_decks`
--
ALTER TABLE `card_decks`
  MODIFY `deck_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coop_lobbies`
--
ALTER TABLE `coop_lobbies`
  MODIFY `lobby_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coop_participants`
--
ALTER TABLE `coop_participants`
  MODIFY `participant_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `friends_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `friend_request`
--
ALTER TABLE `friend_request`
  MODIFY `fr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `login_logs`
--
ALTER TABLE `login_logs`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `recent_cards`
--
ALTER TABLE `recent_cards`
  MODIFY `recent_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `study_sessions`
--
ALTER TABLE `study_sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `user_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cards`
--
ALTER TABLE `cards`
  ADD CONSTRAINT `cards_ibfk_1` FOREIGN KEY (`deck_id`) REFERENCES `card_decks` (`deck_id`) ON DELETE CASCADE;

--
-- Constraints for table `card_decks`
--
ALTER TABLE `card_decks`
  ADD CONSTRAINT `card_decks_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `user_info` (`user_info_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `card_decks_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`) ON DELETE SET NULL;

--
-- Constraints for table `coop_lobbies`
--
ALTER TABLE `coop_lobbies`
  ADD CONSTRAINT `coop_lobbies_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `user_info` (`user_info_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coop_lobbies_ibfk_2` FOREIGN KEY (`deck_id`) REFERENCES `card_decks` (`deck_id`) ON DELETE CASCADE;

--
-- Constraints for table `coop_participants`
--
ALTER TABLE `coop_participants`
  ADD CONSTRAINT `coop_participants_ibfk_1` FOREIGN KEY (`lobby_id`) REFERENCES `coop_lobbies` (`lobby_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coop_participants_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`user_info_id`) ON DELETE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `user_info` (`user_info_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`) ON DELETE CASCADE;

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`user_one`) REFERENCES `user_info` (`user_info_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`user_two`) REFERENCES `user_info` (`user_info_id`) ON DELETE CASCADE;

--
-- Constraints for table `friend_request`
--
ALTER TABLE `friend_request`
  ADD CONSTRAINT `friend_request_ibfk_1` FOREIGN KEY (`sender`) REFERENCES `user_info` (`user_info_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friend_request_ibfk_2` FOREIGN KEY (`receiver`) REFERENCES `user_info` (`user_info_id`) ON DELETE CASCADE;

--
-- Constraints for table `recent_cards`
--
ALTER TABLE `recent_cards`
  ADD CONSTRAINT `recent_cards_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`user_info_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recent_cards_ibfk_2` FOREIGN KEY (`deck_id`) REFERENCES `card_decks` (`deck_id`) ON DELETE CASCADE;

--
-- Constraints for table `study_sessions`
--
ALTER TABLE `study_sessions`
  ADD CONSTRAINT `study_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`user_info_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `study_sessions_ibfk_2` FOREIGN KEY (`deck_id`) REFERENCES `card_decks` (`deck_id`) ON DELETE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `user_info` (`user_info_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
