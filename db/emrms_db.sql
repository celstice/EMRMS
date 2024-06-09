-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2024 at 11:12 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cap2db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_inventory`
--

CREATE TABLE `admin_inventory` (
  `admin_inv_id` int(10) NOT NULL,
  `area` varchar(50) DEFAULT NULL,
  `ac_floor_area` varchar(50) DEFAULT NULL,
  `type_st` varchar(50) DEFAULT NULL,
  `type_wt` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `qty_st` varchar(10) DEFAULT NULL,
  `qty_wt` varchar(10) DEFAULT NULL,
  `category_st` varchar(50) DEFAULT NULL,
  `category_wt` varchar(50) DEFAULT NULL,
  `cooling_capacity` varchar(50) DEFAULT NULL,
  `capacity_rating` varchar(50) DEFAULT NULL,
  `energy_st` varchar(50) DEFAULT NULL,
  `energy_wt` varchar(50) DEFAULT NULL,
  `year_purchase` varchar(50) DEFAULT NULL,
  `operation_hours` varchar(50) DEFAULT NULL,
  `operation_days` varchar(50) DEFAULT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_inventory`
--

INSERT INTO `admin_inventory` (`admin_inv_id`, `area`, `ac_floor_area`, `type_st`, `type_wt`, `status`, `qty_st`, `qty_wt`, `category_st`, `category_wt`, `cooling_capacity`, `capacity_rating`, `energy_st`, `energy_wt`, `year_purchase`, `operation_hours`, `operation_days`, `archive`, `created`) VALUES
(1, 'Admin Bldg', 'n/a', 'Split Type', 'Window Type', 'Operational', '28', '9', 'INV', 'N-INV', '19,000', '2.0', '5.17', '9.0', '2022-08', '6', '5', 0, '2023-11-15 16:36:50'),
(2, 'COA', 'n/a', 'Split Type', '', 'Operational ', '3', '', 'INV', '', '19000', '2.0', '5.17', '', '', '6', '5', 0, '2024-01-28 17:25:45'),
(3, 'USF', 'n/a', '', 'Window Type', 'Operational ', '', '2', '', 'N-INV', '135000', '1.5', '', '10.7', '', '6', '5', 0, '2024-01-28 17:25:49'),
(4, 'RET COMPLEX', 'n/a', 'Split Type', '', 'Operational ', '12', '', 'INV', '', '24429', '2.5', '5.89', '', '', '6', '5', 1, '2024-01-28 17:25:53'),
(5, 'RET BIDANI', 'n/a', 'Split Type', 'Window Type', 'Operational ', '5', '2', 'INV', 'N-INV', '21600', '2.0', '3.64', '10.6', '', '6', '5', 0, '2024-01-28 17:25:56'),
(6, 'RET OFFICE', 'n/a', 'Split Type', 'Window Type', 'Operational ', '4', '14', 'INV', 'N-INV', '19100', '2.0', '3.64', '10.6', '', '6', '5', 0, '2024-01-28 17:26:00'),
(7, 'SCIENCE CENTRUM', 'n/a', 'Split Type', '', 'Operational ', '2', '', 'N-INV', '', '28420', '3 TR', '16.5', '', '', '6', '5', 1, '2024-01-28 17:26:03');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(10) NOT NULL,
  `category` varchar(50) NOT NULL,
  `type` int(10) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category`, `type`, `created`) VALUES
(1, 'Computers', 0, '2023-09-25 17:43:23'),
(2, 'Air Conditioners', 0, '2023-09-25 17:45:31'),
(3, 'Laptops', 0, '2023-09-25 17:45:36'),
(4, 'Electric Fans', 0, '2023-09-25 17:45:45'),
(5, 'Water Dispensers', 0, '2023-09-25 17:48:09'),
(6, 'Refrigerators', 0, '2023-09-25 17:48:41'),
(7, 'TV', 0, '2023-09-25 17:49:00'),
(8, 'Printers', 0, '2023-09-25 17:50:13'),
(9, 'Scanners', 0, '2023-09-25 17:50:18'),
(10, 'Projectors', 0, '2023-09-25 17:52:40'),
(11, 'Shredder', 0, '2023-10-18 15:13:53');

-- --------------------------------------------------------

--
-- Table structure for table `equipments`
--

CREATE TABLE `equipments` (
  `equipment_id` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `equip_name` varchar(75) NOT NULL,
  `category` varchar(25) NOT NULL,
  `equip_model` varchar(25) NOT NULL,
  `brand_label` varchar(25) NOT NULL,
  `property_number` varchar(50) NOT NULL,
  `equip_location` varchar(25) NOT NULL,
  `equip_status` varchar(25) NOT NULL,
  `date_service` date NOT NULL,
  `assigned_person` varchar(25) NOT NULL,
  `date_purchased` date NOT NULL,
  `price` varchar(10) NOT NULL,
  `notes_remarks` text DEFAULT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT 0,
  `mnt_sched` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `feedback_id` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `job_id` int(10) NOT NULL,
  `job_ctrl` varchar(20) NOT NULL,
  `feedback_number` varchar(20) NOT NULL,
  `job_service` varchar(100) NOT NULL,
  `feedback_date` date NOT NULL,
  `office` varchar(25) NOT NULL,
  `responsive1` int(10) NOT NULL,
  `responsive2` int(10) NOT NULL,
  `reliability1` int(10) NOT NULL,
  `reliability2` int(10) NOT NULL,
  `facility` int(10) NOT NULL,
  `access` int(10) NOT NULL,
  `communication1` int(10) NOT NULL,
  `communication2` int(10) NOT NULL,
  `cost1` int(10) DEFAULT NULL,
  `cost2` int(10) DEFAULT NULL,
  `integrity` int(10) NOT NULL,
  `assurance` int(10) NOT NULL,
  `outcome` int(10) NOT NULL,
  `comments` varchar(250) DEFAULT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT 0,
  `done` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `job_request`
--

CREATE TABLE `job_request` (
  `job_id` int(10) NOT NULL,
  `userID` int(100) NOT NULL,
  `job_control_number` varchar(15) DEFAULT NULL,
  `supplies_materials` text DEFAULT NULL,
  `causes` varchar(100) DEFAULT NULL,
  `assigned_personnel` varchar(100) DEFAULT NULL,
  `feedback_number` varchar(10) DEFAULT NULL,
  `job_service` varchar(200) NOT NULL,
  `requesting_official` varchar(100) NOT NULL,
  `job_location` varchar(100) NOT NULL,
  `date_requested` date NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT 0,
  `archive` tinyint(1) NOT NULL DEFAULT 0,
  `done` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_records`
