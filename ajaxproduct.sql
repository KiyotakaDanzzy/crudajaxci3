-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 14, 2025 at 05:47 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ajaxproduct`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `price` decimal(20,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `created_at`) VALUES
(91, 'Soda Kue Koepoe Koepoe', 'Soda kue', '17400.00', 'bfb353c06b9fe450b6667aa1f2998417.jpeg', '2025-07-12 01:37:30'),
(92, 'Teh Celup Sosro', 'Teh teh teh', '8000.00', '60f6e7302274258e6165e4adb55a88cb.jpeg', '2025-07-12 01:38:01'),
(93, 'Saos Indofood Ekstra Pedas', 'Pedessssssss', '11500.00', 'efbc288bdab8aefd2dc98202ed41647b.jpeg', '2025-07-12 01:38:36'),
(94, 'Racik Tumis Indofood', 'Untuk tumisan', '4900.00', 'e7d2e8da6364716c282de12f2c9813b6.jpeg', '2025-07-12 01:39:12'),
(95, 'Garam Cap Kapal', 'Asinn', '4500.00', 'efc5b1ccc53e1352bfb7bd6b0176c425.jpeg', '2025-07-12 01:39:52'),
(96, 'Sun Santan Kelapa', 'Santan kelapa, bukan kepala', '4000.00', 'c7a80fa5bfc4633424a208e976fb3f7d.jpeg', '2025-07-12 01:40:21'),
(97, 'Sari Roti Gandum', 'Sari roti, roti sari roti', '18000.00', 'c063dd14f58b7ea8739b6e3e196ee229.jpeg', '2025-07-12 01:40:49'),
(98, 'Pepsodent', 'Odollllll', '6700.00', 'fc3251e7e1d4844f77e5bfa4db718b48.jpeg', '2025-07-12 01:41:17'),
(99, 'Indomie Hype Seblak Hot Jeletot', 'Hype Abisss', '4000.00', '1c8c228da2fcd2d65fecb6675b451966.jpeg', '2025-07-12 01:41:45'),
(100, 'Tropicana Slim', 'Sehat', '25000.00', '2fa19f05a442f13682b2957a8662d8f8.jpeg', '2025-07-12 01:42:04'),
(101, 'Teh Sariwangi', 'Wangi teh aslii', '6000.00', 'fa0f93aa013855bd569fac4a6176a9e5.jpeg', '2025-07-12 01:42:28'),
(102, 'Energen Kacang Hijau', 'Wenak banget', '23000.00', 'a100061405c80430f0b84eac972264cb.jpeg', '2025-07-12 01:42:54'),
(103, 'Indomilk Kemasan Ekonomis', 'Susususuususu', '17800.00', 'cf2e8efedf065bb81a5ac02fb988e9c9.jpeg', '2025-07-12 01:44:12'),
(104, 'Energen Cokelat', 'Wenak juga', '23000.00', '4c6f51f3a0dbe365bd6f17b015f933cb.jpeg', '2025-07-12 01:44:36'),
(105, 'Kecap Bango', 'Hitam Malika', '9000.00', '56fafb5e23cb2fe162165961aed1f849.jpeg', '2025-07-12 01:45:37'),
(106, 'Frisian Flag Coklat', 'Susu bendera', '6800.00', '6079a566df12263ebba86147f3489fea.jpeg', '2025-07-12 01:46:05'),
(107, 'Desaku Kunyit Bubuk', 'Bumbu untuk masak', '2000.00', 'd519b15729a4dd2f8b550591de65a025.jpeg', '2025-07-12 01:46:42'),
(108, 'Blue Band Serbaguna', 'Gatau apa', '7500.00', '6c3305ff40a80e71aeabe0e1493d4027.jpeg', '2025-07-12 01:47:11'),
(109, 'Tepung Tapioka Rose Brand', 'Tepung singkong', '11200.00', '5b8fd05179f0354be0dba8389fd62894.jpeg', '2025-07-12 01:47:43'),
(110, 'Desaku Ketumbar Bubuk', 'Bumbu buat masak', '1900.00', '08ed864fc971d54ee9ded4669c3da664.jpeg', '2025-07-12 01:48:04'),
(111, 'Sunlight Jeruk Nipis', 'Bersih kinclong', '12600.00', '1c158e954e414be46c7d21721182f118.jpeg', '2025-07-12 01:48:38'),
(112, 'Gulaku Gula premium', 'Manis premium', '22000.00', 'cee39e92a4b349b09e308e6fa93e966a.jpeg', '2025-07-12 01:49:04'),
(113, 'Kecap ABC', 'Kecap manis', '2000.00', '47adf5926993147a2ad2a479029b620b.jpeg', '2025-07-12 01:49:32'),
(114, 'Marjan Melon', 'Mantapp', '25000.00', '91df22ec9af1c4700475ecce9891af2c.jpeg', '2025-07-12 01:50:07'),
(115, 'Silver Queen', 'Cieee', '23000.00', 'e92254077ed35302e4117cc5bd64de95.jpeg', '2025-07-12 01:50:30'),
(116, 'Kuaci Rebo', 'Gacorrr', '14000.00', 'c601da22787ad6f46c3ceec4a3756844.jpeg', '2025-07-12 01:50:55'),
(117, 'Garam Dolphin', 'Lumba lumba', '6700.00', '8b67c0ed8a0d3b4a2257952650938256.jpeg', '2025-07-12 01:51:27'),
(118, 'Minyak Bimoli', 'Minyak mantap', '19000.00', '8133ed1b9ce1c2e08c2317ceb46c3263.jpeg', '2025-07-12 01:51:54'),
(119, 'Beras Sedap Wangi', 'Punelll', '51000.00', 'd0cd4e902ec93bd346124b78cc849463.jpeg', '2025-07-12 01:52:24'),
(120, 'Choki choki', 'Coklat', '16000.00', '96f3d68e53beddd84e6c46835682e745.jpeg', '2025-07-12 01:52:52'),
(121, 'Susu Ultramilk', 'Full Cream', '10000.00', '4ac225f1ced6f58a73bbce89787edfed.jpeg', '2025-07-12 01:53:20'),
(122, 'Indomilk Kids Cokelat', 'Susu coklat', '4300.00', 'bc4eb527a615f0227b06ec757b99be1a.jpeg', '2025-07-12 01:53:48'),
(124, 'Koko Krunch', 'Krunch+susu, behhhh', '31000.00', 'd93aa103cf2ad9bbec93d71797b1ee97.jpeg', '2025-07-12 01:54:50'),
(125, 'Nestle Milo', 'Enak ini susunya', '5600.00', '6099f565290d1b0d6c0749c6df46bca7.jpeg', '2025-07-12 02:03:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `role`) VALUES
(1, 'wildan', '$2y$10$iviQaQE7McjeiBO.9JsXveQJYOhPRc9.7qYfMOrqVD4Mt7wAWrHkq', 'admin'),
(11, 'user1', '$2y$10$DQ3BrjQP0//dbEouKSMRmOiT3ulztKh9.0D38rr12XpRpxwSXYhLG', 'user'),
(12, 'user2', '$2y$10$zpnGL0RfR.dgiSAGkJExiu0vg6HH4UKnuZY/87djv7YN6mLgBB6bW', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
