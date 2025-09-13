-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 10, 2025 at 09:32 AM
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
-- Database: `e-learning`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(45) NOT NULL,
  `pass` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `pass`) VALUES
(1, 'admin@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055');

-- --------------------------------------------------------

--
-- Table structure for table `badge`
--

DROP TABLE IF EXISTS `badge`;
CREATE TABLE IF NOT EXISTS `badge` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(25) NOT NULL,
  `des` text NOT NULL,
  `iconUrl` varchar(65) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `badge`
--

INSERT INTO `badge` (`id`, `title`, `des`, `iconUrl`, `createdAt`) VALUES
(1, 'Course Completion Badge', 'Awarded to learners who have successfully completed all lessons and requirements of the course. This badge recognizes dedication, consistency, and achievement in advancing their knowledge and skills.', '', '2025-09-09 09:10:40');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(25) NOT NULL,
  `des` text NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `icon` varchar(15) NOT NULL,
  `bg` varchar(15) NOT NULL,
  `level` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `title`, `des`, `createdAt`, `icon`, `bg`, `level`) VALUES
(1, 'Advanced JavaScript', 'Master modern JavaScript concepts and frameworks', '2025-09-08 09:56:33', 'code', 'bg-indigo-500', 'Beginner'),
(3, 'Database Design', 'Learn to design efficient database structures', '2025-09-08 10:03:56', 'database', 'bg-green-500', 'Intermediate'),
(4, 'UI/UX Design', 'Create beautiful and functional user interfaces', '2025-09-08 10:03:56', 'clock', 'bg-purple-500', 'Advanced'),
(5, 'Python Fundamentals', 'Learn Python from the ground up', '2025-09-08 10:05:03', 'terminal', 'bg-yellow-500', 'Beginner'),
(6, 'Cybersecurity Basics', 'Essential knowledge for staying safe online', '2025-09-08 10:07:03', 'shield', 'bg-red-500', 'Intermediate'),
(7, 'Cloud Computing', 'Introduction to cloud services and architecture', '2025-09-08 10:07:03', 'cloud', 'bg-blue-500', 'Advanced');

-- --------------------------------------------------------

--
-- Table structure for table `lesson`
--