--

CREATE TABLE `maintenance_records` (
  `mnt_id` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `equipment_id` int(10) NOT NULL,
  `last_mnt` date DEFAULT NULL,
  `next_mnt` date DEFAULT NULL,
  `mnt_cost` varchar(25) DEFAULT NULL,
  `mnt_description` varchar(250) DEFAULT NULL,
  `maintained_by` varchar(25) DEFAULT NULL,
  `notes_remarks` varchar(250) DEFAULT NULL,
  `done` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notif_id` int(50) NOT NULL,
  `userID` int(10) NOT NULL,
  `notif_type` varchar(50) NOT NULL,
  `notif_typeID` int(10) NOT NULL,
  `message` varchar(50) NOT NULL,
  `viewed` tinyint(1) NOT NULL DEFAULT 0,
  `notif_for` varchar(10) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `repair_records`
--

CREATE TABLE `repair_records` (
  `repair_id` int(100) NOT NULL,
  `userID` int(100) NOT NULL,
  `job_id` int(11) NOT NULL,
  `job_number` varchar(25) DEFAULT NULL,
  `repair_location` varchar(250) DEFAULT NULL,
  `repair_unit` varchar(250) DEFAULT NULL,
  `equipment_device` varchar(250) DEFAULT NULL,
  `repair_type` varchar(250) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `finish_time` time DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_finish` date DEFAULT NULL,
  `done` tinyint(1) NOT NULL DEFAULT 0,
  `archive` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `scheduled`
--

CREATE TABLE `scheduled` (
  `scheduled_id` int(100) NOT NULL,
  `userID` int(100) NOT NULL,
  `quarter` int(10) NOT NULL,
  `sched_location` varchar(250) NOT NULL,
  `rac_window_type` int(250) NOT NULL,
  `rac_split_type` int(250) NOT NULL,
  `ref_freezer` int(250) NOT NULL,
  `car_aircon` int(250) NOT NULL,
  `electric_fan` int(250) NOT NULL,
  `computer_unit` int(250) NOT NULL,
  `type_writer` int(250) NOT NULL,
  `dispenser` int(250) NOT NULL,
  `lab_equipment` int(250) NOT NULL,
  `others` int(250) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `scheduled`
--

INSERT INTO `scheduled` (`scheduled_id`, `userID`, `quarter`, `sched_location`, `rac_window_type`, `rac_split_type`, `ref_freezer`, `car_aircon`, `electric_fan`, `computer_unit`, `type_writer`, `dispenser`, `lab_equipment`, `others`, `created`) VALUES
(1, 0, 1, 'Admin BLDG / PAO / SCIENCE CENTRUM / USF / RET COMPLEX / RET BIDANI / RET OFFICE /RET TRAINING ', 52, 78, 7, 0, 38, 87, 11, 15, 0, 5, '2023-09-18 12:23:47'),
(2, 0, 2, ' RSTC / ROTC OFFICE / BAND QUATER / UBAP TAILORING / VRDEA / RMPFO / GUEST HOUSE / WRMC / UBAP / OPEN UNIVERSITY / COLLEGE OF ENGINEERING', 69, 76, 5, 10, 91, 93, 7, 13, 12, 8, '2023-09-18 12:23:47'),
(3, 0, 3, ' ICEM / NEW ISI BUILDING / DORMITORIES', 11, 103, 5, 0, 91, 118, 1, 7, 2, 7, '2023-09-18 12:23:47'),
(4, 0, 4, 'COLLEGE OF EDUCATION / COLLEGE OF VET & SCI', 58, 65, 7, 0, 147, 45, 3, 6, 5, 7, '2023-09-18 12:23:47'),
(5, 0, 1, 'CAFETERIA / CEC / HOSTEL RET / DHM / SEED STORAGE/ INFIRMARY / ALUMNI / USSG  ', 27, 93, 11, 0, 128, 44, 4, 5, 5, 4, '2023-09-18 12:23:47'),
(6, 0, 1, 'OSA / CDC GAD / EXECUTIVE HOUSE / ONT. AFFAIRS OFF. / PPSDS / MOTORPOOL / ELECTRICAL WATER WORKS / CARPENTRY / RM CARES / SEED LABORATORY / CERDS PRINTING / USHS/ DEPT. EDUC. ELEM', 62, 54, 3, 0, 42, 22, 2, 7, 3, 3, '2023-09-18 12:23:47'),
(7, 0, 2, ' ALVAREZ GYM / CLSU AREC / IGS / CTEC / CHSI / CAS MAIN SOCSCI / PYSCH / CHEM / FILIPINO ', 46, 52, 5, 0, 25, 24, 2, 6, 0, 3, '2023-09-18 12:23:47'),
(8, 0, 2, 'DEPT. OF ENVI SCIENCE / ENGLISH / DEVCOM / RADYO CLSU / FPJ BUILDING /  LIBRARY', 38, 75, 6, 0, 190, 120, 2, 12, 24, 10, '2023-09-18 12:23:47'),
(9, 0, 3, 'OFFICE OF ADMISSION / ACCREITATION / CAS ANNEX / TUKLAS LUNAS / BIOTECH ', 42, 48, 3, 0, 87, 74, 0, 8, 28, 10, '2023-09-18 12:23:47'),
(10, 0, 3, 'CBAA / SPEAR / ANIMAL SCIENCE / FLORA & FAUNA / NANOTECH / AFTBI / FEED AND GRAIN', 68, 33, 10, 0, 130, 60, 2, 10, 0, 15, '2023-09-18 12:23:47'),
(11, 0, 4, 'SRC / COLLEGE OF AGRICULTURE', 108, 22, 8, 0, 148, 88, 1, 14, 22, 5, '2023-09-18 12:23:47'),
(12, 0, 4, 'ASTS / FAC / COLLEGE OF FISHERIES / AMC / VETMED / HYDROPONIC LDR', 62, 35, 14, 0, 129, 25, 0, 8, 18, 4, '2023-09-18 12:23:47');

-- --------------------------------------------------------

--
-- Table structure for table `sched_records`
--

CREATE TABLE `sched_records` (
  `sched_id` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `job_id` int(10) DEFAULT NULL,
  `job_render` varchar(75) DEFAULT NULL,
  `render_type` int(11) DEFAULT NULL,
  `sched_render` date DEFAULT NULL,
  `date_request` date DEFAULT NULL,
  `time_request` time DEFAULT NULL,
  `job_location` varchar(25) DEFAULT NULL,
  `requesting_official` varchar(25) DEFAULT NULL,
  `end_user` varchar(30) DEFAULT NULL,
  `sched_status` tinyint(1) NOT NULL DEFAULT 0,
  `job_request` tinyint(1) NOT NULL DEFAULT 0,
  `done` tinyint(1) NOT NULL DEFAULT 0,
  `archive` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `system_logs`
--

CREATE TABLE `system_logs` (
  `log_id` int(100) NOT NULL,
  `userID` int(100) NOT NULL,
  `action_type` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(255) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(100) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `user_location` varchar(25) DEFAULT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'user',
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `firstname`, `lastname`, `email`, `username`, `password`, `verified`, `user_location`, `role`, `created`) VALUES
(1, 'Admin', 'ctrl', 'caps19.0867@gmail.com', 'admin', '$2y$10$vCgot2tyjFaeFtgFE/4bQOG6hSJQA6zrRTnp8mLW9YzJLv1eVMW4m', 1, 'ERMS', 'admin', '2023-11-17 04:11:18'),
(2, 'Haicel', 'Balite', 'youthprm1@gmail.com', 'dev-cel', '$2y$10$kxk7MvIu/vljjldDWCCduuVb2j1qItLOHFfo0ylD/BYLC1Ep5x67u', 1, 'CLIRDEC', 'user', '2024-01-28 13:39:04'),
(3, 'Angelica', 'Noveda', 'angelicanoveda01@gmail.com', 'angel-clirdec', '$2y$10$2QnLAAELbcTtdlTPgsB.D..8Hza1s0WAktFKpGwEHteuMdjanJGjm', 1, NULL, 'user', '2024-01-28 16:57:26');

-- --------------------------------------------------------

--
-- Table structure for table `user_inventory`
--

CREATE TABLE `user_inventory` (
  `inv_id` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `inv_item` varchar(100) NOT NULL,
  `property_number` varchar(50) DEFAULT NULL,
  `quantity` int(10) DEFAULT NULL,
  `price` varchar(11) DEFAULT NULL,
  `total` varchar(11) DEFAULT NULL,
  `unit` varchar(25) DEFAULT NULL,
  `area_location` varchar(50) DEFAULT NULL,
  `person` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `date_acquired` date DEFAULT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_inventory`
--
ALTER TABLE `admin_inventory`
  ADD PRIMARY KEY (`admin_inv_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `equipments`
--
ALTER TABLE `equipments`
  ADD PRIMARY KEY (`equipment_id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `job_request`
--
ALTER TABLE `job_request`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `maintenance_records`
--
ALTER TABLE `maintenance_records`
  ADD PRIMARY KEY (`mnt_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notif_id`);

--
-- Indexes for table `repair_records`
--
ALTER TABLE `repair_records`
  ADD PRIMARY KEY (`repair_id`);

--
-- Indexes for table `scheduled`
--
ALTER TABLE `scheduled`
  ADD PRIMARY KEY (`scheduled_id`);

--
-- Indexes for table `sched_records`
--
ALTER TABLE `sched_records`
  ADD PRIMARY KEY (`sched_id`);

--
-- Indexes for table `system_logs`
--
ALTER TABLE `system_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `user_inventory`
--
ALTER TABLE `user_inventory`
  ADD PRIMARY KEY (`inv_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_inventory`
--
ALTER TABLE `admin_inventory`
  MODIFY `admin_inv_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `equipments`
--
ALTER TABLE `equipments`
  MODIFY `equipment_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `feedback_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_request`
--
ALTER TABLE `job_request`
  MODIFY `job_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenance_records`
--
ALTER TABLE `maintenance_records`
  MODIFY `mnt_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notif_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `repair_records`
--
ALTER TABLE `repair_records`
  MODIFY `repair_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scheduled`
--
ALTER TABLE `scheduled`
  MODIFY `scheduled_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `sched_records`
--
ALTER TABLE `sched_records`
  MODIFY `sched_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_logs`
--
ALTER TABLE `system_logs`
  MODIFY `log_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_inventory`
--
ALTER TABLE `user_inventory`
  MODIFY `inv_id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
