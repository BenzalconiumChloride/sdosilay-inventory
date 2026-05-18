-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2026 at 04:18 AM
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
-- Database: `db_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `bs_setting`
--

CREATE TABLE `bs_setting` (
  `setting_id` int(10) UNSIGNED NOT NULL,
  `directory` varchar(100) NOT NULL DEFAULT '',
  `admin_dir` varchar(70) NOT NULL,
  `system_title` varchar(100) NOT NULL DEFAULT '',
  `abrv` varchar(70) NOT NULL DEFAULT '',
  `year_developed` year(4) NOT NULL,
  `description` text NOT NULL,
  `developer` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bs_setting`
--

INSERT INTO `bs_setting` (`setting_id`, `directory`, `admin_dir`, `system_title`, `abrv`, `year_developed`, `description`, `developer`, `website`) VALUES
(1001, '', '', 'sdosilay-inventory', 'SDOSI', '2026', '', 'Benz A. Lozada', 'www.tridentechnology.com');

-- --------------------------------------------------------

--
-- Table structure for table `bs_user`
--

CREATE TABLE `bs_user` (
  `user_id` int(100) UNSIGNED NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `access_level` tinyint(3) NOT NULL DEFAULT 0,
  `date_added` varchar(50) DEFAULT NULL,
  `added_by` int(11) NOT NULL DEFAULT 0,
  `date_modified` varchar(50) DEFAULT NULL,
  `modified_by` int(11) NOT NULL DEFAULT 0,
  `date_deleted` varchar(50) DEFAULT NULL,
  `deleted_by` int(11) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `last_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `uid` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bs_user`
--

INSERT INTO `bs_user` (`user_id`, `firstname`, `lastname`, `email`, `password`, `access_level`, `date_added`, `added_by`, `date_modified`, `modified_by`, `date_deleted`, `deleted_by`, `is_deleted`, `last_login`, `uid`) VALUES
(5, 'Benz', 'Lozada', 'inventory@gmail.com', '$2y$10$Ak9bkFuEtCGZPIZkF5A4rObu7yF8qh.C0LxTHaksnF5tnkkOHjdQq', 0, '2024-11-26 13:41:04', 1, NULL, 0, NULL, 0, 0, '2026-05-13 01:17:31', 'e4da3b7fbbce2345d7772b0674a318d5');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_items`
--

CREATE TABLE `tbl_items` (
  `i_id` int(100) NOT NULL,
  `i_propertyNo` varchar(100) DEFAULT NULL,
  `i_serialNo` varchar(100) DEFAULT NULL,
  `i_icsNo` varchar(100) DEFAULT NULL,
  `i_item` varchar(100) DEFAULT NULL,
  `i_description` text DEFAULT NULL,
  `i_uMeasurement` varchar(50) DEFAULT NULL,
  `i_uValue` varchar(50) DEFAULT NULL,
  `i_propertyCardNo` varchar(50) DEFAULT NULL,
  `i_physicalCountNo` varchar(50) DEFAULT NULL,
  `i_SOQuantity` varchar(20) DEFAULT NULL,
  `i_SOValue` varchar(20) DEFAULT NULL,
  `i_issuedBy` varchar(50) DEFAULT NULL,
  `i_dateReceived` varchar(20) DEFAULT NULL,
  `i_issuedTo` varchar(50) DEFAULT NULL,
  `i_dateIssued` varchar(20) DEFAULT NULL,
  `i_transaferedTo` varchar(50) DEFAULT NULL,
  `i_dateTransferred` varchar(20) DEFAULT NULL,
  `i_status` varchar(20) DEFAULT NULL,
  `i_notes` text DEFAULT NULL,
  `i_propertyType` varchar(100) DEFAULT NULL,
  `i_fundCluster` varchar(50) DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_schoolitems`
--

CREATE TABLE `tbl_schoolitems` (
  `si_id` int(100) NOT NULL,
  `s_id` int(100) DEFAULT NULL,
  `si_propertyNo` varchar(100) DEFAULT NULL,
  `si_serialNo` varchar(100) DEFAULT NULL,
  `si_icsNo` varchar(100) DEFAULT NULL,
  `si_item` varchar(100) DEFAULT NULL,
  `si_description` text DEFAULT NULL,
  `si_uMeasurement` varchar(50) DEFAULT NULL,
  `si_uValue` varchar(50) DEFAULT NULL,
  `si_propertyCardNo` int(50) DEFAULT NULL,
  `si_physicalCountNo` int(50) DEFAULT NULL,
  `si_SOQuantity` int(50) DEFAULT NULL,
  `si_SOValue` int(50) DEFAULT NULL,
  `si_issuedBy` varchar(50) DEFAULT NULL,
  `si_dateIssued` varchar(20) DEFAULT NULL,
  `si_status` varchar(20) DEFAULT NULL,
  `si_notes` text DEFAULT NULL,
  `si_propertyType` varchar(100) DEFAULT NULL,
  `si_fundCluster` varchar(50) DEFAULT NULL,
  `si_dateReceived` varchar(20) DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT 0,
  `deletedBy` varchar(50) DEFAULT NULL,
  `dateDeleted` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_schools`
--

CREATE TABLE `tbl_schools` (
  `s_id` int(50) NOT NULL,
  `s_schoolId` varchar(50) DEFAULT NULL,
  `s_schoolName` varchar(100) DEFAULT NULL,
  `s_schoolPassword` varchar(100) DEFAULT NULL,
  `s_dateCreated` varchar(20) DEFAULT NULL,
  `lastLogin` varchar(20) DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT 0,
  `date_deleted` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bs_setting`
--
ALTER TABLE `bs_setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `bs_user`
--
ALTER TABLE `bs_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_items`
--
ALTER TABLE `tbl_items`
  ADD PRIMARY KEY (`i_id`);

--
-- Indexes for table `tbl_schoolitems`
--
ALTER TABLE `tbl_schoolitems`
  ADD PRIMARY KEY (`si_id`);

--
-- Indexes for table `tbl_schools`
--
ALTER TABLE `tbl_schools`
  ADD PRIMARY KEY (`s_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bs_setting`
--
ALTER TABLE `bs_setting`
  MODIFY `setting_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1014;

--
-- AUTO_INCREMENT for table `bs_user`
--
ALTER TABLE `bs_user`
  MODIFY `user_id` int(100) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_items`
--
ALTER TABLE `tbl_items`
  MODIFY `i_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_schoolitems`
--
ALTER TABLE `tbl_schoolitems`
  MODIFY `si_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_schools`
--
ALTER TABLE `tbl_schools`
  MODIFY `s_id` int(50) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