DROP TABLE IF EXISTS `lesson`;
CREATE TABLE IF NOT EXISTS `lesson` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sectionId` int NOT NULL,
  `title` varchar(35) NOT NULL,
  `position` int NOT NULL,
  `contentUrl` varchar(45) NOT NULL,
  `contentType` varchar(15) NOT NULL,
  `duration` varchar(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `courseId` (`sectionId`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `lesson`
--

INSERT INTO `lesson` (`id`, `sectionId`, `title`, `position`, `contentUrl`, `contentType`, `duration`, `createdAt`) VALUES
(1, 1, 'Setting Up Your Environment', 1, 'https://www.youtube.com/watch?v=zofMnllkVfI', 'video', '2:49', '2025-09-08 10:39:47'),
(2, 1, 'Writing Your First JavaScript Code', 2, 'https://www.youtube.com/watch?v=zofMnllkVfI', 'video', '2:49', '2025-09-08 10:39:47'),
(3, 1, 'Understanding Variables & Data Type', 3, 'https://www.youtube.com/watch?v=zofMnllkVfI', 'video', '2:49', '2025-09-08 10:41:22'),
(4, 1, 'Using Comments for Better Code', 2, 'https://www.youtube.com/watch?v=zofMnllkVfI', 'video', '2:49', '2025-09-08 10:41:22'),
(5, 2, 'Operators and Expressions', 1, 'https://www.youtube.com/watch?v=zofMnllkVfI', 'video', '2:49', '2025-09-08 10:42:57'),
(6, 2, 'Working with Strings', 2, 'https://www.youtube.com/watch?v=zofMnllkVfI', 'video', '2:49', '2025-09-08 10:42:57'),
(7, 2, 'Numbers and Math in JavaScript', 3, 'https://www.youtube.com/watch?v=zofMnllkVfI', 'video', '2:49', '2025-09-08 10:44:18'),
(8, 2, 'Booleans and Logical Operators', 4, 'https://www.youtube.com/watch?v=zofMnllkVfI', 'video', '2:49', '2025-09-08 10:44:18'),
(13, 3, 'Conditional Statements: if, else if', 1, 'https://www.youtube.com/watch?v=zofMnllkVfI', 'video', '2:49', '2025-09-08 10:47:29'),
(14, 3, 'Switch Statements', 2, 'https://www.youtube.com/watch?v=zofMnllkVfI', 'video', '2:49', '2025-09-08 10:47:29'),
(15, 3, 'Loops: for, while, do...while', 3, 'https://www.youtube.com/watch?v=zofMnllkVfI', 'video', '2:49', '2025-09-08 10:48:45'),
(16, 3, 'Practical Control Flow Examples', 4, 'https://www.youtube.com/watch?v=zofMnllkVfI', 'video', '2:49', '2025-09-08 10:48:45'),
(17, 4, 'Introduction to Functions', 1, 'https://www.youtube.com/watch?v=zofMnllkVfI', 'video', '2:49', '2025-09-08 10:50:21'),
(18, 4, 'Function Parameters & Return Values', 2, 'https://www.youtube.com/watch?v=zofMnllkVfI', 'video', '2:49', '2025-09-08 10:50:21'),
(19, 4, 'Function Scope & Hoisting', 3, 'https://www.youtube.com/watch?v=zofMnllkVfI', 'video', '2:49', '2025-09-08 10:51:37'),
(20, 4, 'Arrow Functions', 4, 'https://www.youtube.com/watch?v=zofMnllkVfI', 'video', '2:49', '2025-09-08 10:51:37'),
(21, 4, 'Test', 5, 'https://music.youtube.com/watch?v=TQvY4yUpTJc', 'video', '02:37', '2025-09-10 08:19:10');

-- --------------------------------------------------------

--
-- Table structure for table `progress`
--

DROP TABLE IF EXISTS `progress`;
CREATE TABLE IF NOT EXISTS `progress` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userId` int NOT NULL,
  `courseId` int NOT NULL,
  `lessonId` int NOT NULL,
  `status` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'completed',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `lessonId` (`lessonId`),
  KEY `courseId` (`courseId`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `progress`
--

INSERT INTO `progress` (`id`, `userId`, `courseId`, `lessonId`, `status`) VALUES
(1, 1, 1, 1, 'completed'),
(2, 1, 1, 2, 'completed'),
(3, 1, 1, 17, 'completed'),
(4, 1, 1, 3, 'completed'),
(5, 1, 1, 4, 'completed'),
(6, 1, 1, 5, 'completed'),
(7, 1, 1, 6, 'completed'),
(8, 1, 1, 7, 'completed'),
(9, 1, 1, 8, 'completed'),
(10, 1, 1, 13, 'completed'),
(11, 1, 1, 14, 'completed'),
(12, 1, 1, 15, 'completed'),
(13, 1, 1, 16, 'completed'),
(14, 1, 1, 18, 'completed'),
(15, 1, 1, 19, 'completed'),
(18, 1, 1, 20, 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

DROP TABLE IF EXISTS `section`;
CREATE TABLE IF NOT EXISTS `section` (
  `id` int NOT NULL AUTO_INCREMENT,
  `courseId` int NOT NULL,
  `title` varchar(45) NOT NULL,
  `position` int NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `courseId` (`courseId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`id`, `courseId`, `title`, `position`, `createdAt`) VALUES
(1, 1, 'Section 1: Getting Started with JavaScript', 1, '2025-09-08 10:29:31'),
(2, 1, 'Section 2: Core JavaScript Basics', 2, '2025-09-08 10:29:31'),
(3, 1, 'Section 3: Control Flow', 3, '2025-09-08 10:31:09'),
(4, 1, 'Section 4: Functions in JavaScript', 4, '2025-09-08 10:31:09');

-- --------------------------------------------------------

--
-- Table structure for table `studentbadge`
--

DROP TABLE IF EXISTS `studentbadge`;
CREATE TABLE IF NOT EXISTS `studentbadge` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userId` int NOT NULL,
  `badgeId` int NOT NULL,
  `awardedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `courseId` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `badgeId` (`badgeId`),
  KEY `courseId` (`courseId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `studentbadge`
--

INSERT INTO `studentbadge` (`id`, `userId`, `badgeId`, `awardedAt`, `courseId`) VALUES
(1, 1, 1, '2025-09-09 09:37:22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fullName` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(45) NOT NULL,
  `pass` varchar(35) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `otp` int NOT NULL,
  `verifiedStatus` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fullName`, `email`, `pass`, `createdAt`, `otp`, `verifiedStatus`) VALUES
(1, 'Akubue Alexander', 'berlin@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '2025-09-08 13:26:05', 81872, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lesson`
--
ALTER TABLE `lesson`
  ADD CONSTRAINT `lesson_ibfk_1` FOREIGN KEY (`sectionId`) REFERENCES `section` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `progress`
--
ALTER TABLE `progress`
  ADD CONSTRAINT `progress_ibfk_1` FOREIGN KEY (`lessonId`) REFERENCES `lesson` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `progress_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `progress_ibfk_3` FOREIGN KEY (`courseId`) REFERENCES `course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `section_ibfk_1` FOREIGN KEY (`courseId`) REFERENCES `course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `studentbadge`
--
ALTER TABLE `studentbadge`
  ADD CONSTRAINT `studentbadge_ibfk_1` FOREIGN KEY (`badgeId`) REFERENCES `badge` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `studentbadge_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `studentbadge_ibfk_3` FOREIGN KEY (`courseId`) REFERENCES `course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
