-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Jan 03, 2023 at 06:11 PM
-- Server version: 5.7.40
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cargo_mvc`
--

-- --------------------------------------------------------

--
-- Table structure for table `aeroplane`
--

CREATE TABLE `aeroplane` (
  `id` int(11) NOT NULL,
  `vendor` varchar(40) NOT NULL,
  `photo` varchar(200) DEFAULT NULL,
  `model` varchar(40) NOT NULL,
  `distance` int(11) DEFAULT '0',
  `payload` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aeroplane`
--

INSERT INTO `aeroplane` (`id`, `vendor`, `photo`, `model`, `distance`, `payload`) VALUES
(1, 'Airbus', 'Airbus A-330.jpg', 'A-330', 0, 70),
(2, 'Antonov', 'Anotonov An-32.jpg', 'An-32', 0, 28),
(3, 'Boeing', 'Boeing 777.jpg', '777', 0, 50),
(4, 'Boeing', 'Boeing C-40.jpg', 'C-40', 0, 30),
(5, 'CanAir', 'CanAir CL-44.jpg', 'CL-44', 0, 70),
(6, 'Casa', 'Casa CN-235.jpg', 'CN-235', 0, 25),
(7, 'Cessna', 'Cessna 150.jpg', '150', 0, 1),
(8, 'Cessna', 'Cessna 206.jpg', '206', 0, 2),
(9, 'Airbus', 'Airbus A-330.jpg', 'A-330', 0, 70),
(10, 'Antonov', 'Anotonov An-32.jpg', 'An-32', 0, 28),
(11, 'Boeing', 'Boeing 777.jpg', '777', 0, 50),
(12, 'Boeing', 'Boeing C-40.jpg', 'C-40', 0, 30),
(13, 'CanAir', 'CanAir CL-44.jpg', 'CL-44', 0, 70),
(14, 'Casa', 'Casa CN-235.jpg', 'CN-235', 0, 25),
(15, 'Cessna', 'Cessna 150.jpg', '150', 0, 1),
(16, 'Cessna', 'Cessna 206.jpg', '206', 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `aircraft`
--

CREATE TABLE `aircraft` (
  `id` int(11) NOT NULL,
  `aircraft_name` varchar(100) NOT NULL,
  `hours_done` int(11) NOT NULL,
  `in_use` tinyint(1) NOT NULL DEFAULT '0',
  `airport_base` int(11) NOT NULL,
  `aeroplane` int(11) NOT NULL,
  `distance_done` int(11) DEFAULT '0',
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aircraft`
--

INSERT INTO `aircraft` (`id`, `aircraft_name`, `hours_done`, `in_use`, `airport_base`, `aeroplane`, `distance_done`, `date_created`) VALUES
(1, 'Terra', 0, 0, 3, 1, 0, '2022-12-29 16:54:30'),
(2, 'Microship', 0, 0, 37, 15, 0, '2023-01-03 18:09:30'),
(3, 'Pride', 0, 0, 17, 12, 0, '2023-01-03 18:09:45'),
(4, 'TransAtc', 0, 0, 15, 11, 0, '2023-01-03 18:10:08');

-- --------------------------------------------------------

--
-- Table structure for table `aircraft_cargos`
--

CREATE TABLE `aircraft_cargos` (
  `id` int(11) NOT NULL,
  `aircraft_id` int(11) NOT NULL,
  `cargo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `airport`
--

CREATE TABLE `airport` (
  `id` int(11) NOT NULL,
  `code` varchar(3) NOT NULL,
  `airport_name` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `location` point NOT NULL,
  `elevation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `airport`
--

INSERT INTO `airport` (`id`, `code`, `airport_name`, `city`, `country`, `location`, `elevation`) VALUES
(1, 'LGW', 'London Gatwick Airport', 'Horley', 'United Kingdom', 0x000000000101000000a301bc05129449401f4b1fbaa0bec5bf, 202),
(2, 'ABK', 'Kabri Dar', 'Kabri Dar', 'Ethiopia', 0x000000000101000000c2c073efe1f21a407958a835cd234640, 1800),
(3, 'AGF', 'La Garenne Airport', 'Laplume', 'France', 0x000000000101000000f54a598638164640fab836548cf3e23f, 203),
(4, 'AGH', 'Angelholm Airport', 'Angelholm', 'Sweden', 0x0000000001010000000612143fc6244c405c8fc2f528bc2940, 65),
(5, 'AGL', 'Wanigela', 'Wanigela', 'Papua New Guinea', 0x000000000101000000268dd13aaaaa22c0cdcccccccca46240, 50),
(6, 'AGU', 'Aguascalientes Airport', 'Aguascalientes', 'Mexico', 0x000000000101000000bf7d1d3867b435403f355eba499459c0, 6112),
(7, 'GDN', 'Rebiechowo Airport', 'Gdansk', 'Poland', 0x0000000001010000009be61da7e8304b404e62105839743240, 489),
(8, 'GWT', 'Westerland Airport', 'Westerland', 'Germany', 0x0000000001010000003ee8d9acfa744b4028f224e99aa92040, 51),
(9, 'GWY', 'Carnmore Airport', 'Carnmore', 'Ireland', 0x0000000001010000009f3c2cd49aa64a401a6ec0e787e121c0, 90),
(10, 'GXF', 'Sayun Airport', 'Seiyun', 'Yemen', 0x000000000101000000cdccccccccec2f409487855ad3644840, 2100),
(11, 'GXG', 'Negage Airport', 'Negage', 'Angola', 0x000000000101000000302aa913d0041fc0a167b3ea73952e40, 4105),
(12, 'GYA', 'Guayaramerin Airport', 'GuayaramerÃ­n', 'Bolivia', 0x000000000101000000d656ec2fbba725c0bd5296218e5950c0, 427),
(13, 'GYD', 'Azerbaijan', 'Baku', 'Azerbaijan', 0x0000000001010000000e4faf9465304440499d8026c2e64840, 0),
(14, 'GYE', 'Simon Bolivar International Airport', 'Guayaquil', 'Ecuador', 0x0000000001010000007dd0b359f53901c0a323b9fc87f853c0, 15),
(15, 'GYL', 'Argyle Airport', 'Argyle', 'Australia', 0x000000000101000000a52c431ceba230c0ee7c3f355e0e6040, 522),
(16, 'GYM', 'General Jose Maria Yanez in Airport', 'Guaymas', 'Mexico', 0x0000000001010000002b1895d409f83b404260e5d022bb5bc0, 88),
(17, 'GYN', 'Santa Genoveva Airport', 'Goiania', 'Brazil', 0x000000000101000000371ac05b20a130c014d044d8f09c48c0, 2448),
(18, 'GZO', 'Nusatupe Airport', 'Gizo', 'Solomon Islands', 0x000000000101000000d8f0f44a592620c0b4c876be9f9a6340, 13),
(19, 'GZT', 'Gaziantep Airport', 'OÄŸuzeli', 'Turkey', 0x00000000010100000036ab3e575b794240a1d634ef38bd4240, 2313),
(20, 'HAA', 'Hasvik Airport', 'Hasvik', 'Norway', 0x0000000001010000002575029a089f51409487855ad31c3640, 25),
(21, 'HAC', 'Hachijojima Airport', 'Hachijo-machi', 'Japan', 0x000000000101000000499d8026c28e40400c022b8716796140, 303),
(22, 'HAD', 'Halmstad Airport', 'Hamstad', 'Sweden', 0x0000000001010000003a92cb7f48574c40a7e8482effa12940, 101),
(23, 'HAE', 'Havasupai', 'Havasupai', 'United States', 0x000000000101000000933a014d841d4240894160e5d02a5cc0, 0),
(24, 'HAH', 'Moroni Hahaia Airport', 'Hahaia', 'Comoros', 0x0000000001010000001c7c6132551027c0287e8cb96ba14540, 89),
(25, 'HAJ', 'Hannover International Airport', 'Langenhagen', 'Germany', 0x00000000010100000009f9a067b33a4a40dd41ec4ca1632340, 183),
(26, 'HAK', 'Haikou Airport', 'Haikou', 'China', 0x000000000101000000a1d634ef3805344083c0caa145965b40, 0),
(27, 'HAM', 'Hamburg Airport', 'Hamburg', 'Germany', 0x0000000001010000009be61da7e8d04a4052499d8026022440, 53),
(28, 'HAN', 'Noi Bai Airport', 'Hanoi', 'Vietnam', 0x000000000101000000b515fbcbee3935405c8fc2f528745a40, 26),
(29, 'HAQ', 'Hanimadu', 'Hanimaadhoo', 'Maldives', 0x0000000001010000002b1895d409081b40287e8cb96b495240, 0),
(30, 'HAS', 'Hail Airport', 'Ha\'il', 'Saudi Arabia', 0x0000000001010000001a51da1b7c713b40d5e76a2bf6d74440, 3331),
(31, 'HAU', 'Haugesund Karmoy Airport', 'Avaldsnes', 'Norway', 0x000000000101000000eb73b515fbab4d4028d53e1d8fd91440, 77),
(32, 'HEI', 'Heide-Busum Airport', 'Heide-Buesum', 'Germany', 0x000000000101000000dd24068195134b4098dd938785ca2140, 7),
(33, 'HHH', 'Hilton Head Airport', 'Hilton Head Island', 'United States', 0x00000000010100000069006f81041d404029cb10c7ba2c54c0, 20),
(34, 'HLA', 'Lanseria Airport', 'Johannesburg', 'South Africa', 0x000000000101000000e5f21fd26fef39c0cdccccccccec3b40, 4517),
(35, 'PQC', 'Duong Dong Airport', 'Kien Giang', 'Vietnam', 0x000000000101000000c364aa60547224405a643bdf4ffd5940, 23),
(36, 'PQI', 'Northern Maine Regional Airport', 'Presque Isle', 'United States', 0x000000000101000000e3c798bb965847406688635ddc0251c0, 534),
(37, 'PQQ', 'Port Macquarie Airport', 'Port Macquarie', 'Australia', 0x000000000101000000aed85f764f6e3fc0c1caa145b61b6340, 12),
(38, 'PQS', 'Pilot Station', 'Pilot Station', 'United States', 0x000000000101000000f241cf66d5f74e404e621058395c64c0, 275),
(39, 'LGW', 'London Gatwick Airport', 'Horley', 'United Kingdom', 0x000000000101000000a301bc05129449401f4b1fbaa0bec5bf, 202);

-- --------------------------------------------------------

--
-- Table structure for table `cargo`
--

CREATE TABLE `cargo` (
  `id` int(11) NOT NULL,
  `value` float NOT NULL,
  `city_from` int(11) NOT NULL,
  `city_to` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `weight` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `delivery_time` int(11) NOT NULL DEFAULT '-1',
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cargo`
--

INSERT INTO `cargo` (`id`, `value`, `city_from`, `city_to`, `status`, `weight`, `size`, `delivery_time`, `date_created`) VALUES
(1, 4439, 27, 29, 0, 1373, 973, 12, '2023-01-03 18:04:08'),
(2, 10693, 13, 3, 1, 963, 708, 52, '2023-01-03 18:04:08'),
(3, 11141, 37, 38, 0, 1278, 762, 22, '2023-01-03 18:04:08'),
(4, 7801, 6, 35, 2, 1091, 579, 40, '2022-12-14 18:04:08'),
(5, 6801, 31, 6, 0, 800, 890, 5, '2023-01-03 18:04:08'),
(6, 9941, 18, 2, 2, 1013, 1268, 58, '2023-01-03 18:04:08'),
(7, 2180, 23, 11, 0, 534, 1453, 22, '2023-01-03 18:04:08'),
(8, 9449, 1, 30, 0, 1429, 1153, 30, '2023-01-03 18:04:08'),
(9, 1768, 26, 14, 1, 863, 777, 53, '2023-01-03 18:04:08'),
(10, 2055, 10, 8, 0, 1278, 1253, 35, '2023-01-03 18:04:08'),
(11, 11452, 25, 13, 0, 520, 1495, 48, '2023-01-03 18:04:08'),
(12, 10320, 15, 12, 0, 766, 1142, 20, '2023-01-03 18:04:12'),
(13, 585, 30, 13, 2, 848, 619, 46, '2022-08-08 18:04:12'),
(14, 11348, 1, 23, 1, 1252, 1303, 59, '2023-01-03 18:04:12'),
(15, 8811, 25, 5, 0, 1421, 1253, 13, '2023-01-03 18:04:12'),
(16, 8292, 37, 34, 2, 753, 1178, 83, '2022-12-05 18:04:12'),
(17, 3536, 35, 7, 0, 917, 888, 10, '2023-01-03 18:04:12'),
(18, 9914, 38, 18, 2, 786, 530, 56, '2023-01-03 18:04:12'),
(19, 12038, 29, 31, 2, 1387, 1176, 7, '2022-09-14 18:04:12'),
(20, 8700, 17, 37, 0, 997, 1426, 13, '2023-01-03 18:04:12'),
(21, 9387, 32, 13, 0, 862, 334, 24, '2023-01-03 18:04:12'),
(22, 11736, 28, 30, 2, 948, 231, 39, '2023-01-03 18:04:12');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `owner_fname` varchar(100) NOT NULL,
  `owner_lname` varchar(100) NOT NULL,
  `street1` varchar(100) NOT NULL,
  `street2` varchar(100) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `zip_code` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `vat` varchar(100) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `customer_name`, `owner_fname`, `owner_lname`, `street1`, `street2`, `city`, `zip_code`, `country`, `vat`, `logo`, `date_created`) VALUES
(1, 'Amara', 'John', 'Malok', 'Outboard 12', '', 'London', '29A129', 'United Kingdom', '39209824', 'amara631ebe4354d4d63adc4c9306f1.png', '2022-12-29 16:48:09'),
(2, 'Asgardia', 'Repu', 'Otrinno', 'Hareque', '', 'Brussell', '23A390', 'Belgium', '9809808', 'asgardia631ebe87b2f8163adc4f946f8c.png', '2022-12-29 16:48:57'),
(3, 'Aven', 'Dirono', 'Cheovic', 'Utmerasca', '', 'Brien', '12940', 'Croatia', '8990845', 'aven631ebebda67a163adc53c6a8cf.png', '2022-12-29 16:50:04'),
(4, 'Circle', 'Atman', 'Fergusson', 'Gustaff 90', '', 'Malmo', '98065', 'Sweden', '12890478', 'circle631ebee7578e063adc58b10f67.png', '2022-12-29 16:51:23'),
(5, 'FoxHub', 'Anthony', 'Stick', 'Kalah View', '', 'Dublin', '789A89', 'Ireland', '45676548', 'fox-hub6320a719ee6c463adc5bc0c248.png', '2022-12-29 16:52:12'),
(6, 'Hexa', 'Frederick', 'Muss', 'Stuorer strasse', '', 'Hannover', '980A0', 'Germany', '1239540', 'hexa6320a74c5f48d63adc5e2b3f65.png', '2022-12-29 16:52:50'),
(7, 'Nirastate', 'Pierre', 'Torque', '32 Wolfgang strasse', '', 'Hamburg', 'WE2910', 'Germany', '119442', 'nirastate6320a77b00c3d63adc624653e3.png', '2022-12-29 16:53:56'),
(8, 'Treva', 'Buloko', 'Steonolu', 'Victoria street', 'Outer view', 'Pretoria', '29A105', 'South Africa', '789705654', 'treva6320a7bcd417863adc67fe3cc9.png', '2022-12-29 16:55:27'),
(9, 'Velocity', 'Darog', 'Herik', 'Popessa street', '', 'Biluno', '19203', 'Denmark', '987697456', 'velocity-96320a8020044563adc6a514864.png', '2022-12-29 16:56:05');

-- --------------------------------------------------------

--
-- Table structure for table `customer_cargos`
--

CREATE TABLE `customer_cargos` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `cargo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_cargos`
--

INSERT INTO `customer_cargos` (`id`, `customer_id`, `cargo_id`) VALUES
(103, 4, 1),
(104, 2, 2),
(105, 3, 3),
(106, 3, 4),
(107, 1, 5),
(108, 4, 6),
(109, 1, 7),
(110, 2, 8),
(111, 1, 9),
(112, 4, 10),
(113, 4, 11),
(114, 3, 12),
(115, 3, 13),
(116, 2, 14),
(117, 2, 15),
(118, 4, 16),
(119, 4, 17),
(120, 2, 18),
(121, 3, 19),
(122, 4, 20),
(123, 3, 21),
(124, 4, 22);

-- --------------------------------------------------------

--
-- Table structure for table `route`
--

CREATE TABLE `route` (
  `id` int(11) NOT NULL,
  `airport_from` int(11) NOT NULL,
  `airport_to` int(11) NOT NULL,
  `flying_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` mediumint(9) NOT NULL,
  `login` varchar(40) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `role`) VALUES
(1, 'admin@admin.com', '$2y$10$q5esK1IZm4KtQXXfqCI0f.egwG/9OMj/DTaaln0gTxGyqN12Qy6K6', 'ROLE_ADMIN');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aeroplane`
--
ALTER TABLE `aeroplane`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aircraft`
--
ALTER TABLE `aircraft`
  ADD PRIMARY KEY (`id`),
  ADD KEY `airport_base` (`airport_base`),
  ADD KEY `aeroplane` (`aeroplane`);

--
-- Indexes for table `aircraft_cargos`
--
ALTER TABLE `aircraft_cargos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cargo_id` (`cargo_id`),
  ADD KEY `aircraft_id` (`aircraft_id`);

--
-- Indexes for table `airport`
--
ALTER TABLE `airport`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_from` (`city_from`),
  ADD KEY `city_to` (`city_to`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_cargos`
--
ALTER TABLE `customer_cargos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `customer_cargos_ibfk_2` (`cargo_id`);

--
-- Indexes for table `route`
--
ALTER TABLE `route`
  ADD PRIMARY KEY (`id`),
  ADD KEY `airport_from` (`airport_from`),
  ADD KEY `airport_to` (`airport_to`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aeroplane`
--
ALTER TABLE `aeroplane`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `aircraft`
--
ALTER TABLE `aircraft`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `aircraft_cargos`
--
ALTER TABLE `aircraft_cargos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `airport`
--
ALTER TABLE `airport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customer_cargos`
--
ALTER TABLE `customer_cargos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `route`
--
ALTER TABLE `route`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aircraft`
--
ALTER TABLE `aircraft`
  ADD CONSTRAINT `aircraft_ibfk_1` FOREIGN KEY (`airport_base`) REFERENCES `airport` (`id`),
  ADD CONSTRAINT `aircraft_ibfk_2` FOREIGN KEY (`aeroplane`) REFERENCES `aeroplane` (`id`);

--
-- Constraints for table `aircraft_cargos`
--
ALTER TABLE `aircraft_cargos`
  ADD CONSTRAINT `aircraft_cargos_ibfk_1` FOREIGN KEY (`cargo_id`) REFERENCES `cargo` (`id`),
  ADD CONSTRAINT `aircraft_cargos_ibfk_2` FOREIGN KEY (`aircraft_id`) REFERENCES `aircraft` (`id`);

--
-- Constraints for table `cargo`
--
ALTER TABLE `cargo`
  ADD CONSTRAINT `cargo_ibfk_1` FOREIGN KEY (`city_from`) REFERENCES `airport` (`id`),
  ADD CONSTRAINT `cargo_ibfk_2` FOREIGN KEY (`city_to`) REFERENCES `airport` (`id`);

--
-- Constraints for table `customer_cargos`
--
ALTER TABLE `customer_cargos`
  ADD CONSTRAINT `customer_cargos_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `customer_cargos_ibfk_2` FOREIGN KEY (`cargo_id`) REFERENCES `cargo` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `route`
--
ALTER TABLE `route`
  ADD CONSTRAINT `route_ibfk_1` FOREIGN KEY (`airport_from`) REFERENCES `airport` (`id`),
  ADD CONSTRAINT `route_ibfk_2` FOREIGN KEY (`airport_to`) REFERENCES `airport` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
