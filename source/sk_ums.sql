-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Jun 2019 pada 14.50
-- Versi server: 10.1.40-MariaDB
-- Versi PHP: 7.1.29

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
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id_absen` int(11) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `tgl_absen` date NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_keluar` time NOT NULL,
  `tgl_impor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `approval_absen`
--

CREATE TABLE `approval_absen` (
  `id_app_absen` int(11) NOT NULL,
  `id_previsi` varchar(12) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `keterangan` varchar(15) NOT NULL,
  `tgl_approve` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `approval_cuti`
--

CREATE TABLE `approval_cuti` (
  `id_app_cuti` int(11) NOT NULL,
  `id_pcuti` varchar(12) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `keterangan` varchar(15) NOT NULL,
  `tgl_approve` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `approval_cuti`
--

INSERT INTO `approval_cuti` (`id_app_cuti`, `id_pcuti`, `nik`, `keterangan`, `tgl_approve`) VALUES
(1, 'PCT000000010', '1703108', 'Tolak', '2019-06-24 07:47:57'),
(2, 'PCT000000011', '1703108', 'Approve 1', '2019-06-24 07:50:06'),
(3, 'PCT000000012', '1703108', 'Approve 1', '2019-06-24 11:08:57'),
(4, 'PCT000000014', '1703108', 'Approve 1', '2019-06-24 13:42:24'),
(5, 'PCT000000013', '1703108', 'Approve 1', '2019-06-24 19:31:52'),
(6, 'PCT000000014', '1234', 'Ditolak', '2019-06-25 06:22:34'),
(7, 'PCT000000013', '1234', 'Ditolak', '2019-06-25 06:29:29'),
(8, 'PCT000000012', '1234', 'Approve 2', '2019-06-25 06:35:31'),
(9, 'PCT000000011', '1234', 'Approve 2', '2019-06-25 06:42:07'),
(10, 'PCT000000015', '1703108', 'Approve 1', '2019-06-25 08:36:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `approval_izin`
--

CREATE TABLE `approval_izin` (
  `id_app_izin` int(11) NOT NULL,
  `id_pizin` varchar(12) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `keterangan` varchar(15) NOT NULL,
  `tgl_approval` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `approval_izin`
--

INSERT INTO `approval_izin` (`id_app_izin`, `id_pizin`, `nik`, `keterangan`, `tgl_approval`) VALUES
(1, 'PIZ00000007', '1234', 'Approve 1', '2019-06-25 08:42:15'),
(2, 'PIZ00000008', '1234', 'Approve 1', '2019-06-25 10:10:36'),
(3, 'PIZ00000009', '1234', 'Approve 1', '2019-06-26 08:10:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cuti`
--

