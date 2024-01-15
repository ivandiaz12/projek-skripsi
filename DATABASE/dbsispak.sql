-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2023 at 05:23 PM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbsispak`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `ID` int(11) NOT NULL,
  `user` varchar(30) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`ID`, `user`, `pass`, `nama`) VALUES
(1, 'admin', 'admin', 'admin'),
(2, 'tati', 'admin', 'drg.Tati Muliati');

-- --------------------------------------------------------

--
-- Table structure for table `tb_gejala`
--

CREATE TABLE `tb_gejala` (
  `kode_gejala` varchar(16) NOT NULL,
  `nama_gejala` varchar(255) DEFAULT NULL,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_gejala`
--

INSERT INTO `tb_gejala` (`kode_gejala`, `nama_gejala`, `keterangan`) VALUES
('G001', 'Terjadi lekukan gigi', ''),
('G002', 'Gigi berwarna kuning', ''),
('G003', 'gigi pecah', ''),
('G004', 'Gigi sensitif', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_hasil`
--

CREATE TABLE `tb_hasil` (
  `id` int(5) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `jk` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `tgl` varchar(255) NOT NULL,
  `hasil_konsultasi` varchar(255) NOT NULL,
  `kepercayaan` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_hasil`
--

INSERT INTO `tb_hasil` (`id`, `nik`, `nama`, `no_hp`, `jk`, `alamat`, `tgl`, `hasil_konsultasi`, `kepercayaan`) VALUES
(519, '', 'tono', '08972635352', 'Laki - Laki', 'jakarta', '14:39 - 01 Desember 2023', 'gigi berlubang', '1.44'),
(522, '', 'tono', '09073689714187', 'Laki - Laki', 'jakarta', '17:19 - 03 Desember 2023', '', ''),
(520, '', 'tono', '08972635352', 'Laki - Laki', 'jakarta', '14:53 - 01 Desember 2023', '', ''),
(525, '', 'tono', '09073689714187', 'Laki - Laki', 'jakarta', '12:27 - 06 Desember 2023', 'gigi berlubang', '60'),
(518, '', 'tono', '08972635352', 'Laki - Laki', 'jakarta', '14:39 - 01 Desember 2023', '', ''),
(514, '', 'tono', '09073689714187', 'Laki - Laki', 'jakarta', '10:29 - 01 Desember 2023', '', ''),
(515, '', 'tono', '09073689714187', 'Laki - Laki', 'jakarta', '10:29 - 01 Desember 2023', 'gigi berlubang', '-64'),
(516, '', 'tono', '08972635352', 'Laki - Laki', 'jakarta', '14:26 - 01 Desember 2023', '', ''),
(523, '', 'doni', '09073689714187', 'Laki - Laki', 'jakarta', '17:20 - 03 Desember 2023', '', ''),
(524, '', 'tono', '09073689714187', 'Laki - Laki', 'jakarta', '12:27 - 06 Desember 2023', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_konsultasi`
--

CREATE TABLE `tb_konsultasi` (
  `ID` int(11) NOT NULL,
  `kode_gejala` varchar(16) DEFAULT NULL,
  `jawaban` varchar(6) DEFAULT 'Tidak'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_konsultasi`
--

INSERT INTO `tb_konsultasi` (`ID`, `kode_gejala`, `jawaban`) VALUES
(1, 'G001', 'Ya');

-- --------------------------------------------------------

--
-- Table structure for table `tb_penyakit`
--

CREATE TABLE `tb_penyakit` (
  `kode_penyakit` varchar(16) NOT NULL,
  `nama_penyakit` varchar(255) DEFAULT NULL,
  `solusi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_penyakit`
--

INSERT INTO `tb_penyakit` (`kode_penyakit`, `nama_penyakit`, `solusi`) VALUES
('P001', 'gigi berlubang', 'Segera hubungi dokter untuk penambalan gigi berlubang'),
('P002', 'Gigi Bungsu', 'Kumur dengan air hangat dan larutan garam setengah sendok teh. Apabila rasa nyeri terus berlanjut segera hubungi dokter untuk diberikan obat pereda nyeri dan penanganan lebih lanjut '),
('P003', 'Gigi Abrasi', 'Segera Hubungi dokter untuk melakukan penambalan gigi dengan bahan komposit untuk melindungi dentin sekaligus mengembalikan bentuk gigi.'),
('P004', 'Gigi Hipersensitif', 'Menajaga kebersihan gigi, menggunakan pasta gigi khusus gigi hiperensitif atau mengandung Fluoride, membersihkan gigi dengan benang gigi (dental floss)'),
('P005', 'Gingivitis (Radang Gusi) ', 'Menjaga kesehatan gigi dan mulut, segera hubungi dokter apabila kondisi semakin parah');

-- --------------------------------------------------------

--
-- Table structure for table `tb_relasi`
--

CREATE TABLE `tb_relasi` (
  `ID` int(11) NOT NULL,
  `kode_penyakit` varchar(16) DEFAULT NULL,
  `kode_gejala` varchar(16) DEFAULT NULL,
  `mb` double DEFAULT NULL,
  `md` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_relasi`
--

INSERT INTO `tb_relasi` (`ID`, `kode_penyakit`, `kode_gejala`, `mb`, `md`) VALUES
(2, 'P001', 'G001', 1, 0.4),
(3, 'P001', 'G002', 1, 0.4),
(4, 'P001', 'G003', 1, 0.8),
(14, 'P001', 'G004', 1, 0.8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tb_gejala`
--
ALTER TABLE `tb_gejala`
  ADD PRIMARY KEY (`kode_gejala`);

--
-- Indexes for table `tb_hasil`
--
ALTER TABLE `tb_hasil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_konsultasi`
--
ALTER TABLE `tb_konsultasi`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tb_penyakit`
--
ALTER TABLE `tb_penyakit`
  ADD PRIMARY KEY (`kode_penyakit`);

--
-- Indexes for table `tb_relasi`
--
ALTER TABLE `tb_relasi`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_hasil`
--
ALTER TABLE `tb_hasil`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=526;

--
-- AUTO_INCREMENT for table `tb_konsultasi`
--
ALTER TABLE `tb_konsultasi`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_relasi`
--
ALTER TABLE `tb_relasi`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
