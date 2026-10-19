-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2026 at 01:29 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pengaduan_sarpras`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_admin` varchar(100) NOT NULL,
  `level` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `username`, `password`, `nama_admin`, `level`, `status`) VALUES
(1, 'admin01', 'admin123', 'Ellen Junita', 'Admin', 'Aktif'),
(2, 'admin02', 'admin123', 'Tasya Julianti', 'Super Admin', 'Aktif'),
(3, 'admin03', 'admin123', 'Alisa Khoiron', 'Admin', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `tb_aspirasi`
--

CREATE TABLE `tb_aspirasi` (
  `id_aspirasi` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `isi_aspirasi` text NOT NULL,
  `tanggal` date NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'Menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_aspirasi`
--

INSERT INTO `tb_aspirasi` (`id_aspirasi`, `id_siswa`, `id_kategori`, `judul`, `isi_aspirasi`, `tanggal`, `status`) VALUES
(1, 1, 1, 'Meja Rusak', 'Beberapa meja di kelas mengalami kerusakan pada kakinya.', '2026-09-01', 'Diproses'),
(2, 2, 2, 'Kursi Patah', 'Ada kursi yang sudah patah dan tidak layak digunakan.', '2026-09-02', 'Menunggu'),
(3, 3, 3, 'Proyektor Tidak Menyala', 'Proyektor di kelas X RPL 2 mati total.', '2026-09-03', 'Selesai'),
(4, 1, 1, 'a', 'a', '2026-09-17', 'Menunggu'),
(5, 1, 3, 'Tidak menyala', 'Tiba-tiba meledak dan mati saat beberapa menit di pakai', '2026-09-21', 'Menunggu'),
(6, 1, 4, 'j', 'ghg', '2026-09-21', 'Diproses'),
(7, 1, 3, 'Tidak menyala', 'jawhdgj', '2026-09-21', 'Diproses'),
(8, 1, 5, 'Tidak menyala', 'ini gerah gada ac', '2026-09-23', 'Selesai');

-- --------------------------------------------------------

--
-- Table structure for table `tb_input`
--

CREATE TABLE `tb_input` (
  `id_input` int(11) NOT NULL,
  `id_aspirasi` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `tanggapan` text NOT NULL,
  `tanggal_input` date NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_input`
--

INSERT INTO `tb_input` (`id_input`, `id_aspirasi`, `id_admin`, `tanggapan`, `tanggal_input`, `status`) VALUES
(1, 1, 1, 'Laporan diterima dan sedang dijadwalkan untuk perbaikan.', '2026-09-02', 'Diproses'),
(2, 3, 2, 'Proyektor telah diganti dengan unit baru yang berfungsi.', '2026-09-04', 'Selesai'),
(3, 4, 2, 'sabar dulu yahh', '2026-09-21', 'Menunggu'),
(4, 5, 2, 'Proyektor sudah di ganti yang baru', '2026-09-21', 'Menunggu'),
(5, 6, 3, 'ini mau', '2026-09-21', 'Diproses'),
(6, 7, 1, 'sabar', '2026-09-21', 'Diproses'),
(7, 8, 1, 'oke nanti di cek', '2026-09-23', 'Selesai');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kategori`
--

CREATE TABLE `tb_kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `lokasi` varchar(100) NOT NULL,
  `kondisi` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_kategori`
--

INSERT INTO `tb_kategori` (`id_kategori`, `nama_kategori`, `keterangan`, `lokasi`, `kondisi`, `status`) VALUES
(1, 'Meja', 'Meja belajar siswa', 'Ruang Kelas', 'Rusak', 'Aktif'),
(2, 'Kursi', 'Kursi belajar siswa', 'Ruang Kelas', 'Rusak', 'Aktif'),
(3, 'Proyektor', 'Proyektor untuk pembelajaran', 'Ruang Kelas', 'Rusak', 'Aktif'),
(4, 'Komputer', 'Komputer laboratorium', 'Lab RPL', 'Rusak', 'Aktif'),
(5, 'AC Ruangan', 'Pendingin ruangan kelas', 'Lab RPL', 'Baik', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `id_siswa` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `kelas` varchar(20) NOT NULL,
  `jurusan` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_siswa`
--

INSERT INTO `tb_siswa` (`id_siswa`, `nis`, `nama_siswa`, `kelas`, `jurusan`, `username`, `password`) VALUES
(1, '10001', 'Budi Santoso', 'XII RPL 1', 'RPL', 'budi01', '12345'),
(2, '10002', 'Sarah Arlatia', 'X RPL 1', 'RPL', 'siti02', '12345'),
(3, '10003', 'Diana Princess', 'X RPL 2', 'RPL', 'dimas03', '12345');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `tb_aspirasi`
--
ALTER TABLE `tb_aspirasi`
  ADD PRIMARY KEY (`id_aspirasi`),
  ADD KEY `fk_aspirasi_siswa` (`id_siswa`),
  ADD KEY `fk_aspirasi_kategori` (`id_kategori`);

--
-- Indexes for table `tb_input`
--
ALTER TABLE `tb_input`
  ADD PRIMARY KEY (`id_input`),
  ADD KEY `fk_input_aspirasi` (`id_aspirasi`),
  ADD KEY `fk_input_admin` (`id_admin`);

--
-- Indexes for table `tb_kategori`
--
ALTER TABLE `tb_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `nis` (`nis`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_aspirasi`
--
ALTER TABLE `tb_aspirasi`
  MODIFY `id_aspirasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_input`
--
ALTER TABLE `tb_input`
  MODIFY `id_input` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_kategori`
--
ALTER TABLE `tb_kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_aspirasi`
--
ALTER TABLE `tb_aspirasi`
  ADD CONSTRAINT `fk_aspirasi_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `tb_kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_aspirasi_siswa` FOREIGN KEY (`id_siswa`) REFERENCES `tb_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_input`
--
ALTER TABLE `tb_input`
  ADD CONSTRAINT `fk_input_admin` FOREIGN KEY (`id_admin`) REFERENCES `tb_admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_input_aspirasi` FOREIGN KEY (`id_aspirasi`) REFERENCES `tb_aspirasi` (`id_aspirasi`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
