-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 10, 2026 at 11:32 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pengaduan_aip`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `nama_lengkap`, `created_at`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', '2026-02-05 03:43:26'),
(2, 'koordinator', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Koordinator OSIS', '2026-02-05 03:43:26');

-- --------------------------------------------------------

--
-- Table structure for table `aspirasi`
--

CREATE TABLE `aspirasi` (
  `id_aspirasi` int NOT NULL,
  `id_pelaporan` int NOT NULL,
  `status` enum('Menunggu','Proses','Selesai') DEFAULT 'Menunggu',
  `feedback` text,
  `tanggal_update` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `aspirasi`
--

INSERT INTO `aspirasi` (`id_aspirasi`, `id_pelaporan`, `status`, `feedback`, `tanggal_update`) VALUES
(1, 1, 'Selesai', 'AC sudah diperbaiki oleh teknisi pada tanggal 20 Januari 2026. Terima kasih atas laporannya.', '2026-02-05 10:43:26'),
(2, 2, 'Proses', 'Sedang direncanakan kegiatan futsal antar kelas untuk bulan depan.', '2026-02-05 10:43:26'),
(3, 3, 'Menunggu', NULL, '2026-02-05 10:43:26'),
(4, 4, 'Proses', 'Sudah dikoordinasikan dengan petugas kebersihan untuk lebih intensif membersihkan toilet.', '2026-02-05 10:43:26'),
(5, 5, 'Menunggu', NULL, '2026-02-05 10:43:26'),
(6, 6, 'Selesai', 'baik kami suda selesaikan', '2026-04-10 05:51:08'),
(7, 7, 'Menunggu', 'sudah kami bersihkan', '2026-03-13 13:45:56'),
(8, 8, 'Proses', 'oke sudah selesai', '2026-02-10 14:23:52'),
(9, 9, 'Selesai', 'terimakasih', '2026-02-10 14:23:37'),
(10, 10, 'Selesai', 'sudah kami bersihkan', '2026-03-13 13:45:43'),
(11, 11, 'Selesai', 'baik kami sudah bersihkan', '2026-04-10 05:51:19'),
(12, 12, 'Proses', 'tunggu ya kami akan segera perbaikan', '2026-03-13 13:49:27');

-- --------------------------------------------------------

--
-- Table structure for table `input_aspirasi`
--

CREATE TABLE `input_aspirasi` (
  `id_pelaporan` int NOT NULL,
  `nis` int NOT NULL,
  `id_kategori` int NOT NULL,
  `lokasi` varchar(50) NOT NULL,
  `ket` text NOT NULL,
  `tanggal_input` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `input_aspirasi`
--

INSERT INTO `input_aspirasi` (`id_pelaporan`, `nis`, `id_kategori`, `lokasi`, `ket`, `tanggal_input`) VALUES
(1, 2024001, 1, 'Ruang Kelas XII IPA 1', 'AC di ruang kelas tidak berfungsi dengan baik, suhu ruangan sangat panas', '2026-01-15 08:30:00'),
(2, 2024002, 2, 'Lapangan Sekolah', 'Mohon diadakan kegiatan olahraga antar kelas untuk meningkatkan kebersamaan', '2026-01-18 10:15:00'),
(3, 2024003, 3, 'Ruang OSIS', 'Jadwal rapat OSIS sering berubah-ubah, mohon ada jadwal yang tetap', '2026-01-20 14:00:00'),
(4, 2024001, 6, 'Toilet Lantai 2', 'Toilet lantai 2 sering kotor dan bau, mohon ditingkatkan kebersihannya', '2026-01-22 09:45:00'),
(5, 2024004, 4, 'Ruang Kelas XI IPA 1', 'Proyektor di kelas sering error, mengganggu proses pembelajaran', '2026-01-25 11:30:00'),
(6, 2024001, 1, 'ruang kelas', 'rusak', '2026-02-05 11:20:49'),
(7, 2024001, 5, 'lapangan', 'lapangan kotor', '2026-02-06 09:38:25'),
(8, 2024001, 2, 'kelas', 'kapan ada acara', '2026-02-06 10:03:22'),
(9, 2024001, 5, 'kelas', 'sapu rusak', '2026-02-10 14:20:34'),
(10, 2024001, 6, 'lapangan', 'kotor eyy', '2026-02-13 13:21:45'),
(11, 2024004, 6, 'kelas', 'pabalatak', '2026-03-13 13:43:19'),
(12, 2024007, 8, 'Ruang kelas br 2', 'pintu kelas 12 br 2 rusak total', '2026-03-13 13:48:30');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int NOT NULL,
  `ket_kategori` varchar(30) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `ket_kategori`, `created_at`) VALUES
(1, 'Fasilitas', '2026-02-05 03:43:26'),
(2, 'Kegiatan', '2026-02-05 03:43:26'),
(3, 'Organisasi', '2026-02-05 03:43:26'),
(4, 'Pembelajaran', '2026-02-05 03:43:26'),
(5, 'Keamanan', '2026-02-05 03:43:26'),
(6, 'Kebersihan', '2026-02-05 03:43:26'),
(7, 'Lainnya', '2026-02-05 03:43:26'),
(8, 'kerusakan', '2026-03-13 06:44:51');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `nis` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nis`, `nama`, `kelas`, `password`, `created_at`) VALUES
(2024001, 'Nnael', 'XII RPL 1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-02-05 03:43:26'),
(2024002, 'Kidbomba', 'XII RPL 2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-02-05 03:43:26'),
(2024003, 'K1NGKONG', 'XI BR 1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-02-05 03:43:26'),
(2024004, 'Maitsaa', 'XII MP 2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-02-05 03:43:26'),
(2024005, 'Aipp', 'XII AK 1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-02-05 03:43:26'),
(2024007, 'Nattz', 'XII BR 3', '$2y$10$SDkzNeZPEb3.iFYLYBW9MOsvgsh5mKhmnsV1uHyuDfWasu5THMqL.', '2026-03-13 06:47:17'),
(20242000, 'SUPER Nnael', '12 RPL 3', '$2y$10$xZRB3fSFy3Yudfw309Zg3eU0kIN9trGgUYXwtC438JqW4eT8ASeO6', '2026-04-09 22:54:36'),
(20242006, 'Deden FROM BOGOR', 'XII RPL 1', 'deden', '2026-02-10 07:19:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `aspirasi`
--
ALTER TABLE `aspirasi`
  ADD PRIMARY KEY (`id_aspirasi`),
  ADD UNIQUE KEY `id_pelaporan` (`id_pelaporan`);

--
-- Indexes for table `input_aspirasi`
--
ALTER TABLE `input_aspirasi`
  ADD PRIMARY KEY (`id_pelaporan`),
  ADD KEY `nis` (`nis`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nis`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `aspirasi`
--
ALTER TABLE `aspirasi`
  MODIFY `id_aspirasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `input_aspirasi`
--
ALTER TABLE `input_aspirasi`
  MODIFY `id_pelaporan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aspirasi`
--
ALTER TABLE `aspirasi`
  ADD CONSTRAINT `aspirasi_ibfk_1` FOREIGN KEY (`id_pelaporan`) REFERENCES `input_aspirasi` (`id_pelaporan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `input_aspirasi`
--
ALTER TABLE `input_aspirasi`
  ADD CONSTRAINT `input_aspirasi_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `input_aspirasi_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
