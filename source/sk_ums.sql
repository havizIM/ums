-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Agu 2019 pada 00.33
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
  `nik` varchar(9) NOT NULL,
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
  `id_app_absen` int(6) NOT NULL,
  `id_previsi` varchar(12) NOT NULL,
  `nik` varchar(9) NOT NULL,
  `keterangan` varchar(15) NOT NULL,
  `tgl_approve` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `approval_cuti`
--

CREATE TABLE `approval_cuti` (
  `id_app_cuti` int(6) NOT NULL,
  `id_pcuti` varchar(12) NOT NULL,
  `nik` varchar(9) NOT NULL,
  `keterangan` varchar(15) NOT NULL,
  `tgl_approve` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `approval_izin`
--

CREATE TABLE `approval_izin` (
  `id_app_izin` int(6) NOT NULL,
  `id_pizin` varchar(12) NOT NULL,
  `nik` varchar(9) NOT NULL,
  `keterangan` varchar(15) NOT NULL,
  `tgl_approval` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cuti`
--

CREATE TABLE `cuti` (
  `id_pcuti` varchar(12) NOT NULL,
  `nik` varchar(9) NOT NULL,
  `id_cuti` varchar(6) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `pengganti` varchar(9) NOT NULL,
  `jumlah_cuti` int(11) NOT NULL,
  `tgl_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Proses','Approve 1','Approve 2','Approve 3','Ditolak','Batal') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cuti_bersama`
--

CREATE TABLE `cuti_bersama` (
  `id_cuti_bersama` int(6) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `tgl_cuti_bersama` date NOT NULL,
  `tgl_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_cuti`
--

CREATE TABLE `detail_cuti` (
  `id_pcuti` varchar(12) NOT NULL,
  `tanggal_cuti` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `divisi`
--

CREATE TABLE `divisi` (
  `id_divisi` varchar(6) NOT NULL,
  `nama_divisi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `izin`
--

CREATE TABLE `izin` (
  `id_pizin` varchar(11) NOT NULL,
  `nik` varchar(9) NOT NULL,
  `id_izin` varchar(6) NOT NULL,
  `tgl_izin` date NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `tgl_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Proses','Batal','Ditolak','Approve 1','Approve 2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_cuti`
--

CREATE TABLE `jenis_cuti` (
  `id_cuti` varchar(6) NOT NULL,
  `nama_cuti` varchar(50) NOT NULL,
  `banyak_cuti` int(11) NOT NULL,
  `lampiran` enum('Y','T') NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_izin`
--

CREATE TABLE `jenis_izin` (
  `id_izin` varchar(6) NOT NULL,
  `keperluan` varchar(100) NOT NULL,
  `keterangan_izin` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `nik` varchar(9) NOT NULL,
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

-- --------------------------------------------------------

--
-- Struktur dari tabel `lampiran_cuti`
--

CREATE TABLE `lampiran_cuti` (
  `id_lampiran_cuti` int(6) NOT NULL,
  `id_pcuti` varchar(12) NOT NULL,
  `nama_lampiran` varchar(30) NOT NULL,
  `lampiran_cuti` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lampiran_izin`
--

CREATE TABLE `lampiran_izin` (
  `id_lampiran_izin` int(6) NOT NULL,
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
  `nik` varchar(9) NOT NULL,
  `id_ref` varchar(11) NOT NULL,
  `refrensi` varchar(30) NOT NULL,
  `kategori` varchar(30) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `tgl_log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `revisi_absen`
--

CREATE TABLE `revisi_absen` (
  `id_previsi` varchar(11) NOT NULL,
  `tgl_absensi` date NOT NULL,
  `tgl_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nik` varchar(9) NOT NULL,
  `alasan` varchar(50) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `jam_pulang` varchar(5) NOT NULL,
  `jam_datang` varchar(5) NOT NULL,
  `status` enum('Proses','Batal','Ditolak','Approve') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `nik` varchar(9) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(15) NOT NULL,
  `level` enum('Karyawan','Admin','Kabag','Manager') NOT NULL,
  `tgl_registrasi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `foto` text NOT NULL,
  `token` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Indeks untuk tabel `detail_cuti`
--
ALTER TABLE `detail_cuti`
  ADD KEY `id_pcuti` (`id_pcuti`);

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
  MODIFY `id_app_absen` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `approval_cuti`
--
ALTER TABLE `approval_cuti`
  MODIFY `id_app_cuti` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `approval_izin`
--
ALTER TABLE `approval_izin`
  MODIFY `id_app_izin` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `cuti_bersama`
--
ALTER TABLE `cuti_bersama`
  MODIFY `id_cuti_bersama` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `lampiran_cuti`
--
ALTER TABLE `lampiran_cuti`
  MODIFY `id_lampiran_cuti` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `lampiran_izin`
--
ALTER TABLE `lampiran_izin`
  MODIFY `id_lampiran_izin` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `log`
--
ALTER TABLE `log`
  MODIFY `id_log` bigint(20) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `approval_absen_ibfk_2` FOREIGN KEY (`id_previsi`) REFERENCES `revisi_absen` (`id_previsi`),
  ADD CONSTRAINT `approval_absen_ibfk_3` FOREIGN KEY (`nik`) REFERENCES `karyawan` (`nik`);

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
  ADD CONSTRAINT `approval_izin_ibfk_2` FOREIGN KEY (`id_pizin`) REFERENCES `izin` (`id_pizin`),
  ADD CONSTRAINT `approval_izin_ibfk_3` FOREIGN KEY (`nik`) REFERENCES `karyawan` (`nik`);

--
-- Ketidakleluasaan untuk tabel `cuti`
--
ALTER TABLE `cuti`
  ADD CONSTRAINT `cuti_ibfk_2` FOREIGN KEY (`id_cuti`) REFERENCES `jenis_cuti` (`id_cuti`),
  ADD CONSTRAINT `cuti_ibfk_3` FOREIGN KEY (`nik`) REFERENCES `karyawan` (`nik`),
  ADD CONSTRAINT `cuti_ibfk_4` FOREIGN KEY (`pengganti`) REFERENCES `karyawan` (`nik`);

--
-- Ketidakleluasaan untuk tabel `detail_cuti`
--
ALTER TABLE `detail_cuti`
  ADD CONSTRAINT `detail_cuti_ibfk_1` FOREIGN KEY (`id_pcuti`) REFERENCES `cuti` (`id_pcuti`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `izin`
--
ALTER TABLE `izin`
  ADD CONSTRAINT `izin_ibfk_2` FOREIGN KEY (`id_izin`) REFERENCES `jenis_izin` (`id_izin`),
  ADD CONSTRAINT `izin_ibfk_3` FOREIGN KEY (`nik`) REFERENCES `karyawan` (`nik`);

--
-- Ketidakleluasaan untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `karyawan_ibfk_1` FOREIGN KEY (`id_divisi`) REFERENCES `divisi` (`id_divisi`);

--
-- Ketidakleluasaan untuk tabel `lampiran_cuti`
--
ALTER TABLE `lampiran_cuti`
  ADD CONSTRAINT `lampiran_cuti_ibfk_1` FOREIGN KEY (`id_pcuti`) REFERENCES `cuti` (`id_pcuti`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `lampiran_izin`
--
ALTER TABLE `lampiran_izin`
  ADD CONSTRAINT `lampiran_izin_ibfk_1` FOREIGN KEY (`id_pizin`) REFERENCES `izin` (`id_pizin`);

--
-- Ketidakleluasaan untuk tabel `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `user` (`nik`);

--
-- Ketidakleluasaan untuk tabel `revisi_absen`
--
ALTER TABLE `revisi_absen`
  ADD CONSTRAINT `revisi_absen_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `karyawan` (`nik`);

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `karyawan` (`nik`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
