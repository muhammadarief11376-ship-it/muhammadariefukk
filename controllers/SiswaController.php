<?php
/**
 * Siswa Controller
 * Handle semua aksi siswa
 */

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/InputAspirasi.php';
require_once __DIR__ . '/../models/Aspirasi.php';
require_once __DIR__ . '/../models/Kategori.php';

class SiswaController extends Controller {
    private $inputAspirasiModel;
    private $aspirasiModel;
    private $kategoriModel;
    
    public function __construct() {
        $this->inputAspirasiModel = new InputAspirasi();
        $this->aspirasiModel = new Aspirasi();
        $this->kategoriModel = new Kategori();
    }
    
    /**
     * Dashboard Siswa
     */
    public function dashboard(): void {
        $this->requireSiswa();
        
        $user = $this->getCurrentUser();
        $aspirasi = $this->inputAspirasiModel->getByNis($user['nis']);
        
        // Hitung statistik
        $statistics = [
            'total' => count($aspirasi),
            'menunggu' => 0,
            'proses' => 0,
            'selesai' => 0
        ];
        
        foreach ($aspirasi as $item) {
            if ($item['status'] === 'Menunggu') $statistics['menunggu']++;
            elseif ($item['status'] === 'Proses') $statistics['proses']++;
            elseif ($item['status'] === 'Selesai') $statistics['selesai']++;
        }
        
        // Ambil 5 aspirasi terbaru
        $recentAspirasi = array_slice($aspirasi, 0, 5);
        
        $this->view('siswa/dashboard', [
            'title' => 'Dashboard Siswa',
            'user' => $user,
            'flash' => $this->getFlash(),
            'statistics' => $statistics,
            'recentAspirasi' => $recentAspirasi
        ]);
    }
    
    /**
     * Form input aspirasi baru
     */
    public function aspirasiCreate(): void {
        $this->requireSiswa();
        
        $kategori = $this->kategoriModel->findAll('ket_kategori', 'ASC');
        
        $this->view('siswa/aspirasi/create', [
            'title' => 'Buat Aspirasi Baru',
            'user' => $this->getCurrentUser(),
            'flash' => $this->getFlash(),
            'kategori' => $kategori
        ]);
    }
    
    /**
     * Simpan aspirasi baru
     */
    public function aspirasiStore(): void {
        $this->requireSiswa();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?page=siswa/aspirasi/create');
            return;
        }
        
        $user = $this->getCurrentUser();
        
        $data = [
            'nis' => $user['nis'],
            'id_kategori' => (int) $this->post('id_kategori'),
            'lokasi' => $this->post('lokasi'),
            'ket' => $this->post('ket')
        ];
        
        // Validasi
        if (empty($data['id_kategori']) || empty($data['lokasi']) || empty($data['ket'])) {
            $this->setFlash('error', 'Semua field harus diisi');
            $this->redirect('index.php?page=siswa/aspirasi/create');
            return;
        }
        
        $this->inputAspirasiModel->createWithStatus($data);
        
        $this->setFlash('success', 'Aspirasi berhasil dikirim');
        $this->redirect('index.php?page=siswa/aspirasi');
    }
    
    /**
     * List aspirasi milik siswa
     */
    public function aspirasiIndex(): void {
        $this->requireSiswa();
        
        $user = $this->getCurrentUser();
        
        // Get filter
        $filters = ['nis' => $user['nis']];
        
        if ($this->get('status')) {
            $filters['status'] = $this->get('status');
        }
        
        $aspirasi = $this->inputAspirasiModel->getAllWithDetail($filters);
        
        $this->view('siswa/aspirasi/index', [
            'title' => 'Aspirasi Saya',
            'user' => $user,
            'flash' => $this->getFlash(),
            'aspirasi' => $aspirasi,
            'currentFilter' => $this->get('status')
        ]);
    }
    
    /**
     * Detail aspirasi siswa
     */
    public function aspirasiDetail(): void {
        $this->requireSiswa();
        
        $user = $this->getCurrentUser();
        $id = (int) $this->get('id');
        $detail = $this->inputAspirasiModel->getDetail($id);
        
        // Pastikan aspirasi milik siswa yang sedang login
        if (!$detail || $detail['nis'] != $user['nis']) {
            $this->setFlash('error', 'Aspirasi tidak ditemukan');
            $this->redirect('index.php?page=siswa/aspirasi');
            return;
        }
        
        $this->view('siswa/aspirasi/detail', [
            'title' => 'Detail Aspirasi',
            'user' => $user,
            'flash' => $this->getFlash(),
            'detail' => $detail
        ]);
    }
    
    /**
     * History Aspirasi Siswa - Timeline view
     */
    public function history(): void {
        $this->requireSiswa();
        
        $user = $this->getCurrentUser();
        $filter = $this->get('filter');
        
        $filters = ['nis' => $user['nis']];
        if ($filter) {
            $filters['status'] = $filter;
        }
        
        $aspirasi = $this->inputAspirasiModel->getAllWithDetail($filters);
        
        $this->view('siswa/history/index', [
            'title' => 'History Aspirasi Saya',
            'user' => $user,
            'flash' => $this->getFlash(),
            'aspirasi' => $aspirasi,
            'filter' => $filter
        ]);
    }
}
