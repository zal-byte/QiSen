-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2022 at 08:14 AM
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
-- Database: `qisen`
--

-- --------------------------------------------------------

--
-- Table structure for table `absen`
--

CREATE TABLE `absen` (
  `No_absen` int(11) NOT NULL,
  `NIS` char(10) NOT NULL,
  `NIK` char(16) NOT NULL,
  `Tanggal_absen` date NOT NULL,
  `Jam_absen` time NOT NULL,
  `Kelas_absen` varchar(10) NOT NULL,
  `Info_gambar` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `NIK` char(16) NOT NULL,
  `Nama` varchar(50) NOT NULL,
  `Tanggal_lahir` date NOT NULL,
  `Tempat_lahir` varchar(50) NOT NULL,
  `Alamat` text NOT NULL,
  `Jenis_kelamin` enum('l','p') NOT NULL,
  `Agama` varchar(50) NOT NULL,
  `Foto` text NOT NULL,
  `Password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `NIK` char(16) NOT NULL,
  `Nama` varchar(50) NOT NULL,
  `Tanggal_lahir` date NOT NULL,
  `Tempat_lahir` varchar(50) NOT NULL,
  `Alamat` text NOT NULL,
  `Jenis_kelamin` enum('l','p') NOT NULL,
  `Agama` varchar(50) NOT NULL,
  `Mapel` varchar(50) DEFAULT NULL,
  `Foto` text NOT NULL,
  `Password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`NIK`, `Nama`, `Tanggal_lahir`, `Tempat_lahir`, `Alamat`, `Jenis_kelamin`, `Agama`, `Mapel`, `Foto`, `Password`) VALUES
('1929391029124124', 'Irina luminesk', '2003-04-01', 'Moskow', 'Moskow, Russia.', 'p', 'Islam', NULL, 'img/user/default.jpg', 'ee4e692687d559492e04dab7216f3aa0');

-- --------------------------------------------------------

--
-- Table structure for table `informasi_gambar`
--

CREATE TABLE `informasi_gambar` (
  `Info_gambar` varchar(50) NOT NULL,
  `Tanggal_info` date NOT NULL,
  `Jam_info` time NOT NULL,
  `Lokasi_info` text DEFAULT NULL,
  `Path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `NIS` char(10) NOT NULL,
  `Nama` varchar(50) NOT NULL,
  `Tanggal_lahir` date NOT NULL,
  `Tempat_lahir` varchar(100) NOT NULL,
  `Alamat` text NOT NULL,
  `Jenis_kelamin` enum('l','p') NOT NULL,
  `Agama` varchar(50) NOT NULL,
  `Kelas` varchar(10) NOT NULL,
  `Foto` text NOT NULL,
  `Password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`NIS`, `Nama`, `Tanggal_lahir`, `Tempat_lahir`, `Alamat`, `Jenis_kelamin`, `Agama`, `Kelas`, `Foto`, `Password`) VALUES
('1001249281', 'Hotaru ichijou', '2003-04-01', 'Bandung', 'Osaka, japan.', 'p', 'Islam', 'XII RPL B', 'img/user/default.jpg', '2fd88c08e6e4911489da4178aa119ad0'),
('2123402919', 'Kuina Natsukawa', '2003-05-01', 'Shinjuku', 'Shinjuku, japan.', 'p', 'Islam', 'XII RPL B', 'img/user/default.jpg', '8cb22d66bc87e3ebb8701ff0efb8f624');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absen`
--
ALTER TABLE `absen`
  ADD PRIMARY KEY (`No_absen`),
  ADD KEY `absen_NIS_siswa_NIS` (`NIS`),
  ADD KEY `absen_NIK_guru_NIK` (`NIK`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`NIK`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`NIK`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`NIS`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absen`
--
ALTER TABLE `absen`
  MODIFY `No_absen` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absen`
--
ALTER TABLE `absen`
  ADD CONSTRAINT `absen_NIK_guru_NIK` FOREIGN KEY (`NIK`) REFERENCES `guru` (`NIK`),
  ADD CONSTRAINT `absen_NIS_siswa_NIS` FOREIGN KEY (`NIS`) REFERENCES `siswa` (`NIS`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
