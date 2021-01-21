-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 19, 2020 at 10:45 AM
-- Server version: 10.3.24-MariaDB-log
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `danielkh_ComputerServicesDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `Services`
--

CREATE TABLE `Services` (
  `ID` int(11) NOT NULL,
  `Type` text DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Price` double DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Services`
--

INSERT INTO `Services` (`ID`, `Type`, `Name`, `Price`, `image`, `Description`) VALUES
(1, 'Service', 'Desktop Service', 75, 'Images/Tower.jpg', 'Labor charge for servicing a desktop or tower computer. Parts are subject to additional cost.'),
(2, 'Service', 'Laptop Service', 150, 'Images/Laptop.jpg', 'Labor charge for servicing a laptop. Parts are subject to additional cost.'),
(3, 'Service', 'Printer Service', 50, 'Images/Printer.jpg', 'Labor charge for servicing a printer. Parts are subject to additional cost.'),
(4, 'Service', 'Monitor Service', 50, 'Images/Monitor.jpg', 'Labor charge for servicing a monitor. Parts are subject to additional cost.'),
(5, 'Service', 'Network Service', 150, 'Images/HomeNetwork.png', 'Labor charge for servicing a small home network. Parts are subject to additional cost.'),
(6, 'Part', 'Hard Drive', 150, 'Images/WesternDigital.jpg', '500 GB Western Digital HDD'),
(7, 'Part', 'Router', 150, 'Images/Linksys.jpg', 'Linksys RE6500'),
(8, 'Part', 'Monitor', 250, 'Images/Dell.jfif', 'Dell 27 inches'),
(9, 'Part', 'Printer', 175, 'Images/HP.jfif', 'HP OfficeJet Pro 8210 USB, Wireless, Network Color Inkjet Printer'),
(10, 'Part', 'Scanner', 100, 'Images/Epson.jpg', 'Epson Perfection V39 Flatbed Color Image Scanner');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Services`
--
ALTER TABLE `Services`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Services`
--
ALTER TABLE `Services`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
