-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 01, 2025 at 09:45 AM
-- Server version: 5.7.39
-- PHP Version: 8.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_master_hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bookings`
--

CREATE TABLE `tbl_bookings` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `checkin_date` date NOT NULL,
  `checkout_date` date NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status_id` int(11) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customers`
--

CREATE TABLE `tbl_customers` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `identity_no` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment_methods`
--

CREATE TABLE `tbl_payment_methods` (
  `id` int(11) NOT NULL,
  `method_name` varchar(100) NOT NULL,
  `admin_fee` decimal(10,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rooms`
--

CREATE TABLE `tbl_rooms` (
  `id` int(11) NOT NULL,
  `room_type` varchar(100) NOT NULL,
  `description` text,
  `capacity` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_rooms`
--

INSERT INTO `tbl_rooms` (`id`, `room_type`, `description`, `capacity`, `price`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Kamar Pink Peonish', '4 Bed, 1 Kamar Mandi', 6, '50000.00', 'room_683b30270a2a8.jpg', 'active', '2025-05-31 23:36:55', '2025-06-01 15:03:09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seasons`
--

CREATE TABLE `tbl_seasons` (
  `id` int(11) NOT NULL,
  `season_name` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `price_factor` decimal(3,2) DEFAULT '1.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff`
--

CREATE TABLE `tbl_staff` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(20) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `gender` enum('L','P') DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text,
  `birth_place` varchar(50) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_staff`
--

INSERT INTO `tbl_staff` (`id`, `staff_id`, `full_name`, `gender`, `position`, `phone`, `email`, `address`, `birth_place`, `birth_date`, `created_at`, `updated_at`) VALUES
(1, 'NRH001', 'Fahry Achmad', 'L', 'Admin', '0895322123474', 'fahry@gmail.com', 'Rajeg', 'Tangerang', '2002-02-01', '2025-06-01 14:35:14', '2025-06-01 14:42:31');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_status`
--

CREATE TABLE `tbl_status` (
  `id` int(11) NOT NULL,
  `status_name` varchar(50) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transactions`
--

CREATE TABLE `tbl_transactions` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `transaction_ref` varchar(100) DEFAULT NULL,
  `payment_status` enum('pending','paid','failed') DEFAULT 'pending',
  `gross_amount` decimal(10,2) NOT NULL,
  `admin_fee` decimal(10,2) DEFAULT '0.00',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Budi', '$2y$10$RrSQYZVRDTgKo3vtkMYB3OxtImsDswhrtbIV36jeHapYljvSJwgQy', '2025-05-31 22:29:42', '2025-05-31 22:29:42'),
(2, 'Fahry', '$2y$10$C7Rbjg2AfWqV1xHVmdByC.Bmcqry5rT/95kvRjLNv28UpRId1vhni', '2025-06-01 14:20:24', '2025-06-01 14:20:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_bookings`
--
ALTER TABLE `tbl_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_payment_methods`
--
ALTER TABLE `tbl_payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_rooms`
--
ALTER TABLE `tbl_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_seasons`
--
ALTER TABLE `tbl_seasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_id` (`staff_id`);

--
-- Indexes for table `tbl_status`
--
ALTER TABLE `tbl_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_transactions`
--
ALTER TABLE `tbl_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `payment_method_id` (`payment_method_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_bookings`
--
ALTER TABLE `tbl_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_payment_methods`
--
ALTER TABLE `tbl_payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_rooms`
--
ALTER TABLE `tbl_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_seasons`
--
ALTER TABLE `tbl_seasons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_status`
--
ALTER TABLE `tbl_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_transactions`
--
ALTER TABLE `tbl_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_bookings`
--
ALTER TABLE `tbl_bookings`
  ADD CONSTRAINT `tbl_bookings_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `tbl_customers` (`id`),
  ADD CONSTRAINT `tbl_bookings_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `tbl_rooms` (`id`),
  ADD CONSTRAINT `tbl_bookings_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `tbl_status` (`id`);

--
-- Constraints for table `tbl_transactions`
--
ALTER TABLE `tbl_transactions`
  ADD CONSTRAINT `tbl_transactions_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `tbl_bookings` (`id`),
  ADD CONSTRAINT `tbl_transactions_ibfk_2` FOREIGN KEY (`payment_method_id`) REFERENCES `tbl_payment_methods` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
