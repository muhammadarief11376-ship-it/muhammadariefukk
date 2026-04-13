<?php
/**
 * Konfigurasi Aplikasi
 * Sistem Pengaduan/Aspirasi Siswa
 */

// Konfigurasi Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_pengaduan_aip');

// Konfigurasi Aplikasi
define('APP_NAME', 'Sistem Pengaduan Siswa');
define('APP_VERSION', '1.0.0');
define('BASE_URL', 'http://localhost/pengaduan_aip//');

// Timezone
date_default_timezone_set('Asia/Jakarta');

// Error Reporting (set to 0 for production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
