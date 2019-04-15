-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 11, 2019 at 09:30 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sk_ums`
--

-- --------------------------------------------------------

--
-- Table structure for table `cuti`
--

CREATE TABLE `cuti` (
  `id_pcuti` varchar(12) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `id_cuti` varchar(6) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `pengganti` varchar(50) NOT NULL,
  `jumlah_cuti` int(11) NOT NULL,
  `tgl_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Proses','Approve','Ditolak','Batal') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `id_divisi` varchar(6) NOT NULL,
  `nama_divisi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`id_divisi`, `nama_divisi`) VALUES
('DV0001', 'HRD'),
('DV0002', 'Accounting'),
('DV0003', 'Marketing'),
('DV0004', 'Purchasing');

-- --------------------------------------------------------

--
-- Table structure for table `izin`
--

CREATE TABLE `izin` (
  `id_pizin` varchar(11) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `id_izin` varchar(6) NOT NULL,
  `tgl_izin` date NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `tgl_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Proses','Batal','Ditolak','Approve') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_cuti`
--

CREATE TABLE `jenis_cuti` (
  `id_cuti` varchar(6) NOT NULL,
  `nama_cuti` varchar(50) NOT NULL,
  `banyak_cuti` int(11) NOT NULL,
  `format_cuti` enum('Hari','Bulan','Tahun','') NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_cuti`
--

INSERT INTO `jenis_cuti` (`id_cuti`, `nama_cuti`, `banyak_cuti`, `format_cuti`, `keterangan`) VALUES
('C00001', 'Cuti Tahunan', 12, 'Hari', '-'),
('C00002', 'Cuti Melahirkan', 3, 'Bulan', '-');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_izin`
--

CREATE TABLE `jenis_izin` (
  `id_izin` varchar(6) NOT NULL,
  `keperluan` varchar(100) NOT NULL,
  `keterangan_izin` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_izin`
--

INSERT INTO `jenis_izin` (`id_izin`, `keperluan`, `keterangan_izin`) VALUES
('I00001', 'Dinas / Tugas Perusahaan', '-'),
('I00002', 'Pribadi - Keluar Sementara dan Kembali', '-'),
('I00003', 'Pribadi - Pulang / Tidak Kembali', '-');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `nik` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tmp_lahir` varchar(30) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `kelamin` enum('Laki-laki','Perempuan','','') NOT NULL,
  `status_kawin` enum('Kawin','Belum Kawin','','') NOT NULL,
  `pendidikan` enum('SD','SMP','SMA','S1','S2','S3','D3','SMK') NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `status_karyawan` enum('Aktif','Nonaktif','','') NOT NULL,
  `jabatan` varchar(30) NOT NULL,
  `id_divisi` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`nik`, `nama`, `tmp_lahir`, `tgl_lahir`, `kelamin`, `status_kawin`, `pendidikan`, `alamat`, `telepon`, `tgl_masuk`, `status_karyawan`, `jabatan`, `id_divisi`) VALUES
('06142', 'Haviz Indra Maulana', 'Jakarta', '1992-10-10', 'Laki-laki', 'Kawin', 'S1', 'Jl. Gg Vanilli No.19f Rt 010', '08987748441', '2019-04-06', 'Aktif', 'Administrator', 'DV0001'),
('06143', 'Dian Ratna Sari', 'Jakarta', '1995-11-27', 'Perempuan', 'Kawin', 'D3', 'Jakarta', '081355754092', '2016-10-11', 'Aktif', '', 'DV0001');

-- --------------------------------------------------------

--
-- Table structure for table `lampiran_cuti`
--

CREATE TABLE `lampiran_cuti` (
  `id_lampiran_cuti` int(11) NOT NULL,
  `id_pcuti` varchar(11) NOT NULL,
  `nama_lampiran` varchar(30) NOT NULL,
  `lampiran_cuti` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lampiran_izin`
--

CREATE TABLE `lampiran_izin` (
  `id_lampiran_izin` int(11) NOT NULL,
  `id_pizin` varchar(11) NOT NULL,
  `nama_lampiran` varchar(30) NOT NULL,
  `lampiran_izin` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id_log` bigint(20) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `id_ref` varchar(11) NOT NULL,
  `refrensi` varchar(30) NOT NULL,
  `kategori` varchar(30) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `tgl_log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id_log`, `nik`, `id_ref`, `refrensi`, `kategori`, `keterangan`, `tgl_log`) VALUES
(16, '06142', '-', 'Auth', 'Login', 'User login', '2019-04-11 19:21:49'),
(17, '06142', '-', 'Auth', 'Login', 'User login', '2019-04-11 19:22:29'),
(18, '06142', '-', 'Auth', 'Logout', 'User logout', '2019-04-11 19:23:01'),
(19, '06142', '-', 'Auth', 'Change Password', 'Mengganti password lama menjadi password baru', '2019-04-11 19:23:33'),
(20, '06142', 'DV0005', 'Divisi', 'Add', 'Menambahkan divisi baru', '2019-04-11 19:25:06'),
(21, '06142', 'DV0005', 'Divisi', 'Delete', 'Menghapus salah satu divisi', '2019-04-11 19:25:50'),
(22, '06142', '06145', 'Karyawan', 'Add', 'Menambah Karyawan Baru', '2019-04-11 19:27:32'),
(23, '06142', '06145', 'Karyawan', 'Delete', 'Menghapus data karyawan', '2019-04-11 19:28:11');

-- --------------------------------------------------------

--
-- Table structure for table `revisi_absen`
--

CREATE TABLE `revisi_absen` (
  `id_previsi` varchar(11) NOT NULL,
  `tgl_revisi` date NOT NULL,
  `tgl_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nik` varchar(20) NOT NULL,
  `alasan` varchar(50) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `jam_pulang` varchar(5) NOT NULL,
  `jam_datang` varchar(5) NOT NULL,
  `status` enum('Proses','Batal','Ditolak','Approve') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `nik` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(15) NOT NULL,
  `level` enum('Karyawan','Admin','Kabag','Direksi') NOT NULL,
  `tgl_registrasi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `foto` text NOT NULL,
  `token` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`nik`, `email`, `password`, `level`, `tgl_registrasi`, `foto`, `token`) VALUES
('06142', 'umsosella@gmail.com', 'admin', 'Admin', '2019-04-05 23:59:15', 'user.jpg', '37403280b6e8573'),
('06143', 'dianratna19@gmail.com', '06143', 'Karyawan', '2019-04-10 16:53:32', 'user.jpg', '839ce9d4eb060fd');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cuti`
--
ALTER TABLE `cuti`
  ADD PRIMARY KEY (`id_pcuti`),
  ADD KEY `nik` (`nik`),
  ADD KEY `id_cuti` (`id_cuti`);

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id_divisi`);

--
-- Indexes for table `izin`
--
ALTER TABLE `izin`
  ADD PRIMARY KEY (`id_pizin`),
  ADD KEY `nik` (`nik`),
  ADD KEY `nik_2` (`nik`),
  ADD KEY `id_izin` (`id_izin`),
  ADD KEY `id_izin_2` (`id_izin`);

--
-- Indexes for table `jenis_cuti`
--
ALTER TABLE `jenis_cuti`
  ADD PRIMARY KEY (`id_cuti`);

--
-- Indexes for table `jenis_izin`
--
ALTER TABLE `jenis_izin`
  ADD PRIMARY KEY (`id_izin`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`nik`),
  ADD KEY `divisi` (`id_divisi`);

--
-- Indexes for table `lampiran_cuti`
--
ALTER TABLE `lampiran_cuti`
  ADD PRIMARY KEY (`id_lampiran_cuti`),
  ADD KEY `id_pcuti` (`id_pcuti`);

--
-- Indexes for table `lampiran_izin`
--
ALTER TABLE `lampiran_izin`
  ADD PRIMARY KEY (`id_lampiran_izin`),
  ADD KEY `id_pizin` (`id_pizin`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_user` (`nik`),
  ADD KEY `nik` (`nik`);

--
-- Indexes for table `revisi_absen`
--
ALTER TABLE `revisi_absen`
  ADD PRIMARY KEY (`id_previsi`),
  ADD KEY `nik` (`nik`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`nik`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lampiran_cuti`
--
ALTER TABLE `lampiran_cuti`
  MODIFY `id_lampiran_cuti` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lampiran_izin`
--
ALTER TABLE `lampiran_izin`
  MODIFY `id_lampiran_izin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id_log` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cuti`
--
ALTER TABLE `cuti`
  ADD CONSTRAINT `cuti_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `karyawan` (`nik`) ON UPDATE CASCADE,
  ADD CONSTRAINT `cuti_ibfk_2` FOREIGN KEY (`id_cuti`) REFERENCES `jenis_cuti` (`id_cuti`);

--
-- Constraints for table `izin`
--
ALTER TABLE `izin`
  ADD CONSTRAINT `izin_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `karyawan` (`nik`) ON UPDATE CASCADE,
  ADD CONSTRAINT `izin_ibfk_2` FOREIGN KEY (`id_izin`) REFERENCES `jenis_izin` (`id_izin`);

--
-- Constraints for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `karyawan_ibfk_1` FOREIGN KEY (`id_divisi`) REFERENCES `divisi` (`id_divisi`);

--
-- Constraints for table `lampiran_cuti`
--
ALTER TABLE `lampiran_cuti`
  ADD CONSTRAINT `lampiran_cuti_ibfk_1` FOREIGN KEY (`id_pcuti`) REFERENCES `cuti` (`id_pcuti`);

--
-- Constraints for table `lampiran_izin`
--
ALTER TABLE `lampiran_izin`
  ADD CONSTRAINT `lampiran_izin_ibfk_1` FOREIGN KEY (`id_pizin`) REFERENCES `izin` (`id_pizin`);

--
-- Constraints for table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `user` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `revisi_absen`
--
ALTER TABLE `revisi_absen`
  ADD CONSTRAINT `revisi_absen_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `karyawan` (`nik`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `karyawan` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
