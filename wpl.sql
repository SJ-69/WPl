-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2025 at 02:23 PM
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
-- Database: `wpl`
--

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE `contactus` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contactus`
--

INSERT INTO `contactus` (`id`, `name`, `email`, `subject`, `message`, `phone`, `address`, `created_at`) VALUES
(3, 'rushil khushari', 'rushil.khushari@somaiya.edu', 'Complain regarding transaction', 'I attempted to complete a payment for [product/service] from [merchant name or recipient], but the transaction was [failed/pending/charged twice/deducted but not received by the recipient]. Despite receiving a confirmation from my bank/credit card provider, the amount has not been credited to the recipient, and I have not received a refund.', NULL, NULL, '2025-02-20 12:00:48'),
(4, 'sahil jawale', 'sahil.jawale@somaiya.edu', 'Complain regarding transaction', 'HEHEHEHEHEHEHEHHEHEHEHE :3\r\n', NULL, NULL, '2025-02-20 13:05:41'),
(5, 'sahil jawale', 'sahil.jawale@somaiya.edu', 'Complain regarding transaction', 'dvawgeggeev', NULL, NULL, '2025-02-22 09:07:56'),
(6, 'sahil jawale', 'vsVASV@egg', 'AVVECAVV', 'SVSV', NULL, NULL, '2025-03-17 13:34:10'),
(7, 'sahil jawale', 'vsVASV@egg', 'AVVECAVV', 'SVSV', NULL, NULL, '2025-03-17 13:35:00'),
(8, 'sahil  jawale', 'sVASV@egg', 'ass', 'ass', NULL, NULL, '2025-03-29 08:23:37');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `receiver_phone` varchar(15) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `transaction_type` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `user_id`, `receiver_phone`, `amount`, `transaction_date`, `transaction_type`) VALUES
(20, 6, '8356045053', 5000.00, '2025-04-15 12:21:50', 'send'),
(21, 6, '8356045053', 5000.00, '2025-04-15 12:22:07', 'request');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `option_selected` varchar(50) DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `full_name`, `email`, `dob`, `phone`, `password`, `option_selected`, `registration_date`) VALUES
(4, 'sahil', 'jawale', '', 'sahil.jawale@somaiya.edu', '2025-04-25', '8356045053', '$2y$10$Ilc8YyoiHKaMqxhellpvZem21q9XIaEp5uEOM3Leym.JuNYluI.uu', 'personal', '2025-04-15 11:19:20'),
(5, 'sahil', 'jawale', '', 'swag7902@gmail.com', '2025-04-19', '8356045054', '$2y$10$isVqIuWzduMS8lxdsirW7OTQnRna/zC8i.wrJLwRhqo7CUECAhQbG', 'personal', '2025-04-15 11:21:26'),
(6, 'sahil', 'jawale', '', 's.k@somaiya.edu', '2025-04-09', '8356045056', '$2y$10$VooZoQ9LSFlPe7sgNEc1uuXc/oLnV0LyhmbhcJlgKIIa7/vBH/X3u', 'business', '2025-04-15 12:21:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `transactions_ibfk_1` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