CREATE TABLE `cuti` (
  `id_pcuti` varchar(12) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `id_cuti` varchar(6) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `pengganti` varchar(20) NOT NULL,
  `jumlah_cuti` int(11) NOT NULL,
  `tgl_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Proses','Approve 1','Approve 2','Approve 3','Ditolak','Batal') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `cuti`
--

INSERT INTO `cuti` (`id_pcuti`, `nik`, `id_cuti`, `tgl_mulai`, `tgl_selesai`, `alamat`, `telepon`, `pengganti`, `jumlah_cuti`, `tgl_input`, `status`) VALUES
('PCT000000004', '06143', 'C0001', '2019-06-23', '2019-06-29', 'Coba', '123123', '06143', 6, '2019-06-23 05:05:01', 'Proses'),
('PCT000000005', '06143', 'C0001', '2019-06-23', '2019-06-29', 'Coba', '123123', '06143', 7, '2019-06-23 05:05:52', 'Batal'),
('PCT000000006', '06143', 'C0001', '2019-06-28', '2019-06-29', 'Jakarta', '123123', '06143', 2, '2019-06-23 05:10:14', 'Batal'),
('PCT000000007', '06143', 'C0001', '2019-06-28', '2019-06-29', 'Jakarta', '123123123', '06143', 2, '2019-06-23 05:16:32', 'Proses'),
('PCT000000008', '06143', 'C0001', '2019-06-29', '2019-07-01', 'jalan jembatan besi 2', '08978654563225', '06143', 3, '2019-06-23 12:29:01', 'Proses'),
('PCT000000009', '1703108', 'C0002', '2019-06-27', '2019-07-01', 'Test', '123123123123', '1703108', 5, '2019-06-24 06:54:15', 'Ditolak'),
('PCT000000010', '1703108', 'C0001', '2019-06-24', '2019-06-28', 'Test', '123123', '1703108', 5, '2019-06-24 07:34:20', 'Ditolak'),
('PCT000000011', '1703108', 'C0001', '2019-06-29', '2019-06-30', 'Coba', '123123', '1703108', 2, '2019-06-24 07:49:54', 'Approve 1'),
('PCT000000012', '1703108', 'C0001', '2019-06-28', '2019-06-30', 'Test ya', '123123', '1703108', 3, '2019-06-24 08:01:32', 'Approve 2'),
('PCT000000013', '1703108', 'C0001', '2019-06-29', '2019-06-30', 'Test', '2314152', '1703108', 2, '2019-06-24 13:36:23', 'Ditolak'),
('PCT000000014', '1703108', 'C0001', '2019-06-28', '2019-06-28', 'Test', '2324532543', '1703108', 1, '2019-06-24 13:41:30', 'Ditolak'),
('PCT000000015', '1234', 'C0001', '2019-06-28', '2019-06-29', 'Test', '123123123', '1703108', 2, '2019-06-25 06:51:10', 'Approve 1'),
('PCT000000016', '1703108', 'C0001', '2019-06-29', '2019-06-30', 'qsfdscds', '12312312312', '1234', 2, '2019-06-25 14:08:34', 'Proses'),
('PCT000000017', '1234', 'C0001', '2019-06-26', '2019-06-28', 'Jakarta', '4547858', '1703108', 3, '2019-06-25 19:05:01', 'Proses'),
('PCT000000018', '06143', 'C0002', '2019-06-29', '2019-09-29', 'Test', '123123123', '5785868', 93, '2019-06-26 09:15:32', 'Proses'),
('PCT000000019', '1703108', 'C0001', '2019-08-01', '2019-08-10', 'Test', '123123', '1234', 10, '2019-06-27 06:07:46', 'Proses');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cuti_bersama`
--

CREATE TABLE `cuti_bersama` (
  `id_cuti_bersama` int(11) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `tgl_awal` date NOT NULL,
  `tgl_akhir` date NOT NULL,
  `jml_hari` int(11) NOT NULL,
  `tgl_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `divisi`
--

CREATE TABLE `divisi` (
  `id_divisi` varchar(6) NOT NULL,
  `nama_divisi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `divisi`
--

INSERT INTO `divisi` (`id_divisi`, `nama_divisi`) VALUES
('DV0001', 'HRD'),
('DV0002', 'Operational'),
('DV0003', 'finance');

-- --------------------------------------------------------

--
-- Struktur dari tabel `izin`
--

CREATE TABLE `izin` (
  `id_pizin` varchar(11) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `id_izin` varchar(6) NOT NULL,
  `tgl_izin` date NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `tgl_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Proses','Batal','Ditolak','Approve 1','Approve 2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `izin`
--

INSERT INTO `izin` (`id_pizin`, `nik`, `id_izin`, `tgl_izin`, `keterangan`, `tgl_input`, `status`) VALUES
('PIZ00000000', '06143', 'I00002', '2019-06-25', 'Coba', '2019-06-23 06:48:09', 'Batal'),
('PIZ00000001', '06143', 'I00001', '2019-06-23', 'Tugas Kampus', '2019-06-23 06:08:36', 'Batal'),
('PIZ00000002', '06143', 'I00001', '2019-06-15', 'Test', '2019-06-23 06:50:25', 'Batal'),
('PIZ00000003', '06143', 'I00002', '2019-06-22', 'Test ya', '2019-06-23 06:58:27', 'Batal'),
('PIZ00000004', '06143', 'I00003', '2019-06-22', 'Keperluan kampus pak', '2019-06-23 07:19:46', 'Proses'),
('PIZ00000005', '1703108', 'I00003', '2019-06-15', 'Coba', '2019-06-24 19:32:21', 'Ditolak'),
('PIZ00000006', '1703108', 'I00001', '2019-06-22', 'Test', '2019-06-25 08:32:12', 'Approve 2'),
('PIZ00000007', '1703108', 'I00001', '2019-06-14', 'tgvh', '2019-06-25 08:41:18', 'Approve 1'),
('PIZ00000008', '1703108', 'I00003', '2019-06-22', 'asd', '2019-06-25 10:05:47', 'Approve 1'),
('PIZ00000009', '1703108', 'I00001', '2019-06-22', 'dfgdsvcsdcvs', '2019-06-25 14:09:17', 'Ditolak'),
('PIZ00000010', '06143', 'I00001', '2019-06-01', 'asd', '2019-06-27 05:52:07', 'Proses'),
('PIZ00000011', '1703108', 'I00003', '2019-06-15', 'asdasda', '2019-06-27 06:08:03', 'Proses');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_cuti`
--

CREATE TABLE `jenis_cuti` (
  `id_cuti` varchar(6) NOT NULL,
  `nama_cuti` varchar(50) NOT NULL,
  `banyak_cuti` int(11) NOT NULL,
  `format_cuti` enum('Hari','Bulan','Tahun','') NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_cuti`
--

INSERT INTO `jenis_cuti` (`id_cuti`, `nama_cuti`, `banyak_cuti`, `format_cuti`, `keterangan`) VALUES
('C0001', 'Cuti Tahunan', 14, 'Hari', '-'),
('C0002', 'Cuti Melahirkan', 3, 'Bulan', '-');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_izin`
--

CREATE TABLE `jenis_izin` (
  `id_izin` varchar(6) NOT NULL,
  `keperluan` varchar(100) NOT NULL,
  `keterangan_izin` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_izin`
--

INSERT INTO `jenis_izin` (`id_izin`, `keperluan`, `keterangan_izin`) VALUES
('I00001', 'Dinas / Tugas Perusahaan', '-'),
('I00002', 'Pribadi - Keluar Sementara dan Kembali', '-'),
('I00003', 'Pribadi - Pulang / Tidak Kembali', '-');

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
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
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`nik`, `nama`, `tmp_lahir`, `tgl_lahir`, `kelamin`, `status_kawin`, `pendidikan`, `alamat`, `telepon`, `tgl_masuk`, `status_karyawan`, `jabatan`, `id_divisi`) VALUES
('06142', 'Haviz Indra Maulana', 'Jakarta', '1992-10-10', 'Laki-laki', 'Belum Kawin', 'S2', 'Bogor', '08987748441', '2019-04-06', 'Aktif', 'Administrator', 'DV0001'),
('06143', 'Dian Ratna Sari', 'Jakarta', '1995-11-27', 'Perempuan', 'Kawin', 'D3', 'Jakarta', '081355754092', '2016-10-11', 'Aktif', '', 'DV0001'),
('06149', 'Kalyssa IP', 'Bogor', '1995-11-20', 'Perempuan', 'Kawin', 'D3', 'Jakarta', '081355754092', '2016-10-12', 'Nonaktif', 'Staff Accounting Seniour', 'DV0001'),
('1234', 'nadigndsfda', 'aengomdsfs', '2019-04-16', 'Laki-laki', 'Kawin', 'SD', 'asdasdasd', 'asasdasda', '1992-10-10', 'Aktif', 'Coba', 'DV0003'),
('1703108', 'riska anggela', 'jakarta', '1997-07-11', 'Perempuan', 'Belum Kawin', 'SMK', 'jalan jembatan besi 2 ', '089787657643', '2017-03-12', 'Aktif', 'staff karyawan', 'DV0003'),
('173958713-9', 'Devan Dirgantara Putra', 'Jakarta', '1992-10-10', 'Laki-laki', 'Belum Kawin', 'SMA', 'Jakarta', '1285913759-13', '1992-10-10', 'Aktif', 'Manager', 'DV0002'),
('5785868', 'Muhammad Zacky Ramadhan', 'Jakarta', '1992-10-10', 'Laki-laki', 'Kawin', 'SMA', 'Jakarta', '709718061', '1992-10-10', 'Aktif', 'Operational', 'DV0001');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lampiran_cuti`
--

CREATE TABLE `lampiran_cuti` (
  `id_lampiran_cuti` int(11) NOT NULL,
  `id_pcuti` varchar(11) NOT NULL,
  `nama_lampiran` varchar(30) NOT NULL,
  `lampiran_cuti` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lampiran_izin`
--

CREATE TABLE `lampiran_izin` (
  `id_lampiran_izin` int(11) NOT NULL,
  `id_pizin` varchar(11) NOT NULL,
  `nama_lampiran` varchar(30) NOT NULL,
  `lampiran_izin` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `log`
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
-- Dumping data untuk tabel `log`
--

INSERT INTO `log` (`id_log`, `nik`, `id_ref`, `refrensi`, `kategori`, `keterangan`, `tgl_log`) VALUES
(16, '06142', '-', 'Auth', 'Login', 'User login', '2019-04-11 19:21:49'),
(17, '06142', '-', 'Auth', 'Login', 'User login', '2019-04-11 19:22:29'),
(18, '06142', '-', 'Auth', 'Logout', 'User logout', '2019-04-11 19:23:01'),
(19, '06142', '-', 'Auth', 'Change Password', 'Mengganti password lama menjadi password baru', '2019-04-11 19:23:33'),
(20, '06142', 'DV0005', 'Divisi', 'Add', 'Menambahkan divisi baru', '2019-04-11 19:25:06'),
(21, '06142', 'DV0005', 'Divisi', 'Delete', 'Menghapus salah satu divisi', '2019-04-11 19:25:50'),
(22, '06142', '06145', 'Karyawan', 'Add', 'Menambah Karyawan Baru', '2019-04-11 19:27:32'),
(23, '06142', '06145', 'Karyawan', 'Delete', 'Menghapus data karyawan', '2019-04-11 19:28:11'),
(24, '06142', '-', 'Auth', 'Login', 'User login', '2019-04-16 03:53:41'),
(25, '06142', '-', 'Auth', 'Login', 'User login', '2019-04-16 04:34:04'),
(26, '06142', '-', 'Auth', 'Login', 'User login', '2019-04-16 05:11:06'),
(27, '06142', 'DV0002', 'Divisi', 'Delete', 'Menghapus salah satu divisi', '2019-04-16 07:46:13'),
(28, '06142', 'DV0003', 'Divisi', 'Delete', 'Menghapus salah satu divisi', '2019-04-16 07:46:33'),
(29, '06142', 'DV0004', 'Divisi', 'Delete', 'Menghapus salah satu divisi', '2019-04-16 07:46:35'),
(30, '06142', 'DV0002', 'Divisi', 'Delete', 'Menghapus salah satu divisi', '2019-04-16 07:46:40'),
(31, '06142', 'DV0003', 'Divisi', 'Delete', 'Menghapus salah satu divisi', '2019-04-16 07:46:54'),
(32, '06142', 'DV0002', 'Divisi', 'Delete', 'Menghapus salah satu divisi', '2019-04-16 07:46:57'),
(33, '06142', 'DV0002', 'Divisi', 'Add', 'Menambahkan divisi baru', '2019-04-16 07:59:54'),
(34, '06142', 'DV0003', 'Divisi', 'Add', 'Menambahkan divisi baru', '2019-04-16 08:00:23'),
(35, '06142', 'DV0002', 'Divisi', 'Delete', 'Menghapus salah satu divisi', '2019-04-16 08:00:30'),
(36, '06142', 'DV0004', 'Divisi', 'Add', 'Menambahkan divisi baru', '2019-04-16 08:02:04'),
(37, '06142', 'DV0003', 'Divisi', 'Delete', 'Menghapus salah satu divisi', '2019-04-16 08:02:14'),
(38, '06142', 'DV0004', 'Divisi', 'Delete', 'Menghapus salah satu divisi', '2019-04-16 08:02:18'),
(39, '06142', 'DV0002', 'Divisi', 'Add', 'Menambahkan divisi baru', '2019-04-16 08:03:26'),
(40, '06142', 'DV0002', 'Divisi', 'Delete', 'Menghapus salah satu divisi', '2019-04-16 08:03:40'),
(41, '06142', 'DV0002', 'Divisi', 'Add', 'Menambahkan divisi baru', '2019-04-16 08:03:56'),
(42, '06142', 'DV0002', 'Divisi', 'Delete', 'Menghapus salah satu divisi', '2019-04-16 08:04:14'),
(43, '06142', 'DV0002', 'Divisi', 'Add', 'Menambahkan divisi baru', '2019-04-16 08:05:31'),
(44, '06142', 'DV0002', 'Divisi', 'Delete', 'Menghapus salah satu divisi', '2019-04-16 08:05:34'),
(45, '06142', 'DV0002', 'Divisi', 'Delete', 'Menghapus salah satu divisi', '2019-04-16 08:05:37'),
(46, '06142', 'DV0002', 'Divisi', 'Add', 'Menambahkan divisi baru', '2019-04-16 08:07:00'),
(47, '06142', 'DV0002', 'Divisi', 'Delete', 'Menghapus salah satu divisi', '2019-04-16 08:07:11'),
(48, '06142', 'DV0002', 'Divisi', 'Add', 'Menambahkan divisi baru', '2019-04-16 08:12:27'),
(49, '06142', '06149', 'Karyawan', 'Add', 'Menambah Karyawan Baru', '2019-04-16 08:19:07'),
(50, '06142', '173958713-9', 'Karyawan', 'Add', 'Menambah Karyawan Baru', '2019-04-16 08:36:41'),
(51, '06142', 'DV0003', 'Divisi', 'Add', 'Menambahkan divisi baru', '2019-04-16 12:13:31'),
(52, '06142', 'DV0003', 'Divisi', 'Delete', 'Menghapus salah satu divisi', '2019-04-16 12:13:40'),
(53, '06142', 'DV0003', 'Divisi', 'Delete', 'Menghapus salah satu divisi', '2019-04-16 12:13:42'),
(54, '06142', 'nagondsogms', 'Karyawan', 'Add', 'Menambah Karyawan Baru', '2019-04-16 12:14:25'),
(55, '06142', '5785868', 'Karyawan', 'Add', 'Menambah Karyawan Baru', '2019-04-16 14:01:55'),
(56, '06142', 'IZ0004', 'Jenis Izin', 'Add', 'Menambahkan jenis izin baru', '2019-04-17 15:34:25'),
(57, '06142', 'CT0003', 'Jenis Cuti', 'Add', 'Menambahkan jenis cuti baru', '2019-04-17 15:36:56'),
(58, '06142', 'IZ0004', 'Jenis Izin', 'Delete', 'Menghapus salah satu jenis izin', '2019-04-17 15:49:34'),
(59, '06142', 'CT0003', 'Jenis Cuti', 'Delete', 'Menghapus salah satu jenis cuti', '2019-04-17 15:53:33'),
(60, '06142', '-', 'Auth', 'Login', 'User login', '2019-04-18 18:46:28'),
(61, '06142', 'I0004', 'Jenis Izin', 'Add', 'Menambahkan jenis izin baru', '2019-04-18 18:47:29'),
(62, '06142', 'I0004', 'Jenis Izin', 'Delete', 'Menghapus salah satu jenis izin', '2019-04-18 18:47:45'),
(63, '06142', 'C0003', 'Jenis Cuti', 'Add', 'Menambahkan jenis cuti baru', '2019-04-18 18:48:12'),
(64, '06142', '-', 'Auth', 'Logout', 'User logout', '2019-04-18 18:49:25'),
(65, '06142', '06149', 'Karyawan', 'Edit', 'Mengirim Karyawan Baru', '2019-04-20 12:18:44'),
(66, '06142', '06142', 'User', 'Edit', 'Mengedit Profile Karyawan', '2019-04-20 13:02:39'),
(67, '06142', '06142', 'User', 'Edit', 'Mengedit Profile Karyawan', '2019-04-20 13:03:40'),
(68, '06142', '-', 'Auth', 'Login', 'User login', '2019-04-27 16:37:56'),
(69, '06142', '-', 'Auth', 'Login', 'User login', '2019-06-16 02:52:17'),
(70, '06142', 'C0003', 'Jenis Cuti', 'Delete', 'Menghapus salah satu jenis cuti', '2019-06-16 03:05:40'),
(71, '06142', 'C00001', 'Jenis Cuti', 'Delete', 'Menghapus salah satu jenis cuti', '2019-06-16 03:06:34'),
(72, '06142', 'C00002', 'Jenis Cuti', 'Delete', 'Menghapus salah satu jenis cuti', '2019-06-16 03:06:56'),
(73, '06142', 'C0001', 'Jenis Cuti', 'Add', 'Menambahkan jenis cuti baru', '2019-06-16 03:07:25'),
(74, '06142', 'C0002', 'Jenis Cuti', 'Add', 'Menambahkan jenis cuti baru', '2019-06-16 03:08:23'),
(75, '06142', '-', 'Auth', 'Logout', 'User logout', '2019-06-16 03:09:05'),
(76, '06143', '-', 'Auth', 'Login', 'User login', '2019-06-16 06:00:48'),
(77, '06142', '-', 'Auth', 'Login', 'User login', '2019-06-20 16:51:18'),
(78, '06142', '-', 'Auth', 'Logout', 'User logout', '2019-06-20 16:53:32'),
(79, '06142', '-', 'Auth', 'Login', 'User login', '2019-06-21 03:38:57'),
(80, '06142', '-', 'Auth', 'Logout', 'User logout', '2019-06-21 04:01:43'),
(81, '06143', '-', 'Auth', 'Login', 'User login', '2019-06-21 04:02:27'),
(82, '06143', 'PCT00000000', 'Cuti', 'Add', 'Menambahkan cuti baru', '2019-06-22 10:37:11'),
(83, '06143', '-', 'Auth', 'Logout', 'User logout', '2019-06-22 11:31:38'),
(84, '06143', '-', 'Auth', 'Login', 'User login', '2019-06-22 11:31:45'),
(85, '06143', '-', 'Auth', 'Login', 'User login', '2019-06-22 11:32:10'),
(86, '06143', 'PCT00000000', 'Cuti', 'Add', 'Menambahkan cuti baru', '2019-06-22 18:04:13'),
(87, '06143', 'PCT00000000', 'Cuti', 'Add', 'Menambahkan cuti baru', '2019-06-22 18:07:17'),
(88, '06143', 'PCT00000000', 'Cuti', 'Add', 'Menambahkan cuti baru', '2019-06-22 18:10:34'),
(89, '06143', 'PCT00000000', 'Cuti', 'Add', 'Menambahkan cuti baru', '2019-06-23 05:05:01'),
(90, '06143', 'PCT00000000', 'Cuti', 'Add', 'Menambahkan cuti baru', '2019-06-23 05:05:52'),
(91, '06143', 'PCT00000000', 'Cuti', 'Add', 'Menambahkan cuti baru', '2019-06-23 05:10:14'),
(92, '06143', 'PCT00000000', 'Cuti', 'Add', 'Menambahkan cuti baru', '2019-06-23 05:16:32'),
(93, '06143', 'PCT00000000', 'Cuti', 'Edit', 'Menambahkan cuti baru', '2019-06-23 05:26:58'),
(94, '06143', 'PCT00000000', 'Divisi', 'Batalkan', 'Menghapus salah satu divisi', '2019-06-23 05:38:35'),
(95, '06143', 'PCT00000000', 'Divisi', 'Batalkan', 'Menghapus salah satu divisi', '2019-06-23 05:38:59'),
(96, '06143', 'PIZ00000000', 'Izin', 'Add', 'Menambahkan izin baru', '2019-06-23 06:48:09'),
(97, '06143', 'PIZ00000002', 'Izin', 'Add', 'Menambahkan izin baru', '2019-06-23 06:50:25'),
(98, '06143', 'PIZ00000002', 'Cuti', 'Batalkan', 'Membatalkan Izin', '2019-06-23 06:57:28'),
(99, '06143', 'PIZ00000001', 'Cuti', 'Batalkan', 'Membatalkan Izin', '2019-06-23 06:57:34'),
(100, '06143', 'PIZ00000000', 'Cuti', 'Batalkan', 'Membatalkan Izin', '2019-06-23 06:57:40'),
(101, '06143', 'PIZ00000003', 'Izin', 'Add', 'Menambahkan izin baru', '2019-06-23 06:58:27'),
(102, '06143', 'PIZ00000003', 'Cuti', 'Edit', 'Mengedit Cuti Baru', '2019-06-23 07:18:49'),
(103, '06143', 'PIZ00000003', 'Cuti', 'Batalkan', 'Membatalkan Izin', '2019-06-23 07:19:25'),
(104, '06143', 'PIZ00000004', 'Izin', 'Add', 'Menambahkan izin baru', '2019-06-23 07:19:46'),
(105, '06143', 'PIZ00000004', 'Cuti', 'Edit', 'Mengedit Cuti Baru', '2019-06-23 07:20:02'),
(106, '06143', 'PRA00000002', 'Revisi Absen', 'Add', 'Menambahkan revisi absen baru', '2019-06-23 08:18:40'),
(107, '06143', 'PRA00000002', 'Cuti', 'Batalkan', 'Membatalkan Izin', '2019-06-23 08:35:11'),
(108, '06143', 'PRA00000001', 'Cuti', 'Batalkan', 'Membatalkan Izin', '2019-06-23 08:35:48'),
(109, '06143', 'PCT00000000', 'Cuti', 'Add', 'Menambahkan cuti baru', '2019-06-23 12:29:01'),
(110, '06143', '-', 'Auth', 'Logout', 'User logout', '2019-06-23 12:31:05'),
(111, '06142', '-', 'Auth', 'Login', 'User login', '2019-06-23 12:32:03'),
(112, '06142', 'DV0003', 'Divisi', 'Add', 'Menambahkan divisi baru', '2019-06-23 12:42:01'),
(113, '06142', '1703108', 'Karyawan', 'Add', 'Menambah Karyawan Baru', '2019-06-23 12:44:36'),
(114, '06142', '-', 'Auth', 'Logout', 'User logout', '2019-06-23 12:45:05'),
(115, '1703108', '-', 'Auth', 'Login', 'User login', '2019-06-23 12:45:46'),
(116, '1703108', '-', 'Auth', 'Login', 'User login', '2019-06-23 12:46:29'),
(117, '1703108', 'PRA00000003', 'Revisi Absen', 'Add', 'Menambahkan revisi absen baru', '2019-06-24 03:36:24'),
(118, '1703108', 'PRA00000003', 'Cuti', 'Edit', 'Mengedit Revisi Absen Baru', '2019-06-24 05:58:02'),
(119, '1703108', 'PRA00000003', 'Cuti', 'Edit', 'Mengedit Revisi Absen Baru', '2019-06-24 05:58:09'),
(120, '1703108', 'PRA00000003', 'Cuti', 'Edit', 'Mengedit Revisi Absen Baru', '2019-06-24 05:58:20'),
(121, '1703108', 'PRA00000003', 'Revisi Absen', 'Batalkan', 'Membatalkan Revisi Absen', '2019-06-24 06:29:49'),
(122, '1703108', 'PCT00000000', 'Cuti', 'Add', 'Menambahkan cuti baru', '2019-06-24 06:54:15'),
(123, '1703108', 'PCT00000000', 'Cuti', 'Menolak', 'Menolak Approve Cuti sebagai Pengganti', '2019-06-24 07:28:03'),
(124, '1703108', 'PCT00000001', 'Cuti', 'Add', 'Menambahkan cuti baru', '2019-06-24 07:34:20'),
(125, '1703108', 'PCT00000001', 'Cuti', 'Menolak', 'Menolak Approve Cuti sebagai Pengganti', '2019-06-24 07:47:57'),
(126, '1703108', 'PCT00000001', 'Cuti', 'Add', 'Menambahkan cuti baru', '2019-06-24 07:49:54'),
(127, '1703108', 'PCT00000001', 'Cuti', 'Approve', 'Menyetujui sebagai pengganti pekerjaan', '2019-06-24 07:50:06'),
(128, '1703108', 'PCT00000001', 'Cuti', 'Add', 'Menambahkan cuti baru', '2019-06-24 08:01:32'),
(129, '1703108', 'PCT00000001', 'Cuti', 'Edit', 'Mengedit Cuti Baru', '2019-06-24 08:01:47'),
(130, '1703108', 'PCT00000001', 'Cuti', 'Approve', 'Menyetujui sebagai pengganti pekerjaan', '2019-06-24 11:08:57'),
(131, '1703108', 'PCT00000001', 'Cuti', 'Add', 'Menambahkan cuti baru', '2019-06-24 13:36:23'),
(132, '1703108', 'PCT00000001', 'Cuti', 'Batalkan', 'Membatalkan Cuti', '2019-06-24 13:38:59'),
(133, '1703108', 'PCT00000001', 'Cuti', 'Add', 'Menambahkan cuti baru', '2019-06-24 13:41:30'),
(134, '1703108', 'PCT00000001', 'Cuti', 'Approve', 'Menyetujui sebagai pengganti pekerjaan', '2019-06-24 13:42:24'),
(135, '1703108', 'PCT00000001', 'Cuti', 'Edit', 'Mengedit Cuti Baru', '2019-06-24 19:31:02'),
(136, '1703108', 'PCT00000001', 'Cuti', 'Approve', 'Menyetujui sebagai pengganti pekerjaan', '2019-06-24 19:31:52'),
(137, '1703108', 'PIZ00000005', 'Izin', 'Add', 'Menambahkan izin baru', '2019-06-24 19:32:21'),
(138, '1703108', '-', 'Auth', 'Logout', 'User logout', '2019-06-24 19:48:14'),
(139, '1234', '-', 'Auth', 'Login', 'User login', '2019-06-24 19:49:32'),
(140, '1234', '-', 'Auth', 'Logout', 'User logout', '2019-06-24 19:52:59'),
(141, '06143', '-', 'Auth', 'Login', 'User login', '2019-06-24 19:53:11'),
(142, '06143', '-', 'Auth', 'Logout', 'User logout', '2019-06-24 19:56:51'),
(143, '1234', '-', 'Auth', 'Login', 'User login', '2019-06-24 19:57:04'),
(144, '1234', '-', 'Auth', 'Logout', 'User logout', '2019-06-25 06:11:54'),
(145, '1234', '-', 'Auth', 'Login', 'User login', '2019-06-25 06:11:59'),
(146, '1234', 'PCT00000001', 'Cuti', 'Menolak', 'Menolak Approve Cuti sebagai Pengganti', '2019-06-25 06:22:34'),
(147, '1234', 'PCT00000001', 'Cuti', 'Menolak', 'Menolak Approve Cuti sebagai Pengganti', '2019-06-25 06:29:29'),
(148, '1234', 'PCT00000001', 'Cuti', 'Approve', 'Menyetujui pengajuan cuti', '2019-06-25 06:35:31'),
(149, '1234', '-', 'Auth', 'Logout', 'User logout', '2019-06-25 06:35:41'),
(150, '1703108', '-', 'Auth', 'Login', 'User login', '2019-06-25 06:35:52'),
(151, '1703108', '-', 'Auth', 'Logout', 'User logout', '2019-06-25 06:41:45'),
(152, '1234', '-', 'Auth', 'Login', 'User login', '2019-06-25 06:41:53'),
(153, '1234', 'PCT00000001', 'Cuti', 'Approve', 'Menyetujui pengajuan cuti', '2019-06-25 06:42:07'),
(154, '1234', 'PCT00000001', 'Cuti', 'Add', 'Menambahkan cuti baru', '2019-06-25 06:51:10'),
(155, '1234', '-', 'Auth', 'Logout', 'User logout', '2019-06-25 07:30:17'),
(156, '1703108', '-', 'Auth', 'Login', 'User login', '2019-06-25 07:30:39'),
(157, '1234', '-', 'Auth', 'Login', 'User login', '2019-06-25 07:31:10'),
(158, '1234', 'PIZ00000005', 'Cuti', 'Batalkan', 'Menolak Izin', '2019-06-25 08:29:40'),
(159, '1234', '-', 'Auth', 'Logout', 'User logout', '2019-06-25 08:31:46'),
(160, '1234', '-', 'Auth', 'Login', 'User login', '2019-06-25 08:32:01'),
(161, '1703108', 'PIZ00000006', 'Izin', 'Add', 'Menambahkan izin baru', '2019-06-25 08:32:12'),
(162, '1703108', 'PCT00000001', 'Cuti', 'Approve', 'Menyetujui sebagai pengganti pekerjaan', '2019-06-25 08:36:07'),
(163, '1234', 'PIZ00000006', 'Izin', 'Batalkan', 'Menyetujui Izin', '2019-06-25 08:36:20'),
(164, '1703108', 'PIZ00000007', 'Izin', 'Add', 'Menambahkan izin baru', '2019-06-25 08:41:18'),
(165, '1234', 'PIZ00000007', 'Izin', 'Batalkan', 'Menyetujui Izin', '2019-06-25 08:42:15'),
(166, '1703108', 'PIZ00000008', 'Izin', 'Add', 'Menambahkan izin baru', '2019-06-25 10:05:47'),
(167, '1234', 'PIZ00000008', 'Izin', 'Batalkan', 'Menyetujui Izin', '2019-06-25 10:10:36'),
(168, '1703108', 'PRA00000004', 'Revisi Absen', 'Add', 'Menambahkan revisi absen baru', '2019-06-25 10:28:33'),
(169, '1703108', 'PRA00000004', 'Revisi Absen', 'Batalkan', 'Membatalkan Revisi Absen', '2019-06-25 10:29:15'),
(170, '1703108', 'PRA00000005', 'Revisi Absen', 'Add', 'Menambahkan revisi absen baru', '2019-06-25 11:06:19'),
(171, '1703108', 'PCT00000001', 'Cuti', 'Add', 'Menambahkan cuti baru', '2019-06-25 14:08:34'),
(172, '1703108', 'PIZ00000009', 'Izin', 'Add', 'Menambahkan izin baru', '2019-06-25 14:09:17'),
(173, '1234', 'PCT00000001', 'Cuti', 'Add', 'Menambahkan cuti baru', '2019-06-25 19:05:01'),
(174, '1234', 'PRA00000005', 'Revisi Absen', 'Approve', 'Menyetujui Revisi Absen', '2019-06-26 08:09:35'),
(175, '1234', 'PIZ00000009', 'Cuti', 'Approval 1', 'Menyetujui izin', '2019-06-26 08:10:11'),
(176, '1234', '-', 'Auth', 'Logout', 'User logout', '2019-06-26 08:16:16'),
(177, '06142', '-', 'Auth', 'Login', 'User login', '2019-06-26 08:16:28'),
(178, '06142', '-', 'Auth', 'Logout', 'User logout', '2019-06-26 08:47:59'),
(179, '06143', '-', 'Auth', 'Login', 'User login', '2019-06-26 08:48:05'),
(180, '06143', '-', 'Auth', 'Logout', 'User logout', '2019-06-26 08:49:08'),
(181, '06142', '-', 'Auth', 'Login', 'User login', '2019-06-26 08:49:16'),
(182, '06142', '-', 'Auth', 'Logout', 'User logout', '2019-06-26 09:01:31'),
(183, '06143', '-', 'Auth', 'Login', 'User login', '2019-06-26 09:01:43'),
(184, '06143', '-', 'Auth', 'Logout', 'User logout', '2019-06-26 09:04:11'),
(185, '06142', '-', 'Auth', 'Login', 'User login', '2019-06-26 09:04:18'),
(186, '06142', '-', 'Auth', 'Logout', 'User logout', '2019-06-26 09:09:24'),
(187, '06143', '-', 'Auth', 'Login', 'User login', '2019-06-26 09:09:38'),
(188, '06143', 'PCT00000001', 'Cuti', 'Add', 'Menambahkan cuti baru', '2019-06-26 09:15:32'),
(189, '06143', 'PIZ00000010', 'Izin', 'Add', 'Menambahkan izin baru', '2019-06-27 05:52:08'),
(190, '06143', 'PRA00000006', 'Revisi Absen', 'Add', 'Menambahkan revisi absen baru', '2019-06-27 05:52:40'),
(191, '06143', '-', 'Auth', 'Logout', 'User logout', '2019-06-27 05:58:40'),
(192, '1234', '-', 'Auth', 'Login', 'User login', '2019-06-27 05:58:49'),
(193, '1234', '-', 'Auth', 'Logout', 'User logout', '2019-06-27 06:07:03'),
(194, '1703108', '-', 'Auth', 'Login', 'User login', '2019-06-27 06:07:08'),
(195, '1703108', 'PCT00000001', 'Cuti', 'Add', 'Menambahkan cuti baru', '2019-06-27 06:07:46'),
(196, '1703108', 'PIZ00000011', 'Izin', 'Add', 'Menambahkan izin baru', '2019-06-27 06:08:03'),
(197, '1703108', 'PRA00000007', 'Revisi Absen', 'Add', 'Menambahkan revisi absen baru', '2019-06-27 06:08:17'),
(198, '1703108', '-', 'Auth', 'Logout', 'User logout', '2019-06-27 06:08:21'),
(199, '1234', '-', 'Auth', 'Login', 'User login', '2019-06-27 06:08:26'),
(200, '1234', '-', 'Auth', 'Logout', 'User logout', '2019-06-27 06:18:28'),
(201, '06142', '-', 'Auth', 'Login', 'User login', '2019-06-27 06:18:35'),
(202, '06142', '-', 'Auth', 'Logout', 'User logout', '2019-06-27 06:32:14'),
(203, '06143', '-', 'Auth', 'Login', 'User login', '2019-06-27 12:36:50'),
(204, '06143', '-', 'Auth', 'Logout', 'User logout', '2019-06-27 12:37:17'),
(205, '06142', '-', 'Auth', 'Login', 'User login', '2019-06-27 12:37:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `revisi_absen`
--

CREATE TABLE `revisi_absen` (
  `id_previsi` varchar(11) NOT NULL,
  `tgl_absensi` date NOT NULL,
  `tgl_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nik` varchar(20) NOT NULL,
  `alasan` varchar(50) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `jam_pulang` varchar(5) NOT NULL,
  `jam_datang` varchar(5) NOT NULL,
  `status` enum('Proses','Batal','Ditolak','Approve') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `revisi_absen`
--

INSERT INTO `revisi_absen` (`id_previsi`, `tgl_absensi`, `tgl_input`, `nik`, `alasan`, `keterangan`, `jam_pulang`, `jam_datang`, `status`) VALUES
('PRA00000001', '2019-06-17', '2019-06-23 07:39:14', '06143', 'Coba', 'Test', '08.00', '18.00', 'Batal'),
('PRA00000002', '2019-06-22', '2019-06-23 08:18:40', '06143', 'Alasan 1', 'COBA', '20:00', '08:30', 'Batal'),
('PRA00000003', '2019-06-20', '2019-06-24 03:36:24', '1703108', 'Alasan 3', 'Test yaaaaa', '20:20', '10:11', 'Batal'),
('PRA00000004', '2019-06-22', '2019-06-25 10:28:32', '1703108', 'Alasan 2', 'test', '17:30', '10:10', 'Batal'),
('PRA00000005', '2019-06-22', '2019-06-25 11:06:19', '1703108', 'Alasan 2', 'asdasd', '17:00', '10:10', 'Approve'),
('PRA00000006', '2019-06-08', '2019-06-27 05:52:40', '06143', 'Alasan 1', 'TEst', '18:00', '08:30', 'Proses'),
('PRA00000007', '2019-06-22', '2019-06-27 06:08:17', '1703108', 'Alasan 1', 'Test', '18:00', '10:10', 'Proses');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
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
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`nik`, `email`, `password`, `level`, `tgl_registrasi`, `foto`, `token`) VALUES
('06142', 'dianratna91@gmail.com', 'admin', 'Admin', '2019-04-05 23:59:15', 'user.jpg', '37403280b6e8573'),
('06143', 'dianratna19@gmail.com', '06143', 'Karyawan', '2019-04-10 16:53:32', 'user.jpg', '839ce9d4eb060fd'),
('06149', 'dianratna1996@gmail.com', '06149', 'Admin', '2019-04-16 08:19:07', 'user.jpg', 'e2cbc18a8ee9f4a'),
('1234', 'viz.ndinq@gmail.com', '1234', 'Kabag', '2019-04-16 12:14:25', 'user.jpg', '7c2787a67dee97c'),
('1703108', 'ranggela10@gmail.com', '1703108', 'Karyawan', '2019-06-23 12:44:36', 'user.jpg', 'd93eac47c614392'),
('173958713-9', 'adgdmo@gmail.com', '173958713-9', 'Karyawan', '2019-04-16 08:36:41', 'user.jpg', '3b3cbc68876182c'),
('5785868', 'viz.ndinq132@gmail.com', '5785868', 'Karyawan', '2019-04-16 14:01:55', 'user.jpg', '95e4aa13402838f');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absen`),
  ADD KEY `nik` (`nik`);

--
-- Indeks untuk tabel `approval_absen`
--
ALTER TABLE `approval_absen`
  ADD PRIMARY KEY (`id_app_absen`),
  ADD KEY `id_previsi` (`id_previsi`),
  ADD KEY `nik` (`nik`);

--
-- Indeks untuk tabel `approval_cuti`
--
ALTER TABLE `approval_cuti`
  ADD PRIMARY KEY (`id_app_cuti`),
  ADD KEY `id_pcuti` (`id_pcuti`),
  ADD KEY `nik` (`nik`);

--
-- Indeks untuk tabel `approval_izin`
--
ALTER TABLE `approval_izin`
  ADD PRIMARY KEY (`id_app_izin`),
  ADD KEY `id_pizin` (`id_pizin`),
  ADD KEY `nik` (`nik`);

--
-- Indeks untuk tabel `cuti`
--
ALTER TABLE `cuti`
  ADD PRIMARY KEY (`id_pcuti`),
  ADD KEY `nik` (`nik`),
  ADD KEY `id_cuti` (`id_cuti`),
  ADD KEY `pengganti` (`pengganti`);

--
-- Indeks untuk tabel `cuti_bersama`
--
ALTER TABLE `cuti_bersama`
  ADD PRIMARY KEY (`id_cuti_bersama`);

--
-- Indeks untuk tabel `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id_divisi`);

--
-- Indeks untuk tabel `izin`
--
ALTER TABLE `izin`
  ADD PRIMARY KEY (`id_pizin`),
  ADD KEY `nik` (`nik`),
  ADD KEY `nik_2` (`nik`),
  ADD KEY `id_izin` (`id_izin`),
  ADD KEY `id_izin_2` (`id_izin`);

--
-- Indeks untuk tabel `jenis_cuti`
--
ALTER TABLE `jenis_cuti`
  ADD PRIMARY KEY (`id_cuti`);

--
-- Indeks untuk tabel `jenis_izin`
--
ALTER TABLE `jenis_izin`
  ADD PRIMARY KEY (`id_izin`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`nik`),
  ADD KEY `divisi` (`id_divisi`);

--
-- Indeks untuk tabel `lampiran_cuti`
--
ALTER TABLE `lampiran_cuti`
  ADD PRIMARY KEY (`id_lampiran_cuti`),
  ADD KEY `id_pcuti` (`id_pcuti`);

--
-- Indeks untuk tabel `lampiran_izin`
--
ALTER TABLE `lampiran_izin`
  ADD PRIMARY KEY (`id_lampiran_izin`),
  ADD KEY `id_pizin` (`id_pizin`);

--
-- Indeks untuk tabel `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_user` (`nik`),
  ADD KEY `nik` (`nik`);

--
-- Indeks untuk tabel `revisi_absen`
--
ALTER TABLE `revisi_absen`
  ADD PRIMARY KEY (`id_previsi`),
  ADD KEY `nik` (`nik`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`nik`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `approval_absen`
--
ALTER TABLE `approval_absen`
  MODIFY `id_app_absen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `approval_cuti`
--
ALTER TABLE `approval_cuti`
  MODIFY `id_app_cuti` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `approval_izin`
--
ALTER TABLE `approval_izin`
  MODIFY `id_app_izin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `cuti_bersama`
--
ALTER TABLE `cuti_bersama`
  MODIFY `id_cuti_bersama` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `lampiran_cuti`
--
ALTER TABLE `lampiran_cuti`
  MODIFY `id_lampiran_cuti` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `lampiran_izin`
--
ALTER TABLE `lampiran_izin`
  MODIFY `id_lampiran_izin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `log`
--
ALTER TABLE `log`
  MODIFY `id_log` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `karyawan` (`nik`);

--
-- Ketidakleluasaan untuk tabel `approval_absen`
--
ALTER TABLE `approval_absen`
  ADD CONSTRAINT `approval_absen_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `karyawan` (`nik`),
  ADD CONSTRAINT `approval_absen_ibfk_2` FOREIGN KEY (`id_previsi`) REFERENCES `revisi_absen` (`id_previsi`);

--
-- Ketidakleluasaan untuk tabel `approval_cuti`
--
ALTER TABLE `approval_cuti`
  ADD CONSTRAINT `approval_cuti_ibfk_1` FOREIGN KEY (`id_pcuti`) REFERENCES `cuti` (`id_pcuti`),
  ADD CONSTRAINT `approval_cuti_ibfk_2` FOREIGN KEY (`nik`) REFERENCES `karyawan` (`nik`);

--
-- Ketidakleluasaan untuk tabel `approval_izin`
--
ALTER TABLE `approval_izin`
  ADD CONSTRAINT `approval_izin_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `karyawan` (`nik`),
  ADD CONSTRAINT `approval_izin_ibfk_2` FOREIGN KEY (`id_pizin`) REFERENCES `izin` (`id_pizin`);

--
-- Ketidakleluasaan untuk tabel `cuti`
--
ALTER TABLE `cuti`
  ADD CONSTRAINT `cuti_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `karyawan` (`nik`) ON UPDATE CASCADE,
  ADD CONSTRAINT `cuti_ibfk_2` FOREIGN KEY (`id_cuti`) REFERENCES `jenis_cuti` (`id_cuti`),
  ADD CONSTRAINT `cuti_ibfk_3` FOREIGN KEY (`pengganti`) REFERENCES `karyawan` (`nik`);

--
-- Ketidakleluasaan untuk tabel `izin`
--
ALTER TABLE `izin`
  ADD CONSTRAINT `izin_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `karyawan` (`nik`) ON UPDATE CASCADE,
  ADD CONSTRAINT `izin_ibfk_2` FOREIGN KEY (`id_izin`) REFERENCES `jenis_izin` (`id_izin`);

--
-- Ketidakleluasaan untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `karyawan_ibfk_1` FOREIGN KEY (`id_divisi`) REFERENCES `divisi` (`id_divisi`);

--
-- Ketidakleluasaan untuk tabel `lampiran_cuti`
--
ALTER TABLE `lampiran_cuti`
  ADD CONSTRAINT `lampiran_cuti_ibfk_1` FOREIGN KEY (`id_pcuti`) REFERENCES `cuti` (`id_pcuti`);

--
-- Ketidakleluasaan untuk tabel `lampiran_izin`
--
ALTER TABLE `lampiran_izin`
  ADD CONSTRAINT `lampiran_izin_ibfk_1` FOREIGN KEY (`id_pizin`) REFERENCES `izin` (`id_pizin`);

--
-- Ketidakleluasaan untuk tabel `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `user` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `revisi_absen`
--
ALTER TABLE `revisi_absen`
  ADD CONSTRAINT `revisi_absen_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `karyawan` (`nik`);

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `karyawan` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
