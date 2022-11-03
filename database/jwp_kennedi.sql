-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2022 at 01:33 PM
-- Server version: 5.6.21
-- PHP Version: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jwp_kennedi`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_asesmen`
--

CREATE TABLE IF NOT EXISTS `tbl_asesmen` (
`id` int(11) NOT NULL,
  `ass_tanggal` int(11) NOT NULL,
  `ass_waktu` int(11) NOT NULL,
  `ass_undangan` varchar(100) NOT NULL,
  `tempat_link` text NOT NULL,
  `record_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mhs_nim` varchar(200) NOT NULL,
  `ass_wali` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_berkas`
--

CREATE TABLE IF NOT EXISTS `tbl_berkas` (
`id` int(11) NOT NULL,
  `mhs_nim` varchar(20) NOT NULL,
  `brk_sertif` varchar(200) NOT NULL,
  `brk_laporan` varchar(200) NOT NULL,
  `brk_luaran` varchar(200) NOT NULL,
  `brk_start_date` varchar(200) NOT NULL,
  `brk_end_date` varchar(200) NOT NULL,
  `brk_dokumentasi` varchar(200) NOT NULL,
  `record_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jurusan`
--

CREATE TABLE IF NOT EXISTS `tbl_jurusan` (
`id` int(11) NOT NULL,
  `jrs_kode` varchar(20) NOT NULL,
  `jrs_nama` varchar(100) NOT NULL,
  `record_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_jurusan`
--

INSERT INTO `tbl_jurusan` (`id`, `jrs_kode`, `jrs_nama`, `record_date`) VALUES
(1, '1111', 'Teknik Informatika', '2022-07-23 19:35:07');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login`
--

CREATE TABLE IF NOT EXISTS `tbl_login` (
`id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_login`
--

INSERT INTO `tbl_login` (`id`, `username`, `password`, `level`) VALUES
(8, '11111111', '25f9e794323b453885f5181f1b624d0b', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mahasiswa`
--

CREATE TABLE IF NOT EXISTS `tbl_mahasiswa` (
`id` int(11) NOT NULL,
  `mhs_nim` varchar(20) NOT NULL,
  `mhs_nama` varchar(50) NOT NULL,
  `mhs_jurusan` int(11) NOT NULL,
  `mhs_prodi` int(11) NOT NULL,
  `mhs_angkatan` int(11) NOT NULL,
  `mhs_program_ikuti` varchar(200) NOT NULL,
  `mhs_jns_mbkm` varchar(200) NOT NULL,
  `mhs_tmp_kegiatan` varchar(200) NOT NULL,
  `mhs_bukti_peneriamaan` varchar(200) NOT NULL,
  `mhs_klaim_matkul` varchar(50) NOT NULL,
  `mhs_semester` int(11) NOT NULL,
  `mhs_status` varchar(20) NOT NULL,
  `record_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Triggers `tbl_mahasiswa`
--
DELIMITER //
CREATE TRIGGER `insert_mhs_history` AFTER DELETE ON `tbl_mahasiswa`
 FOR EACH ROW INSERT INTO tbl_mahasiswa_history (mhs_nim, mhs_nama, mhs_jurusan, mhs_prodi, mhs_angkatan, mhs_program_ikuti, mhs_jns_mbkm,mhs_tmp_kegiatan, mhs_bukti_peneriamaan, mhs_klaim_matkul, mhs_semester, mhs_status) VALUES(OLD.mhs_nim, OLD.mhs_nama, OLD.mhs_jurusan, OLD.mhs_prodi, OLD.mhs_angkatan, OLD.mhs_program_ikuti, OLD.mhs_jns_mbkm,OLD.mhs_tmp_kegiatan, OLD.mhs_bukti_peneriamaan, OLD.mhs_klaim_matkul, OLD.mhs_semester, OLD.mhs_status)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mahasiswa_history`
--

CREATE TABLE IF NOT EXISTS `tbl_mahasiswa_history` (
`id` int(11) NOT NULL,
  `mhs_nim` varchar(20) NOT NULL,
  `mhs_nama` varchar(50) NOT NULL,
  `mhs_jurusan` int(11) NOT NULL,
  `mhs_prodi` int(11) NOT NULL,
  `mhs_angkatan` int(11) NOT NULL,
  `mhs_program_ikuti` varchar(200) NOT NULL,
  `mhs_jns_mbkm` varchar(200) NOT NULL,
  `mhs_tmp_kegiatan` varchar(200) NOT NULL,
  `mhs_bukti_peneriamaan` varchar(200) NOT NULL,
  `mhs_klaim_matkul` varchar(50) NOT NULL,
  `mhs_semester` int(11) NOT NULL,
  `mhs_status` varchar(20) NOT NULL,
  `record_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_matkul`
--

CREATE TABLE IF NOT EXISTS `tbl_matkul` (
`id` int(11) NOT NULL,
  `mtk_kode` varchar(20) NOT NULL,
  `mtk_name` varchar(100) NOT NULL,
  `prd_kode` varchar(20) NOT NULL,
  `mtk_semester` int(11) NOT NULL,
  `record_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_matkul`
--

INSERT INTO `tbl_matkul` (`id`, `mtk_kode`, `mtk_name`, `prd_kode`, `mtk_semester`, `record_date`) VALUES
(1, '11110101', 'Jaringan Komputer', '111101', 6, '2022-07-23 19:47:44'),
(2, '11110102', 'Pemrograman Web', '111101', 6, '2022-07-23 19:47:44'),
(3, '11110103', 'Rekayasa Perangkat Lunak', '111101', 6, '2022-07-26 19:41:39');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pegawai`
--

CREATE TABLE IF NOT EXISTS `tbl_pegawai` (
`id` int(11) NOT NULL,
  `pgw_nip` varchar(20) NOT NULL,
  `pgw_nama` varchar(50) NOT NULL,
  `pgw_app` int(11) NOT NULL,
  `pgw_jabatan` varchar(100) NOT NULL,
  `record_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pegawai`
--

INSERT INTO `tbl_pegawai` (`id`, `pgw_nip`, `pgw_nama`, `pgw_app`, `pgw_jabatan`, `record_date`) VALUES
(1, '11111111', 'User Sekretaris', 1, '4', '2022-07-24 13:02:05'),
(2, '22222222', 'User Dosen', 0, '2', '2022-07-24 13:02:05');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_prodi`
--

CREATE TABLE IF NOT EXISTS `tbl_prodi` (
`id` int(11) NOT NULL,
  `prd_kode` varchar(20) NOT NULL,
  `prd_name` varchar(100) NOT NULL,
  `jrs_kode` varchar(20) NOT NULL,
  `record_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_prodi`
--

INSERT INTO `tbl_prodi` (`id`, `prd_kode`, `prd_name`, `jrs_kode`, `record_date`) VALUES
(1, '111101', 'Teknik Informatika', '1111', '2022-07-23 19:41:19'),
(2, '111102', 'Multimedia & Jaringan', '1111', '2022-07-23 19:41:19'),
(3, '111103', 'Geomatika', '1111', '2022-07-23 21:28:31'),
(4, '111104', 'Rekayasa Keamanan Syber (RKS)', '1111', '2022-07-23 21:28:31'),
(5, '111105', 'Rekayasa Perangkat Lunak (RPL)', '1111', '2022-07-23 21:28:31'),
(6, '111106', 'Animasi', '1111', '2022-07-23 21:28:31');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE IF NOT EXISTS `tbl_roles` (
`int` int(11) NOT NULL,
  `level_name` varchar(50) NOT NULL,
  `level_alias` varchar(50) NOT NULL,
  `level_id` int(11) NOT NULL,
  `record_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`int`, `level_name`, `level_alias`, `level_id`, `record_date`) VALUES
(1, 'Mahasiswa', 'mhs', 1, '2022-07-23 04:37:20'),
(2, 'Dosen', 'dsn', 2, '2022-07-23 04:37:20'),
(3, 'Kaprodi', 'kpr', 3, '2022-07-23 04:37:20'),
(4, 'Sekretaris', 'sekre', 4, '2022-07-23 04:37:20'),
(5, 'Ketua', 'ketua', 5, '2022-07-23 04:37:20'),
(6, 'Dosen Wali', 'dsn_wl', 6, '2022-07-25 14:20:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_asesmen`
--
ALTER TABLE `tbl_asesmen`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_berkas`
--
ALTER TABLE `tbl_berkas`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `mhs_nim` (`mhs_nim`);

--
-- Indexes for table `tbl_jurusan`
--
ALTER TABLE `tbl_jurusan`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `jrs_kode` (`jrs_kode`);

--
-- Indexes for table `tbl_login`
--
ALTER TABLE `tbl_login`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `tbl_mahasiswa`
--
ALTER TABLE `tbl_mahasiswa`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `mhs_nim` (`mhs_nim`);

--
-- Indexes for table `tbl_mahasiswa_history`
--
ALTER TABLE `tbl_mahasiswa_history`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_matkul`
--
ALTER TABLE `tbl_matkul`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `mtk_kode` (`mtk_kode`);

--
-- Indexes for table `tbl_pegawai`
--
ALTER TABLE `tbl_pegawai`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_prodi`
--
ALTER TABLE `tbl_prodi`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `prd_kode` (`prd_kode`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
 ADD PRIMARY KEY (`int`), ADD UNIQUE KEY `level_id` (`level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_asesmen`
--
ALTER TABLE `tbl_asesmen`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_berkas`
--
ALTER TABLE `tbl_berkas`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_jurusan`
--
ALTER TABLE `tbl_jurusan`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_login`
--
ALTER TABLE `tbl_login`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `tbl_mahasiswa`
--
ALTER TABLE `tbl_mahasiswa`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tbl_mahasiswa_history`
--
ALTER TABLE `tbl_mahasiswa_history`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tbl_matkul`
--
ALTER TABLE `tbl_matkul`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_pegawai`
--
ALTER TABLE `tbl_pegawai`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_prodi`
--
ALTER TABLE `tbl_prodi`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
MODIFY `int` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
