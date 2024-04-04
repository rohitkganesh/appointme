-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2024 at 09:20 AM
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
-- Database: `appointme`
--

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `Id` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Mobile` text NOT NULL,
  `Password` varchar(20) NOT NULL,
  `DOB` date NOT NULL,
  `Gender` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`Id`, `Name`, `Email`, `Mobile`, `Password`, `DOB`, `Gender`) VALUES
(9, 'Siddhant Tamang', 'tsiddhant@gmail.com', '9817911141', '$2y$10$R589JtpYVCn.p', '2024-04-04', 'male'),
(10, 'Siddhant Tamang', 'sid@gmail.com', '9817911141', '$2y$10$RAKgI4w/wg5lO', '2024-04-04', 'male'),
(11, 'rohit ganesh', 'rohit@gmail.com', '98213232', '$2y$10$WwU2m6hhwFIVn', '2024-04-04', 'male');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `usertype` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`usertype`, `email`, `password`) VALUES
('patient', 'rohit@gmail.com', '$2y$10$WwU2m6hhwFIVnfmGiim7leS9KP5iz9dGc99YSV5jGp6lIOTLrHiVi'),
('patient', 'sid@gmail.com', '$2y$10$RAKgI4w/wg5lOl4lNIpO6OJaTTOQLSpOBrUPMIUROEJuMJZ2.u9tG'),
('patient', 'tsiddhant@gmail.com', '$2y$10$R589JtpYVCn.p/6Z9pPZCuXzSNDqKVjFWrzDn9mwpZ.gWaW35nL/K');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
