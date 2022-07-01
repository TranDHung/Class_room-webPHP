-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2020 at 03:28 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database`
--
CREATE DATABASE IF NOT EXISTS `database` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `database`;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `classId` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `className` text COLLATE utf8_unicode_ci NOT NULL,
  `creatorname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `courseName` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `room` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `picture` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`classId`, `className`, `creatorname`, `courseName`, `room`, `picture`) VALUES
('2JZBLVFn8', 'HK1_2020_CTRR', 'Vũ Trung Hậu', 'Cấu trúc rời rạc', 'B0306', 'whale.jpg'),
('av2M8RPiw', 'HK1_2020_WEB', 'Vũ Trung Hậu', 'Lập trình web và ứng dụng', 'B0206', 'fish.jpg'),
('zgCQ1Wbms', 'HK1_2020_CTDL_LT', 'Trần Đức Hưng', 'Cấu trúc dữ liệu và giải thuật', 'B0308', 'alligator.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `commentId` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `creatorname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `objectId` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`commentId`, `creatorname`, `content`, `objectId`) VALUES
('g0WoZ46s', 'Vũ Trung Hậu', 'Đây là comment của giảng viên', 'QSF8od7H'),
('lQpRK07y', 'Thạch Thanh Hữu', 'Đây là comment của học sinh.', 'QSF8od7H');

-- --------------------------------------------------------

--
-- Table structure for table `object`
--

CREATE TABLE `object` (
  `objectId` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `creator` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `file` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `classId` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `object`
--

INSERT INTO `object` (`objectId`, `content`, `creator`, `file`, `classId`) VALUES
('QSF8od7H', 'Đây là bài đăng', 'Vũ Trung Hậu', 'Loi cam on.txt', '2JZBLVFn8');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `birthdate` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phonenumber` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `class` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `fullname`, `birthdate`, `email`, `phonenumber`, `type`, `class`) VALUES
('admin', '$2y$10$9LqBd2Ny6LO0.PLaMlszP.BW5kRD1aLJKXRWzSacEDxgRe8pxhOIa', 'Trần Đức Hưng', '20/08/2001', 'tranduchung0610@gmail.com', '0961092142', 0, ''),
('huuthach', '$2y$10$T15F6aSYLY70TEWfG3iGMuI0Gu5/9AyMkjrEySz82Rh./jAc8gio2', 'Thạch Thanh Hữu', '30/09/2001', 'thachtommy5@gmail.com', '0976767749', 2, 'zgCQ1Wbms,av2M8RPiw,2JZBLVFn8,'),
('vuhau', '$2y$10$TKs1IeBU5zo1MT6pPN./Wep4xRXWPEcqLkAlM3M5n7mmHwQEYYN1q', 'Vũ Trung Hậu', '2001-12-13', 'vuhau1312@gmail.com', '12318471257', 1, 'zgCQ1Wbms,');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`classId`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`commentId`);

--
-- Indexes for table `object`
--
ALTER TABLE `object`
  ADD PRIMARY KEY (`objectId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
