-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2021 at 11:11 AM
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
-- Database: `pon`
--

-- --------------------------------------------------------

--
-- Table structure for table `peserta_pons`
--

CREATE TABLE `peserta_pons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_peserta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `destinasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kontingen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cabor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_pcr` date NOT NULL,
  `tgl_keberangkatan` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `jam_keberangkatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_kendaraan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `peserta_pons`
--

INSERT INTO `peserta_pons` (`id`, `kode_peserta`, `name`, `destinasi`, `kontingen`, `cabor`, `tgl_pcr`, `tgl_keberangkatan`, `created_at`, `updated_at`, `jam_keberangkatan`, `tipe_kendaraan`, `status`) VALUES
(1, 'PRT0809210001', 'Iqbal Zaenal Mutaqin', 'Jaya Pura', 'ff', 'Canoeing', '2021-09-15', '2021-09-10', '2021-09-07 22:36:39', '2021-09-09 22:42:55', '08.00', 'Bus', 0),
(2, 'PRT0809210002', 'Iqbal Zaenal Mutaqin', 'Bandung', 'FF', 'Binaraga', '2021-09-09', '2021-09-10', '2021-09-07 23:55:18', '2021-09-07 23:55:18', '08.00', 'Bus', 0),
(4, 'PRT1009210003', 'Putri Octaviani', 'Bandung', 'FF', 'Canoeing', '2021-09-16', '2021-09-18', '2021-09-09 21:08:24', '2021-09-09 21:08:24', '08.00', 'Bus', 0),
(5, 'PRT1009210004', 'Iqbal', 'Bandung', 'FF', 'Anggar', '2021-09-10', '2021-09-10', '2021-09-09 21:09:25', '2021-09-12 20:52:59', '08.00', 'Bus', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `peserta_pons`
--
ALTER TABLE `peserta_pons`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `peserta_pons`
--
ALTER TABLE `peserta_pons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
