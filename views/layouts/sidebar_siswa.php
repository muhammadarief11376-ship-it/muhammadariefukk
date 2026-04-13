<!-- Sidebar Siswa -->
<aside class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <div class="sidebar-logo-icon">
                <i class="fas fa-bullhorn"></i>
            </div>
            <div class="sidebar-logo-text">
                <h1>Pengaduan</h1>
                <span>Portal Siswa</span>
            </div>
        </div>
    </div>
    
    <nav class="sidebar-nav">
        <div class="nav-section">
            <div class="nav-section-title">Menu Utama</div>
            <a href="<?= BASE_URL ?>index.php?page=siswa/dashboard" 
               class="nav-item <?= ($currentPage ?? '') === 'dashboard' ? 'active' : '' ?>">
                <span class="nav-item-icon"><i class="fas fa-home"></i></span>
                <span>Dashboard</span>
            </a>
            <a href="<?= BASE_URL ?>index.php?page=siswa/aspirasi/create" 
               class="nav-item <?= ($currentPage ?? '') === 'create' ? 'active' : '' ?>">
                <span class="nav-item-icon"><i class="fas fa-plus-circle"></i></span>
                <span>Buat Aspirasi</span>
            </a>
            <a href="<?= BASE_URL ?>index.php?page=siswa/aspirasi" 
               class="nav-item <?= ($currentPage ?? '') === 'aspirasi' ? 'active' : '' ?>">
                <span class="nav-item-icon"><i class="fas fa-list-alt"></i></span>
                <span>Aspirasi Saya</span>
            </a>
            <a href="<?= BASE_URL ?>index.php?page=siswa/history" 
               class="nav-item <?= ($currentPage ?? '') === 'history' ? 'active' : '' ?>">
                <span class="nav-item-icon"><i class="fas fa-history"></i></span>
                <span>History Aspirasi</span>
            </a>
        </div>
        
        <div class="nav-section">
            <div class="nav-section-title">Akun</div>
            <a href="<?= BASE_URL ?>index.php?page=logout" class="nav-item">
                <span class="nav-item-icon"><i class="fas fa-sign-out-alt"></i></span>
                <span>Logout</span>
            </a>
        </div>
    </nav>
</aside>

<!-- Main Content -->
<main class="main-content">
    <!-- Header -->
    <header class="header">
        <div class="header-title">
            <h2><?= $title ?? 'Dashboard' ?></h2>
        </div>
        <div class="header-user">
            <div class="user-info">
                <div class="user-info-name"><?= htmlspecialchars($user['nama'] ?? 'Siswa') ?></div>
                <div class="user-info-role">NIS: <?= $user['nis'] ?? '-' ?> | <?= htmlspecialchars($user['kelas'] ?? '-') ?></div>
            </div>
            <div class="user-avatar">
                <?= strtoupper(substr($user['nama'] ?? 'S', 0, 1)) ?>
            </div>
        </div>
    </header>
    
    <!-- Content -->
    <div class="content">
        <?php if (isset($flash) && $flash): ?>
            <div class="alert alert-<?= $flash['type'] ?>">
                <i class="fas fa-<?= $flash['type'] === 'success' ? 'check-circle' : ($flash['type'] === 'error' ? 'exclamation-circle' : 'info-circle') ?>"></i>
                <?= htmlspecialchars($flash['message']) ?>
            </div>
        <?php endif; ?>
