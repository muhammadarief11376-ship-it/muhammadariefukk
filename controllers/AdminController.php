<?php
/**
 * Admin Controller
 * Handle semua aksi admin
 */

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/InputAspirasi.php';
require_once __DIR__ . '/../models/Aspirasi.php';
require_once __DIR__ . '/../models/Kategori.php';
require_once __DIR__ . '/../models/Siswa.php';

class AdminController extends Controller {
    private $inputAspirasiModel;
    private $aspirasiModel;
    private $kategoriModel;
    private $siswaModel;
    
    public function __construct() {
        $this->inputAspirasiModel = new InputAspirasi();
        $this->aspirasiModel = new Aspirasi();
        $this->kategoriModel = new Kategori();
        $this->siswaModel = new Siswa();
    }
    
    /**
     * Dashboard Admin
     */
    public function dashboard(): void {
        $this->requireAdmin();
        
        $statistics = $this->inputAspirasiModel->getStatistics();
        $statisticsByKategori = $this->inputAspirasiModel->getStatisticsByKategori();
        $recentAspirasi = $this->inputAspirasiModel->getAllWithDetail();
        $recentAspirasi = array_slice($recentAspirasi, 0, 5); // Ambil 5 terbaru
        
        $this->view('admin/dashboard', [
            'title' => 'Dashboard Admin',
            'user' => $this->getCurrentUser(),
            'flash' => $this->getFlash(),
            'statistics' => $statistics,
            'statisticsByKategori' => $statisticsByKategori,
            'recentAspirasi' => $recentAspirasi
        ]);
    }
    
    /**
     * List semua aspirasi dengan filter
     */
    public function aspirasiIndex(): void {
        $this->requireAdmin();
        
        // Get filter parameters
        $filters = [
            'status' => $this->get('status'),
            'kategori' => $this->get('kategori'),
            'nis' => $this->get('nis'),
            'tanggal_mulai' => $this->get('tanggal_mulai'),
            'tanggal_akhir' => $this->get('tanggal_akhir'),
            'bulan' => $this->get('bulan'),
            'tahun' => $this->get('tahun')
        ];
        
        // Remove empty filters
        $filters = array_filter($filters);
        
        $aspirasi = $this->inputAspirasiModel->getAllWithDetail($filters);
        $kategori = $this->kategoriModel->findAll('ket_kategori', 'ASC');
        $siswa = $this->siswaModel->findAll('nama', 'ASC');
        
        $this->view('admin/aspirasi/index', [
            'title' => 'Daftar Aspirasi',
            'user' => $this->getCurrentUser(),
            'flash' => $this->getFlash(),
            'aspirasi' => $aspirasi,
            'kategori' => $kategori,
            'siswa' => $siswa,
            'filters' => $filters
        ]);
    }
    
    /**
     * Detail aspirasi
     */
    public function aspirasiDetail(): void {
        $this->requireAdmin();
        
        $id = (int) $this->get('id');
        $detail = $this->inputAspirasiModel->getDetail($id);
        
        if (!$detail) {
            $this->setFlash('error', 'Aspirasi tidak ditemukan');
            $this->redirect('index.php?page=admin/aspirasi');
            return;
        }
        
        $this->view('admin/aspirasi/detail', [
            'title' => 'Detail Aspirasi',
            'user' => $this->getCurrentUser(),
            'flash' => $this->getFlash(),
            'detail' => $detail
        ]);
    }
    
    /**
     * Update status aspirasi
     */
    public function updateStatus(): void {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?page=admin/aspirasi');
            return;
        }
        
        $idPelaporan = (int) $this->post('id_pelaporan');
        $status = $this->post('status');
        $feedback = $this->post('feedback') ?? '';
        
        if ($feedback) {
            $this->aspirasiModel->updateStatusAndFeedback($idPelaporan, $status, $feedback);
        } else {
            $this->aspirasiModel->updateStatus($idPelaporan, $status);
        }
        
