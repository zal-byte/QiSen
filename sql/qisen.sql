-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2022 at 02:20 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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

DROP TABLE IF EXISTS `absen`;
DROP TABLE IF EXISTS `guru`;
DROP TABLE IF EXISTS `siswa`;
DROP TABLE IF EXISTS `informasi_gambar`;
DROP TABLE IF EXISTS `admin`;
DROP TABLE IF EXISTS `kurikulum`;

CREATE TABLE `absen` (
  `No_absen` int(11) NOT NULL,
  `NIS` char(10) NOT NULL,
  `NIK` char(16) NOT NULL,
  `Tanggal_absen` date NOT NULL,
  `Jam_absen` time NOT NULL,
  `Kelas_absen` varchar(10) NOT NULL,
  `Info_gambar` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `Foto` text NOT NULL,
  `Password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`NIK`, `Nama`, `Tanggal_lahir`, `Tempat_lahir`, `Alamat`, `Jenis_kelamin`, `Agama`, `Foto`, `Password`) VALUES
('1234567890123456', 'Elaina', '1979-02-02', 'Osaka', 'Osaka, Japan.', 'p', 'Islam', 'img/user/default.jpg', 'aa7a3673952488f48f26ffeefdb1a362');

-- --------------------------------------------------------

--
-- Table structure for table `informasi_gambar`
--

CREATE TABLE `informasi_gambar` (
  `Info_gambar` varchar(50) NOT NULL,
  `Tanggal_info` date NOT NULL,
  `Jam_info` time NOT NULL,
  `Lokasi_info` text,
  `Path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kurikulum`
--

CREATE TABLE `kurikulum` (
  `NIK` char(16) NOT NULL,
  `Nama` varchar(50) NOT NULL,
  `Tanggal_lahir` date NOT NULL,
  `Tempat_lahir` varchar(50) NOT NULL,
  `Alamat` text NOT NULL,
  `Jenis_kelamin` enum('l','p') NOT NULL,
  `Agama` varchar(50) NOT NULL,
  `Foto` text NOT NULL,
  `Password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kurikulum`
--

INSERT INTO `kurikulum` (`NIK`, `Nama`, `Tanggal_lahir`, `Tempat_lahir`, `Alamat`, `Jenis_kelamin`, `Agama`, `Foto`, `Password`) VALUES
('1234567890123450', 'Kisaragi', '1978-02-02', 'Osaka', 'Osaka, Japan.', 'p', 'Islam', 'img/user/default.jpg', '401d7b94bd3ca49c7f6c3ff73d1afc9d');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`NIS`, `Nama`, `Tanggal_lahir`, `Tempat_lahir`, `Alamat`, `Jenis_kelamin`, `Agama`, `Kelas`, `Foto`, `Password`) VALUES
('0987654321', 'Yoshino', '2002-01-04', 'Osaka', 'Osaka, Japan.', 'p', 'Islam', 'XII RPL A', 'img/user/default.jpg', 'e4215dc8bfa377c6bdaf279515e42b21'),
('1019293019', 'Kuina natsukawa', '2003-04-02', 'Osaka', 'Osaka, Japan.', 'p', 'Islam', 'XII RPL B', 'img/user/default.jpg', '8cb22d66bc87e3ebb8701ff0efb8f624'),
('1029384756', 'Minami kitagawa', '2002-02-02', 'Osaka', 'Osaka, Japan.', 'p', 'Islam', 'XII RPL C', 'img/user/default.jpg', 'e4c15fbdf3a03d10064c58fd5fab81b2'),
('1234567890', 'Hotaru Ichijou', '2003-04-05', 'Tokyo', 'Tokyo, japan.', 'p', 'Islam', 'XII RPL B', 'img/user/default.jpg', '2fd88c08e6e4911489da4178aa119ad0'),
('1234567891', 'Tamamura', '2003-04-08', 'Shibuya', 'Shibuya, Japan.', 'p', 'Islam', 'XII RPL A', 'img/user/default.jpg', '0687b631d851a3433392bbc0a3040f26'),
('5432167890', 'Komari', '2002-01-05', 'Osaka', 'Osaka, Japan.', 'p', 'Islam', 'XII RPL C', 'img/user/default.jpg', '6e3faf1d08ea88702d27c66d0d977b86');

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
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`NIK`);

--
-- Indexes for table `kurikulum`
--
ALTER TABLE `kurikulum`
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
