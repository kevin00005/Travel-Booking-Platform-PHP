-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2025 at 10:13 PM
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
-- Database: `reliance_travels`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE IF NOT EXISTS `admin_login` (
  `srno` int(3) NOT NULL AUTO_INCREMENT,
  `Admin_Name` varchar(100) NOT NULL,
  `Admin_Password` varchar(100) NOT NULL,
  PRIMARY KEY (`srno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`srno`, `Admin_Name`, `Admin_Password`) VALUES
(1, 'Admin', 'Admin'),
(2, 'Tejas', 'Tejas'),
(3, 'atharva', 'atharva'),
(4, 'yash', 'Yash'),
(5, 'admin', 'admin123'),
(6, 'manager', 'manager123');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `cityid` int(4) NOT NULL AUTO_INCREMENT,
  `city` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `season` varchar(255) NOT NULL,
  `days` int(2) NOT NULL,
  `cost` int(9) NOT NULL,
  PRIMARY KEY (`cityid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`cityid`, `city`, `region`, `season`, `days`, `cost`) VALUES
(1, 'Kandy', 'Central Province', 'Year Round', 3, 25000),
(2, 'Ella', 'Uva Province', 'Year Round', 2, 18000),
(3, 'Jaffna', 'Northern Province', 'Winter', 4, 30000),
(4, 'Sigiriya', 'Central Province', 'Year Round', 2, 22000),
(5, 'Galle', 'Southern Province', 'Summer', 3, 28000),
(6, 'Colombo', 'Western Province', 'Year Round', 2, 20000),
(7, 'Nuwara Eliya', 'Central Province', 'Summer', 3, 32000),
(8, 'Anuradhapura', 'North Central Province', 'Winter', 3, 24000),
(9, 'Polonnaruwa', 'North Central Province', 'Winter', 2, 20000),
(10, 'Yala', 'Southern Province', 'Year Round', 2, 35000),
(11, 'Mirissa', 'Southern Province', 'Summer', 3, 30000),
(12, 'Bentota', 'Southern Province', 'Summer', 3, 27000),
(13, 'Chennai', 'South', 'Winter', 3, 30000),
(14, 'Ladakh', 'North', 'Summer', 7, 50000),
(15, 'Manali', 'North', 'Monsoon', 5, 35000),
(16, 'Mumbai', 'West', 'Winter', 3, 15000),
(17, 'Pune', 'West', 'Winter', 3, 15000),
(18, 'Rajasthan', 'North-West', 'Winter', 7, 40000),
(19, 'Goa', 'West', 'Summer', 3, 15000),
(20, 'Kerala', 'South', 'Monsoon', 5, 21000),
(21, 'Sikkim', 'North-East', 'Winter', 7, 55000);

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE IF NOT EXISTS `hotels` (
  `hotelid` int(11) NOT NULL AUTO_INCREMENT,
  `hotel` varchar(255) NOT NULL,
  `cityid` int(11) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `amenities` text DEFAULT NULL,
  `ratings` int(1) DEFAULT NULL,
  PRIMARY KEY (`hotelid`),
  KEY `hotels_ibfk_1` (`cityid`),
  CONSTRAINT `hotels_ibfk_1` FOREIGN KEY (`cityid`) REFERENCES `cities` (`cityid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`hotelid`, `hotel`, `cityid`, `cost`, `amenities`, `ratings`) VALUES
(1, 'Maple Hermitage', 13, 6000.00, '1. 24*7 Room Service\r\n2. Fine-Dining\r\n3. Free WiFi\r\n4. CCTV Surveillance\r\n5. Swimming Pool', 3),
(2, 'Trident', 14, 7000.00, '1. 24*7 Room Service\r\n2. Fine-Dining\r\n3. Free WiFi\r\n4. CCTV Surveillance\r\n5. Swimming Pool', 5),
(3, 'JW Marriott', 17, 7000.00, '1. 24*7 Room Service\r\n2. Fine-Dining\r\n3. Free WiFi\r\n4. CCTV Surveillance\r\n5. Swimming Pool', 5),
(4, 'The Taj', 16, 9000.00, '1. 24*7 Room Service\r\n2. Fine-Dining\r\n3. Free WiFi\r\n4. CCTV Surveillance\r\n5. Swimming Pool', 5),
(5, 'The Leela Palace', 15, 8000.00, '1. 24*7 Room Service\r\n2. Fine-Dining\r\n3. Free WiFi\r\n4. CCTV Surveillance\r\n5. Swimming Pool', 5),
(6, 'Ritz Carlton', 19, 8000.00, '1. 24*7 Room Service\r\n2. Fine-Dining\r\n3. Free WiFi\r\n4. CCTV Surveillance\r\n5. Swimming Pool', 5),
(7, 'Kohinoor', 18, 5000.00, '1. 24*7 Water Supply\r\n2. Fine-Dining\r\n3. Free WiFi\r\n4. CCTV Surveillance\r\n5. Swimming Pool', 3),
(8, 'Taj Exotica', 20, 7000.00, '1. 24*7 Room Service\r\n2. Fine-Dining\r\n3. Free WiFi\r\n4. CCTV Surveillance\r\n5. Swimming Pool', 5),
(9, 'Tunga International', 21, 7000.00, '1. 24*7 Room Service\r\n2. Fine-Dining\r\n3. Free WiFi\r\n4. CCTV Surveillance\r\n5. Great Views', 5),
(10, 'Kandy View Hotel', 1, 6500.00, '1. 24*7 Room Service\r\n2. Fine-Dining\r\n3. Free WiFi\r\n4. CCTV Surveillance\r\n5. Mountain Views', 4),
(11, 'Ella Mountain Resort', 2, 5500.00, '1. 24*7 Room Service\r\n2. Fine-Dining\r\n3. Free WiFi\r\n4. CCTV Surveillance\r\n5. Scenic Views', 4),
(12, 'Jaffna Heritage Hotel', 3, 6000.00, '1. 24*7 Room Service\r\n2. Fine-Dining\r\n3. Free WiFi\r\n4. CCTV Surveillance\r\n5. Cultural Tours', 4),
(13, 'Sigiriya Rock Hotel', 4, 7000.00, '1. 24*7 Room Service\r\n2. Fine-Dining\r\n3. Free WiFi\r\n4. CCTV Surveillance\r\n5. Historic Location', 5),
(14, 'Galle Fort Hotel', 5, 8000.00, '1. 24*7 Room Service\r\n2. Fine-Dining\r\n3. Free WiFi\r\n4. CCTV Surveillance\r\n5. Beach Access', 5),
(15, 'Colombo Grand Hotel', 6, 7500.00, '1. 24*7 Room Service\r\n2. Fine-Dining\r\n3. Free WiFi\r\n4. CCTV Surveillance\r\n5. City Center', 5),
(16, 'Nuwara Eliya Hill Resort', 7, 7200.00, '1. 24*7 Room Service\r\n2. Fine-Dining\r\n3. Free WiFi\r\n4. CCTV Surveillance\r\n5. Tea Estate Views', 4),
(17, 'Anuradhapura Ancient Hotel', 8, 5800.00, '1. 24*7 Room Service\r\n2. Fine-Dining\r\n3. Free WiFi\r\n4. CCTV Surveillance\r\n5. Historical Tours', 4),
(18, 'Polonnaruwa Heritage', 9, 5500.00, '1. 24*7 Room Service\r\n2. Fine-Dining\r\n3. Free WiFi\r\n4. CCTV Surveillance\r\n5. Cultural Heritage', 4),
(19, 'Yala Safari Lodge', 10, 9500.00, '1. 24*7 Room Service\r\n2. Fine-Dining\r\n3. Free WiFi\r\n4. CCTV Surveillance\r\n5. Wildlife Safari', 5),
(20, 'Mirissa Beach Resort', 11, 8500.00, '1. 24*7 Room Service\r\n2. Fine-Dining\r\n3. Free WiFi\r\n4. CCTV Surveillance\r\n5. Beach Front', 5),
(21, 'Bentota Beach Hotel', 12, 7800.00, '1. 24*7 Room Service\r\n2. Fine-Dining\r\n3. Free WiFi\r\n4. CCTV Surveillance\r\n5. Water Sports', 4);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `usersid` int(4) NOT NULL AUTO_INCREMENT,
  `usersEmail` varchar(128) NOT NULL,
  `usersuid` varchar(128) NOT NULL,
  `userspwd` varchar(128) NOT NULL,
  PRIMARY KEY (`usersid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`usersid`, `usersEmail`, `usersuid`, `userspwd`) VALUES
(1, 'test@test.com', 'test', '$2y$10$flekLyq.6a/gn12Xsdm0v.SZZCrx3/.Pm3M3Ucvel8MwCzReorRsq'),
(2, 'test2@test.com', 'test2', '$2y$10$uqx8Jk9IDXZ8q1x4JFPR5OYiaCKYTquxsXH6A0OM7hTXkpEKXzjJG'),
(3, 'test3@test.com', 'test3', '$2y$10$OGLEA.ETOj1DB0fRhjjuduKb4OJ75.WB5wgs5UVUBPjTMbcoUVVgy'),
(4, 'test4@test.com', 'test4', '$2y$10$ikw.LpmUCDlMTuK2qdUyNuueZOn2Zrqkg4WLEuUaqDFLYh4YjrIlC'),
(5, 'john.doe@email.com', 'johndoe', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(6, 'jane.smith@email.com', 'janesmith', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(7, 'sarah.wilson@email.com', 'sarahw', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(8, 'mike.brown@email.com', 'mikeb', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(9, 'emma.davis@email.com', 'emmad', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(10, 'david.lee@email.com', 'davidl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE IF NOT EXISTS `bookings` (
  `booking_id` int(11) NOT NULL AUTO_INCREMENT,
  `cityid` int(11) NOT NULL,
  `hotelid` int(11) DEFAULT NULL,
  `user_name` varchar(255) NOT NULL,
  `tourists` int(3) NOT NULL,
  `travel_date` date NOT NULL,
  `contact` varchar(20) NOT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  `status` varchar(20) DEFAULT 'PENDING',
  `booked_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`booking_id`),
  KEY `cityid` (`cityid`),
  KEY `hotelid` (`hotelid`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`cityid`) REFERENCES `cities` (`cityid`) ON DELETE CASCADE,
  CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`hotelid`) REFERENCES `hotels` (`hotelid`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `cityid`, `hotelid`, `user_name`, `tourists`, `travel_date`, `contact`, `total_cost`, `status`, `booked_at`) VALUES
(1, 1, 10, 'John Doe', 2, '2025-02-15', '0771234567', 50000.00, 'PAID', '2025-01-10 10:30:00'),
(2, 2, 11, 'Jane Smith', 1, '2025-02-20', '0772345678', 18000.00, 'PAID', '2025-01-11 14:20:00'),
(3, 4, 13, 'Sarah Wilson', 3, '2025-03-01', '0773456789', 66000.00, 'PAID', '2025-01-12 09:15:00'),
(4, 5, 14, 'Mike Brown', 2, '2025-03-05', '0774567890', 56000.00, 'PENDING', '2025-01-13 16:45:00'),
(5, 1, 10, 'Emma Davis', 4, '2025-03-10', '0775678901', 100000.00, 'PAID', '2025-01-14 11:30:00'),
(6, 3, 12, 'David Lee', 2, '2025-03-15', '0776789012', 60000.00, 'FAILED', '2025-01-15 13:20:00'),
(7, 7, 16, 'Lisa Anderson', 2, '2025-03-20', '0777890123', 64000.00, 'PAID', '2025-01-16 10:00:00'),
(8, 10, 19, 'Robert Taylor', 2, '2025-04-01', '0778901234', 70000.00, 'PENDING', '2025-01-17 15:30:00'),
(9, 11, 20, 'Maria Garcia', 3, '2025-04-05', '0779012345', 90000.00, 'PAID', '2025-01-18 12:45:00'),
(10, 6, 15, 'James Wilson', 1, '2025-04-10', '0770123456', 20000.00, 'PAID', '2025-01-19 09:20:00'),
(11, 2, 11, 'Susan Martinez', 2, '2025-04-15', '0771234501', 36000.00, 'PENDING', '2025-01-20 14:10:00'),
(12, 8, 17, 'Christopher Lee', 2, '2025-04-20', '0772345601', 48000.00, 'PAID', '2025-01-21 11:00:00'),
(13, 12, 21, 'Amanda White', 4, '2025-05-01', '0773456701', 108000.00, 'PAID', '2025-01-22 16:30:00'),
(14, 1, 10, 'Daniel Harris', 2, '2025-05-05', '0774567801', 50000.00, 'PENDING', '2025-01-23 10:15:00'),
(15, 5, 14, 'Jessica Clark', 3, '2025-05-10', '0775678901', 84000.00, 'PAID', '2025-01-24 13:45:00'),
(16, 9, 18, 'Matthew Lewis', 2, '2025-05-15', '0776789012', 40000.00, 'FAILED', '2025-01-25 09:30:00'),
(17, 4, 13, 'Laura Walker', 2, '2025-05-20', '0777890123', 44000.00, 'PAID', '2025-01-26 15:20:00'),
(18, 7, 16, 'Andrew Hall', 1, '2025-06-01', '0778901234', 32000.00, 'PENDING', '2025-01-27 11:10:00'),
(19, 10, 19, 'Michelle Young', 3, '2025-06-05', '0779012345', 105000.00, 'PAID', '2025-01-28 14:00:00'),
(20, 6, 15, 'Kevin King', 2, '2025-06-10', '0770123456', 40000.00, 'PAID', '2025-01-29 10:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `phone`, `message`, `created_at`) VALUES
(1, 'John Smith', 'john.smith@email.com', '0771234567', 'I am interested in booking a trip to Kandy. Can you provide more details about the packages available?', '2025-01-10 08:30:00'),
(2, 'Sarah Johnson', 'sarah.j@email.com', '0772345678', 'What is the best time to visit Ella? I am planning a trip in March.', '2025-01-11 10:15:00'),
(3, 'Michael Brown', 'michael.b@email.com', '0773456789', 'Do you offer group discounts for large bookings? We have a group of 10 people.', '2025-01-12 14:20:00'),
(4, 'Emily Davis', 'emily.d@email.com', '0774567890', 'I would like to know about hotel facilities in Sigiriya. Are there any luxury options?', '2025-01-13 09:45:00'),
(5, 'David Wilson', 'david.w@email.com', '0775678901', 'Can you customize a tour package for a 7-day trip covering multiple cities?', '2025-01-14 16:30:00'),
(6, 'Jessica Martinez', 'jessica.m@email.com', '0776789012', 'What payment methods do you accept? Is there an option for installment payments?', '2025-01-15 11:00:00'),
(7, 'Robert Taylor', 'robert.t@email.com', '0777890123', 'I am interested in wildlife tours. Do you have packages for Yala National Park?', '2025-01-16 13:25:00'),
(8, 'Lisa Anderson', 'lisa.a@email.com', '0778901234', 'What are the cancellation policies? I need flexibility due to uncertain travel plans.', '2025-01-17 10:50:00'),
(9, 'James Thompson', 'james.t@email.com', '0779012345', 'Do you provide airport pickup and drop services?', '2025-01-18 15:15:00'),
(10, 'Maria Garcia', 'maria.g@email.com', '0770123456', 'I want to book a honeymoon package. Can you suggest romantic destinations?', '2025-01-19 12:40:00'),
(11, 'Christopher Lee', 'chris.l@email.com', '0771234501', 'Are there any special discounts for senior citizens?', '2025-01-20 09:20:00'),
(12, 'Amanda White', 'amanda.w@email.com', '0772345601', 'What is included in the tour package? Are meals and transportation included?', '2025-01-21 14:55:00'),
(13, 'Daniel Harris', 'daniel.h@email.com', '0773456701', 'I am planning a family trip with children. Are there kid-friendly activities?', '2025-01-22 11:30:00'),
(14, 'Jennifer Clark', 'jennifer.c@email.com', '0774567801', 'Can you arrange for a local guide who speaks English?', '2025-01-23 16:10:00'),
(15, 'Matthew Lewis', 'matthew.l@email.com', '0775678901', 'What is the refund policy if I need to cancel my booking?', '2025-01-24 10:25:00');

--
-- Indexes for dumped tables
--

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_login`
--
ALTER TABLE `admin_login`
  MODIFY `srno` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `cityid` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `hotelid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `usersid` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
