<?php
/**
 * Kategori Controller
 * Handle CRUD kategori
 */

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Kategori.php';

class KategoriController extends Controller {
    private $kategoriModel;
    
    public function __construct() {
        $this->kategoriModel = new Kategori();
    }
    
    /**
     * List semua kategori
     */
    public function index(): void {
        $this->requireAdmin();
        
        $kategori = $this->kategoriModel->getAllWithAspirasiCount();
        
        $this->view('admin/kategori/index', [
            'title' => 'Kelola Kategori',
            'user' => $this->getCurrentUser(),
            'flash' => $this->getFlash(),
            'kategori' => $kategori
        ]);
    }
    
    /**
     * Simpan kategori baru
     */
    public function store(): void {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?page=admin/kategori');
            return;
        }
        
        $ketKategori = $this->post('ket_kategori');
        
        if (empty($ketKategori)) {
            $this->setFlash('error', 'Nama kategori harus diisi');
            $this->redirect('index.php?page=admin/kategori');
            return;
        }
        
        $this->kategoriModel->create(['ket_kategori' => $ketKategori]);
        
        $this->setFlash('success', 'Kategori berhasil ditambahkan');
        $this->redirect('index.php?page=admin/kategori');
    }
    
    /**
     * Update kategori
     */
    public function update(): void {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?page=admin/kategori');
            return;
        }
        
        $id = (int) $this->post('id_kategori');
        $ketKategori = $this->post('ket_kategori');
        
        if (empty($ketKategori)) {
            $this->setFlash('error', 'Nama kategori harus diisi');
            $this->redirect('index.php?page=admin/kategori');
            return;
        }
        
        $this->kategoriModel->update($id, ['ket_kategori' => $ketKategori]);
        
        $this->setFlash('success', 'Kategori berhasil diupdate');
        $this->redirect('index.php?page=admin/kategori');
    }
    
    /**
     * Hapus kategori
     */
    public function delete(): void {
        $this->requireAdmin();
        
        $id = (int) $this->get('id');
        
        // Cek apakah kategori sedang digunakan
        if ($this->kategoriModel->isInUse($id)) {
            $this->setFlash('error', 'Kategori tidak dapat dihapus karena sedang digunakan');
            $this->redirect('index.php?page=admin/kategori');
            return;
        }
        
        $this->kategoriModel->delete($id);
        
        $this->setFlash('success', 'Kategori berhasil dihapus');
        $this->redirect('index.php?page=admin/kategori');
    }
}
