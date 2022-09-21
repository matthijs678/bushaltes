-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 21, 2022 at 10:37 AM
-- Server version: 5.7.24
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bushaltes`
--

-- --------------------------------------------------------

--
-- Table structure for table `halte`
--

CREATE TABLE `halte` (
  `halteID` int(11) NOT NULL,
  `address` varchar(64) COLLATE utf8mb4_bin NOT NULL,
  `timeRelativeSeconds` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `halte`
--

INSERT INTO `halte` (`halteID`, `address`, `timeRelativeSeconds`) VALUES
(3, 'Tilburg, Centraal Station', 0),
(4, 'Tilburg, Station Ingang Noord', 240),
(5, 'Tilburg, Spoorlaan', 60),
(6, 'Tilburg, Besterdring', 70),
(7, 'Tilburg, Besterdplein', 70),
(8, 'Tilburg, Veldhovenring', 90),
(9, 'Tilburg, Wilhelminapark', 90),
(10, 'Tilburg, Goirkestraat', 70),
(11, 'Tilburg, Kasteeldreef', 30),
(12, 'Tilburg, Van Hogendorpstraat', 180),
(13, 'Tilburg, Julianapark', 70),
(14, 'Tilburg, Von Weberstraat', 90),
(15, 'Tilburg, Hoffmanlaan', 45),
(16, 'Tilburg, Brucknerlaan', 75),
(17, 'Tilburg, Wagnerplein', 60),
(18, 'Tilburg, Busstation Noord', 50),
(19, 'Tilburg, Mahlerstraat', 70),
(20, 'Tilburg, Verdiplein', 75);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `halte`
--
ALTER TABLE `halte`
  ADD PRIMARY KEY (`halteID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `halte`
--
ALTER TABLE `halte`
  MODIFY `halteID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
