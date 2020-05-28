-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2020 at 06:53 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `seminarcalendar`
--

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL,
  `nama` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `password`, `nama`) VALUES
('F1D016078', '123', 'Ristirianto Adi'),
('F1D016077', '123', 'Bayu Ramadhan');

-- --------------------------------------------------------

--
-- Table structure for table `peserta`
--

CREATE TABLE `peserta` (
  `id_seminar` int(20) NOT NULL,
  `nim` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `peserta`
--

INSERT INTO `peserta` (`id_seminar`, `nim`) VALUES
(3, 'F1D016078');

-- --------------------------------------------------------

--
-- Table structure for table `seminar`
--

CREATE TABLE `seminar` (
  `id_seminar` int(10) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `tanggal` date NOT NULL,
  `nim` varchar(10) NOT NULL,
  `dosenPembimbing1` varchar(20) NOT NULL,
  `dosenPembimbing2` varchar(20) NOT NULL,
  `dosenPenguji1` varchar(20) NOT NULL,
  `dosenPenguji2` varchar(20) NOT NULL,
  `dosenPenguji3` varchar(20) NOT NULL,
  `status` varchar(10) NOT NULL,
  `ruangan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seminar`
--

INSERT INTO `seminar` (`id_seminar`, `judul`, `tanggal`, `nim`, `dosenPembimbing1`, `dosenPembimbing2`, `dosenPenguji1`, `dosenPenguji2`, `dosenPenguji3`, `status`, `ruangan`) VALUES
(3, 'Pengenalan Pola Tulisan Tangan Aksara Arab Menggunakan Ekstraksi Fitur Local Binary Pattern Dan Zoning Dan Klasifikasi Backpropagation Artificial Neural Network', '2020-05-26', 'F1D016077', 'Dosen 1', 'Dosen 2', 'Dosen 3', 'ABC', 'Dosen 5', 'terima', 'a3-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `seminar`
--
ALTER TABLE `seminar`
  ADD PRIMARY KEY (`id_seminar`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `seminar`
--
ALTER TABLE `seminar`
  MODIFY `id_seminar` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