        $this->setFlash('success', 'Status aspirasi berhasil diupdate');
        $this->redirect('index.php?page=admin/aspirasi/detail&id=' . $idPelaporan);
    }
    
    /**
     * History Aspirasi - Timeline view
     */
    public function history(): void {
        $this->requireAdmin();
        
        $filters = [
            'status' => $this->get('status'),
            'bulan' => $this->get('bulan'),
            'tahun' => $this->get('tahun')
        ];
        $filters = array_filter($filters);
        
        $aspirasi = $this->inputAspirasiModel->getAllWithDetail($filters);
        
        $this->view('admin/history/index', [
            'title' => 'History Aspirasi',
            'user' => $this->getCurrentUser(),
            'flash' => $this->getFlash(),
            'aspirasi' => $aspirasi,
            'filters' => $filters
        ]);
    }
    
    /**
     * Umpan Balik / Feedback Aspirasi
     */
    public function feedback(): void {
        $this->requireAdmin();
        
        $filter = $this->get('filter');
        $aspirasi = $this->inputAspirasiModel->getAllWithDetail();
        
        // Filter by feedback status
        if ($filter === 'belum') {
            $aspirasi = array_filter($aspirasi, fn($a) => empty($a['feedback']));
        } elseif ($filter === 'sudah') {
            $aspirasi = array_filter($aspirasi, fn($a) => !empty($a['feedback']));
        }
        
        $this->view('admin/feedback/index', [
            'title' => 'Umpan Balik Aspirasi',
            'user' => $this->getCurrentUser(),
            'flash' => $this->getFlash(),
            'aspirasi' => array_values($aspirasi),
            'filter' => $filter
        ]);
    }
    
    /**
     * Update feedback from feedback page
     */
    public function updateFeedback(): void {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?page=admin/feedback');
            return;
        }
        
        $idPelaporan = (int) $this->post('id_pelaporan');
        $status = $this->post('status');
        $feedback = $this->post('feedback') ?? '';
        
        $this->aspirasiModel->updateStatusAndFeedback($idPelaporan, $status, $feedback);
        
        $this->setFlash('success', 'Feedback berhasil disimpan');
        $this->redirect('index.php?page=admin/feedback');
    }
    
    /**
     * Daftar Siswa
     */
    public function siswaIndex(): void {
        $this->requireAdmin();
        
        $siswa = $this->siswaModel->getAllWithAspirasiCount();
        
        $this->view('admin/siswa/index', [
            'title' => 'Data Siswa',
            'user' => $this->getCurrentUser(),
            'flash' => $this->getFlash(),
            'siswa' => $siswa
        ]);
    }
    
    /**
     * Tambah Siswa
     */
    public function siswaStore(): void {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?page=admin/siswa');
            return;
        }
        
        $nis = (int) $this->post('nis');
        $nama = $this->post('nama');
        $kelas = $this->post('kelas');
        $password = $this->post('password');
        
        if (!$nis || !$nama || !$kelas || !$password) {
            $this->setFlash('error', 'Semua field harus diisi');
            $this->redirect('index.php?page=admin/siswa');
            return;
        }
        
        // Check if NIS already exists
        if ($this->siswaModel->find($nis)) {
            $this->setFlash('error', 'NIS sudah terdaftar');
            $this->redirect('index.php?page=admin/siswa');
            return;
        }
        
        $result = $this->siswaModel->register([
            'nis' => $nis,
            'nama' => $nama,
            'kelas' => $kelas,
            'password' => $password
        ]);
        
        if ($result) {
            $this->setFlash('success', 'Siswa berhasil ditambahkan');
        } else {
            $this->setFlash('error', 'Gagal menambahkan siswa');
        }
        
        $this->redirect('index.php?page=admin/siswa');
    }
    
    /**
     * Update Siswa
     */
    public function siswaUpdate(): void {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?page=admin/siswa');
            return;
        }
        
        $nis = (int) $this->post('nis');
        $nama = $this->post('nama');
        $kelas = $this->post('kelas');
        $password = $this->post('password');
        
        $data = ['nama' => $nama, 'kelas' => $kelas];
        
        if ($password) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        
        $this->siswaModel->update($nis, $data);
        
        $this->setFlash('success', 'Data siswa berhasil diupdate');
        $this->redirect('index.php?page=admin/siswa');
    }
    
    /**
     * Hapus Siswa
     */
    public function siswaDelete(): void {
        $this->requireAdmin();
        
        $nis = (int) $this->get('nis');
        
        // Check if siswa has aspirasi
        $siswa = $this->siswaModel->getWithAspirasiCount($nis);
        if ($siswa && $siswa['jumlah_aspirasi'] > 0) {
            $this->setFlash('error', 'Tidak dapat menghapus siswa yang memiliki aspirasi');
            $this->redirect('index.php?page=admin/siswa');
            return;
        }
        
        $this->siswaModel->delete($nis);
        
        $this->setFlash('success', 'Siswa berhasil dihapus');
        $this->redirect('index.php?page=admin/siswa');
    }
}
