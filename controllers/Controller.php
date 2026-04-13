<?php
/**
 * Base Controller Class
 */

require_once __DIR__ . '/../config/config.php';

abstract class Controller {
    
    /**
     * Load view file
     * @param string $view Path ke file view (tanpa .php)
     * @param array $data Data yang akan dikirim ke view
     */
    protected function view(string $view, array $data = []): void {
        // Extract data menjadi variabel
        extract($data);
        
        // Path ke file view
        $viewFile = __DIR__ . '/../views/' . $view . '.php';
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View file tidak ditemukan: " . $view);
        }
    }
    
    /**
     * Redirect ke halaman lain
     * @param string $url
     */
    protected function redirect(string $url): void {
        header("Location: " . BASE_URL . $url);
        exit;
    }
    
    /**
     * Set flash message
     * @param string $type success, error, warning, info
     * @param string $message
     */
    protected function setFlash(string $type, string $message): void {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }
    
    /**
     * Get flash message dan hapus dari session
     * @return array|null
     */
    protected function getFlash(): ?array {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }
    
    /**
     * Cek apakah user sudah login
     * @return bool
     */
    protected function isLoggedIn(): bool {
        return isset($_SESSION['user']);
    }
    
    /**
     * Cek apakah user adalah admin
     * @return bool
     */
    protected function isAdmin(): bool {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }
    
    /**
     * Cek apakah user adalah siswa
     * @return bool
     */
    protected function isSiswa(): bool {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'siswa';
    }
    
    /**
     * Require login
     */
    protected function requireLogin(): void {
        if (!$this->isLoggedIn()) {
            $this->setFlash('error', 'Silakan login terlebih dahulu');
            $this->redirect('index.php?page=login');
        }
    }
    
    /**
     * Require admin role
     */
    protected function requireAdmin(): void {
        $this->requireLogin();
        if (!$this->isAdmin()) {
            $this->setFlash('error', 'Anda tidak memiliki akses ke halaman ini');
            $this->redirect('index.php?page=login');
        }
    }
    
    /**
     * Require siswa role
     */
    protected function requireSiswa(): void {
        $this->requireLogin();
        if (!$this->isSiswa()) {
            $this->setFlash('error', 'Anda tidak memiliki akses ke halaman ini');
            $this->redirect('index.php?page=login');
        }
    }
    
    /**
     * Get current user data
     * @return array|null
     */
    protected function getCurrentUser(): ?array {
        return $_SESSION['user'] ?? null;
    }
    
    /**
     * Sanitize input
     * @param string $input
     * @return string
     */
    protected function sanitize(string $input): string {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Get POST data
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    protected function post(string $key, $default = null) {
        return isset($_POST[$key]) ? $this->sanitize($_POST[$key]) : $default;
    }
    
    /**
     * Get GET data
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    protected function get(string $key, $default = null) {
        return isset($_GET[$key]) ? $this->sanitize($_GET[$key]) : $default;
    }
}
