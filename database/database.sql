-- =============================================
-- SISTEM PENGADUAN/ASPIRASI SISWA
-- Database Schema
-- =============================================

-- Buat database
CREATE DATABASE IF NOT EXISTS db_pengaduan_aip;
USE db_pengaduan_aip;

-- =============================================
-- Tabel Admin
-- =============================================
CREATE TABLE IF NOT EXISTS admin (
    id_admin INT(5) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =============================================
-- Tabel Siswa
-- =============================================
CREATE TABLE IF NOT EXISTS siswa (
    nis INT(10) PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    kelas VARCHAR(10) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =============================================
-- Tabel Kategori
-- =============================================
CREATE TABLE IF NOT EXISTS kategori (
    id_kategori INT(5) AUTO_INCREMENT PRIMARY KEY,
    ket_kategori VARCHAR(30) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =============================================
-- Tabel Input Aspirasi (Pelaporan)
-- =============================================
CREATE TABLE IF NOT EXISTS input_aspirasi (
    id_pelaporan INT(5) AUTO_INCREMENT PRIMARY KEY,
    nis INT(10) NOT NULL,
    id_kategori INT(5) NOT NULL,
    lokasi VARCHAR(50) NOT NULL,
    ket TEXT NOT NULL,
    tanggal_input DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (nis) REFERENCES siswa(nis) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- =============================================
-- Tabel Aspirasi (Status & Feedback)
-- =============================================
CREATE TABLE IF NOT EXISTS aspirasi (
    id_aspirasi INT(5) AUTO_INCREMENT PRIMARY KEY,
    id_pelaporan INT(5) NOT NULL UNIQUE,
    status ENUM('Menunggu', 'Proses', 'Selesai') DEFAULT 'Menunggu',
    feedback TEXT,
    tanggal_update DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pelaporan) REFERENCES input_aspirasi(id_pelaporan) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- =============================================
-- Sample Data
-- =============================================

-- Insert Admin (password: admin123)
INSERT INTO admin (username, password, nama_lengkap) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator'),
('koordinator', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Koordinator OSIS');

-- Insert Siswa (password: siswa123)
INSERT INTO siswa (nis, nama, kelas, password) VALUES
(2024001, 'Ahmad Fadillah', 'XII IPA 1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(2024002, 'Siti Nurhaliza', 'XII IPA 2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(2024003, 'Budi Santoso', 'XI IPS 1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(2024004, 'Dewi Lestari', 'XI IPA 1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(2024005, 'Rizki Pratama', 'X IPA 1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insert Kategori
INSERT INTO kategori (ket_kategori) VALUES
('Fasilitas'),
('Kegiatan'),
('Organisasi'),
('Pembelajaran'),
('Keamanan'),
('Kebersihan'),
('Lainnya');

-- Insert Sample Aspirasi
INSERT INTO input_aspirasi (nis, id_kategori, lokasi, ket, tanggal_input) VALUES
(2024001, 1, 'Ruang Kelas XII IPA 1', 'AC di ruang kelas tidak berfungsi dengan baik, suhu ruangan sangat panas', '2026-01-15 08:30:00'),
(2024002, 2, 'Lapangan Sekolah', 'Mohon diadakan kegiatan olahraga antar kelas untuk meningkatkan kebersamaan', '2026-01-18 10:15:00'),
(2024003, 3, 'Ruang OSIS', 'Jadwal rapat OSIS sering berubah-ubah, mohon ada jadwal yang tetap', '2026-01-20 14:00:00'),
(2024001, 6, 'Toilet Lantai 2', 'Toilet lantai 2 sering kotor dan bau, mohon ditingkatkan kebersihannya', '2026-01-22 09:45:00'),
(2024004, 4, 'Ruang Kelas XI IPA 1', 'Proyektor di kelas sering error, mengganggu proses pembelajaran', '2026-01-25 11:30:00');

-- Insert Status Aspirasi
INSERT INTO aspirasi (id_pelaporan, status, feedback) VALUES
(1, 'Selesai', 'AC sudah diperbaiki oleh teknisi pada tanggal 20 Januari 2026. Terima kasih atas laporannya.'),
(2, 'Proses', 'Sedang direncanakan kegiatan futsal antar kelas untuk bulan depan.'),
(3, 'Menunggu', NULL),
(4, 'Proses', 'Sudah dikoordinasikan dengan petugas kebersihan untuk lebih intensif membersihkan toilet.'),
(5, 'Menunggu', NULL);
