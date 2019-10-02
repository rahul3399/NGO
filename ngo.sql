-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2019 at 03:36 PM
-- Server version: 10.4.6-MariaDB
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
-- Database: `ngo`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `checkLogin` (IN `user_name` VARCHAR(50), IN `pass` VARCHAR(255))  READS SQL DATA
BEGIN
	SELECT `ngo`.`name` AS ngo_name, `users`.`admin_for` as ngo_id, `users`.`name` AS user_name, `users`.`is_admin` FROM `ngo` JOIN `users` ON `ngo`.`id` = `users`.`admin_for` WHERE `users`.`user_name` = user_name AND `users`.`password` = pass;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getDonationRequestes` (IN `ngo_id` INT)  READS SQL DATA
BEGIN
	SELECT `users`.`name`, `donation_request`.`goods`, `donation_request`.`quantity`, `donation_request`.`for_whom`
FROM `ngo`
LEFT JOIN `donation_request` ON `ngo`.`id` = `donation_request`.`ngo_id` 
LEFT JOIN `users` ON `ngo`.`id` = `users`.`admin_for`
WHERE `donation_request`.`status` = 'PENDING';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getFeedbacks` (IN `ngo_id` INT)  READS SQL DATA
BEGIN
	SELECT * FROM `feedback` WHERE `feedback`.`ngo_id` = ngo_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getNGOList` ()  READS SQL DATA
BEGIN
	SELECT * FROM `ngo`;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `donation_request`
--

CREATE TABLE `donation_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ngo_id` int(11) NOT NULL,
  `goods` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `for_whom` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `donation_request`
--

INSERT INTO `donation_request` (`id`, `user_id`, `ngo_id`, `goods`, `quantity`, `for_whom`, `status`) VALUES
(1, 1, 1, 'tomato', 123, 'ALL', ''),
(2, 1, 1, 'tomato', 123, 'ALL', 'PENDING');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `ngo_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ngo`
--

CREATE TABLE `ngo` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ngo`
--

INSERT INTO `ngo` (`id`, `name`, `address`, `description`) VALUES
(1, 'manav', 'pune 33', 'ngo for kids');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `address` varchar(50) DEFAULT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` int(11) NOT NULL DEFAULT 0,
  `admin_for` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `address`, `contact`, `user_name`, `password`, `is_admin`, `admin_for`) VALUES
(1, 'rahul mashere', '', '8412925599', 'rahulmashere3399@gmail.com', '12345', 0, NULL),
(2, 'rahul mashere', 'pune38', '8412925599', 'rahulmashere33991@gmail.com', '12345', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `donation_request`
--
ALTER TABLE `donation_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`),
  ADD KEY `fk_ngo1` (`ngo_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ngo` (`ngo_id`),
  ADD KEY `fk_users` (`user_id`);

--
-- Indexes for table `ngo`
--
ALTER TABLE `ngo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ngos` (`admin_for`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `donation_request`
--
ALTER TABLE `donation_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ngo`
--
ALTER TABLE `ngo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `donation_request`
--
ALTER TABLE `donation_request`
  ADD CONSTRAINT `fk_ngo1` FOREIGN KEY (`ngo_id`) REFERENCES `ngo` (`id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `fk_ngo` FOREIGN KEY (`ngo_id`) REFERENCES `ngo` (`id`),
  ADD CONSTRAINT `fk_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_ngos` FOREIGN KEY (`admin_for`) REFERENCES `ngo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
