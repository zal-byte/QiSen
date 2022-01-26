-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2022 at 04:00 PM
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
-- Database: `qisen`
--

-- --------------------------------------------------------

--
-- Table structure for table `absen`
--

CREATE TABLE `absen` (
  `absen_id` int(11) NOT NULL,
  `NIS` varchar(10) DEFAULT NULL,
  `absen_tanggal` date DEFAULT NULL,
  `absen_jam` time DEFAULT NULL,
  `absen_status` enum('HADIR','SAKIT','TANPA_KETERANGAN','IZIN') DEFAULT NULL,
  `absen_keterangan` text DEFAULT NULL,
  `gambar_identifier` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `GUsername` varchar(50) DEFAULT NULL,
  `GPassword` varchar(50) DEFAULT NULL,
  `GNama` varchar(50) DEFAULT NULL,
  `GAlamat` text DEFAULT NULL,
  `GNo_hp` varchar(12) DEFAULT NULL,
  `GKelas` varchar(10) DEFAULT NULL,
  `GFoto` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`GUsername`, `GPassword`, `GNama`, `GAlamat`, `GNo_hp`, `GKelas`, `GFoto`) VALUES
('teacher1', 'teacher1', 'Teacher satu', 'Cikuya lebak', '089671149911', 'XII RPL B', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `informasi_gambar`
--

CREATE TABLE `informasi_gambar` (
  `gambar_identifier` text DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `filesize` int(11) NOT NULL,
  `device` varchar(50) DEFAULT NULL,
  `path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `NIS` varchar(10) DEFAULT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `NIS` varchar(10) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `kelas` varchar(10) DEFAULT NULL,
  `jurusan` varchar(10) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `tmpt_lahir` text DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `user_img` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`NIS`, `nama`, `kelas`, `jurusan`, `tgl_lahir`, `tmpt_lahir`, `alamat`, `user_img`) VALUES
('1000000001', 'Rizal Solehudin', 'XII B', 'RPL', '2020-02-02', 'Bandung', 'Cikuya lebak', 'img/user/default.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absen`
--
ALTER TABLE `absen`
  ADD PRIMARY KEY (`absen_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absen`
--
ALTER TABLE `absen`
  MODIFY `absen_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
