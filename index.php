<?php
/**
 * Sistem Pengaduan/Aspirasi Siswa
 * Entry Point & Router
 */

// Load config
require_once __DIR__ . '/config/config.php';

// Load controllers
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/AdminController.php';
require_once __DIR__ . '/controllers/SiswaController.php';
require_once __DIR__ . '/controllers/KategoriController.php';

// Get page parameter
$page = $_GET['page'] ?? 'login';
$action = $_GET['action'] ?? 'index';

// Router
switch ($page) {
    // ============================================
    // Auth Routes
    //  
    case 'login':
        $controller = new AuthController();
        if ($action === 'login') {
            $controller->login();
        } else {
            $controller->showLogin();
        }
        break;
        
    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;
    
    // ============================================
    // Admin Routes
    // ============================================
    case 'admin/dashboard':
        $controller = new AdminController();
        $controller->dashboard();
        break;
        
    case 'admin/aspirasi':
        $controller = new AdminController();
        $controller->aspirasiIndex();
        break;
        
    case 'admin/aspirasi/detail':
        $controller = new AdminController();
        $controller->aspirasiDetail();
        break;
        
    case 'admin/aspirasi/update':
        $controller = new AdminController();
        $controller->updateStatus();
        break;
    
    case 'admin/history':
        $controller = new AdminController();
        $controller->history();
        break;
    
    case 'admin/feedback':
        $controller = new AdminController();
        if ($action === 'update') {
            $controller->updateFeedback();
        } else {
            $controller->feedback();
        }
        break;
    
    case 'admin/siswa':
        $controller = new AdminController();
        switch ($action) {
            case 'store':
                $controller->siswaStore();
                break;
            case 'update':
                $controller->siswaUpdate();
                break;
            case 'delete':
                $controller->siswaDelete();
                break;
            default:
                $controller->siswaIndex();
                break;
        }
        break;
        
    case 'admin/kategori':
        $controller = new KategoriController();
        switch ($action) {
            case 'store':
                $controller->store();
                break;
            case 'update':
                $controller->update();
                break;
            case 'delete':
                $controller->delete();
                break;
            default:
                $controller->index();
                break;
        }
        break;
    
    // ============================================
    // Siswa Routes
    // ============================================
    case 'siswa/dashboard':
        $controller = new SiswaController();
        $controller->dashboard();
        break;
        
    case 'siswa/aspirasi':
        $controller = new SiswaController();
        $controller->aspirasiIndex();
        break;
        
    case 'siswa/aspirasi/create':
        $controller = new SiswaController();
        $controller->aspirasiCreate();
        break;
        
    case 'siswa/aspirasi/store':
        $controller = new SiswaController();
        $controller->aspirasiStore();
        break;
        
    case 'siswa/aspirasi/detail':
        $controller = new SiswaController();
        $controller->aspirasiDetail();
        break;
    
    case 'siswa/history':
        $controller = new SiswaController();
        $controller->history();
        break;
    
    // ============================================
    // Default - Redirect to login
    // ============================================
    default:
        header("Location: " . BASE_URL . "index.php?page=login");
        exit;
}

