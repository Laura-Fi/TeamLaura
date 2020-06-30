-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 30, 2020 at 09:14 AM
-- Server version: 5.7.29
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tennis`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `bookId` int(11) NOT NULL,
  `memberId` int(11) NOT NULL,
  `courtId` int(11) NOT NULL,
  `bookingDate` date NOT NULL,
  `bookFrom` int(11) NOT NULL,
  `bookTo` int(11) NOT NULL,
  `guestName` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`bookId`, `memberId`, `courtId`, `bookingDate`, `bookFrom`, `bookTo`, `guestName`) VALUES
(15, 1, 5, '2020-07-03', 11, 12, ''),
(53, 1, 1, '2020-07-08', 14, 16, ''),
(57, 2, 1, '2020-06-30', 14, 17, ''),
(17, 3, 4, '2020-07-10', 17, 18, ''),
(44, 3, 2, '2020-07-08', 7, 12, 'Rafa'),
(42, 1, 2, '2020-07-10', 11, 17, ''),
(43, 2, 3, '2020-07-10', 9, 14, ''),
(27, 3, 1, '2020-07-01', 9, 10, 'Training1'),
(55, 3, 1, '2020-06-30', 13, 14, 'Test'),
(56, 3, 3, '2020-06-30', 15, 20, 'Training1'),
(32, 1, 6, '2020-07-23', 7, 10, ''),
(50, 3, 4, '2020-07-08', 12, 13, 'Test'),
(52, 2, 2, '2020-07-10', 9, 11, ''),
(41, 1, 5, '2020-07-08', 7, 8, ''),
(36, 1, 6, '2020-07-08', 7, 8, ''),
(45, 2, 3, '2020-07-10', 7, 9, ''),
(40, 3, 1, '2020-07-10', 7, 8, 'Anna'),
(58, 4, 5, '2020-06-30', 13, 15, ''),
(59, 5, 3, '2020-06-30', 12, 13, '');

-- --------------------------------------------------------

--
-- Table structure for table `court`
--

CREATE TABLE `court` (
  `id` int(11) NOT NULL,
  `courtName` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `court`
--

INSERT INTO `court` (`id`, `courtName`) VALUES
(1, 'Court 1'),
(2, 'Court 2'),
(3, 'Court 3'),
(4, 'Court 4'),
(5, 'Court 5'),
(6, 'Court 6');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `firstName` varchar(40) NOT NULL,
  `lastName` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isAdmin` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='table of all members of the tennis club';

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `firstName`, `lastName`, `email`, `password`, `isAdmin`) VALUES
(1, 'Laura', 'Fischer', 'laura@email.de', '$2y$10$4fA1UZTWh2fZehiJIJNnu.ztcLIM8ngYeg/.5uXiXG4NGhSfE59zK', 0),
(2, 'Roger', 'Federer', 'rfed@gmail.com', '$2y$10$bSKAxDQ28Hw0bgYv1xF37OnvlRURRz27iaoQwRMOa.NrJkMFGOlA6', 0),
(3, 'Admin', '', 'admin@mail.com', '$2y$10$4fA1UZTWh2fZehiJIJNnu.ztcLIM8ngYeg/.5uXiXG4NGhSfE59zK', 1),
(4, 'Romy', 'Williams', 'romy@mail.com', '$2y$10$E/.gJLSCKeZkGcP.aoBplev4qZBT7S55cqVB3TSdu/vpoI04.Plme', 0),
(5, 'Dominic', 'Thiem', 'domi@mail.com', '$2y$10$yS7rBXvk0vZ6PqVOLT3UKOL8BlYSepgO1oMV11xVdMBrdPntxfQ6C', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`bookId`);

--
-- Indexes for table `court`
--
ALTER TABLE `court`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `bookId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `court`
--
ALTER TABLE `court`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
