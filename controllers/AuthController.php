<?php
/**
 * Auth Controller
 * Handle login dan logout
 */

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ . '/../models/Siswa.php';

class AuthController extends Controller {
    private $adminModel;
    private $siswaModel;
    
    public function __construct() {
        $this->adminModel = new Admin();
        $this->siswaModel = new Siswa();
    }
    
    /**
     * Tampilkan halaman login
     */
    public function showLogin(): void {
        // Jika sudah login, redirect ke dashboard
        if ($this->isLoggedIn()) {
            if ($this->isAdmin()) {
                $this->redirect('index.php?page=admin/dashboard');
            } else {
                $this->redirect('index.php?page=siswa/dashboard');
            }
        }
        
        $flash = $this->getFlash();
        $this->view('auth/login', ['flash' => $flash]);
    }
    
    /**
     * Proses login
     */
    public function login(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?page=login');
            return;
        }
        
        $userType = $this->post('user_type');
        $password = $_POST['password'] ?? ''; // Jangan sanitize password
        
        if ($userType === 'admin') {
            $username = $this->post('username');
            $user = $this->adminModel->login($username, $password);
            
            if ($user) {
                $_SESSION['user'] = [
                    'id' => $user['id_admin'],
                    'username' => $user['username'],
                    'nama' => $user['nama_lengkap'],
                    'role' => 'admin'
                ];
                $this->setFlash('success', 'Selamat datang, ' . $user['nama_lengkap']);
                $this->redirect('index.php?page=admin/dashboard');
            } else {
                $this->setFlash('error', 'Username atau password salah');
                $this->redirect('index.php?page=login');
            }
        } else {
            $nis = (int) $this->post('nis');
            $user = $this->siswaModel->login($nis, $password);
            
            if ($user) {
                $_SESSION['user'] = [
                    'id' => $user['nis'],
                    'nis' => $user['nis'],
                    'nama' => $user['nama'],
                    'kelas' => $user['kelas'],
                    'role' => 'siswa'
                ];
                $this->setFlash('success', 'Selamat datang, ' . $user['nama']);
                $this->redirect('index.php?page=siswa/dashboard');
            } else {
                $this->setFlash('error', 'NIS atau password salah');
                $this->redirect('index.php?page=login');
            }
        }
    }
    
    /**
     * Logout
     */
    public function logout(): void {
        session_destroy();
        session_start();
        $this->setFlash('success', 'Anda telah berhasil logout');
        $this->redirect('index.php?page=login');
    }
}
