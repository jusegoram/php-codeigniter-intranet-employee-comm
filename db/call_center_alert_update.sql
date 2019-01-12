-- phpMyAdmin SQL Dump
-- version 4.6.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 16, 2016 at 03:36 PM
-- Server version: 5.6.31
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `akcisinl_readycallcenter`
--

-- --------------------------------------------------------

--
-- Table structure for table `performance_scores`
--

CREATE TABLE `performance_scores` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `avaya_number` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `score_type` tinyint(1) NOT NULL COMMENT ' External Quality=>1,  Internal Quality=>2, Adherence=>3, Transfer Rate=>4, Absent=>5, Lateness=>6, Conversion Rate=>7; ',
  `score` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `performance_scores`
--

INSERT INTO `performance_scores` (`id`, `employee_id`, `name`, `avaya_number`, `date`, `score_type`, `score`) VALUES
(68, '45616', 'Naman Tamrakar', '20376', '1474502400', 1, '2'),
(70, '1212', 'navab khan', '29059', '1474502400', 1, '9'),
(73, '2525', 'HR Patil', '28910', '1474502400', 2, '1'),
(74, '2525', 'HR Patil', '36017', '1474588800', 2, '4'),
(75, '45616', 'Naman Tamrakar', '20376', '1474502400', 2, '2'),
(76, '45616', 'Naman Tamrakar', '19866', '1474675200', 2, '8'),
(77, '1212', 'navab khan', '29059', '1474502400', 2, '9'),
(78, '1212', 'navab khan', '26935', '1474588800', 2, '6'),
(79, '456', 'Roy', '26116', '1474329600', 2, '8');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `performance_scores`
--
ALTER TABLE `performance_scores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `performance_scores`
--
ALTER TABLE `performance_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
