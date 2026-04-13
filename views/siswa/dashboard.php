<?php 
$currentPage = 'dashboard';
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar_siswa.php';
?>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon primary">
            <i class="fas fa-clipboard-list"></i>
        </div>
        <div class="stat-info">
            <h3><?= $statistics['total'] ?? 0 ?></h3>
            <p>Total Aspirasi</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon warning">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info">
            <h3><?= $statistics['menunggu'] ?? 0 ?></h3>
            <p>Menunggu</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon info">
            <i class="fas fa-spinner"></i>
        </div>
        <div class="stat-info">
            <h3><?= $statistics['proses'] ?? 0 ?></h3>
            <p>Dalam Proses</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon success">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-info">
            <h3><?= $statistics['selesai'] ?? 0 ?></h3>
            <p>Selesai</p>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card mb-3">
    <div class="card-body">
        <div style="display: flex; gap: 16px; flex-wrap: wrap;">
            <a href="<?= BASE_URL ?>index.php?page=siswa/aspirasi/create" class="btn btn-primary btn-lg">
                <i class="fas fa-plus-circle"></i> Buat Aspirasi Baru
            </a>
            <a href="<?= BASE_URL ?>index.php?page=siswa/aspirasi" class="btn btn-secondary btn-lg">
                <i class="fas fa-list-alt"></i> Lihat Semua Aspirasi
            </a>
        </div>
    </div>
</div>

<!-- Recent Aspirasi -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Aspirasi Terbaru Saya</h3>
        <a href="<?= BASE_URL ?>index.php?page=siswa/aspirasi" class="btn btn-secondary btn-sm">
            Lihat Semua
        </a>
    </div>
    <div class="card-body" style="padding: 0;">
        <?php if (!empty($recentAspirasi)): ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentAspirasi as $item): ?>
                            <tr>
                                <td>
                                    <?= date('d/m/Y', strtotime($item['tanggal_input'])) ?><br>
                                    <small class="text-secondary"><?= date('H:i', strtotime($item['tanggal_input'])) ?></small>
                                </td>
                                <td><?= htmlspecialchars($item['ket_kategori']) ?></td>
                                <td><?= htmlspecialchars($item['lokasi']) ?></td>
                                <td>
                                    <span class="badge badge-<?= strtolower($item['status']) ?>">
                                        <?= $item['status'] ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= BASE_URL ?>index.php?page=siswa/aspirasi/detail&id=<?= $item['id_pelaporan'] ?>" 
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-inbox"></i>
                </div>
                <h4 class="empty-state-title">Belum ada aspirasi</h4>
                <p class="empty-state-text">Anda belum pernah mengirimkan aspirasi</p>
                <a href="<?= BASE_URL ?>index.php?page=siswa/aspirasi/create" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Buat Aspirasi Baru
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
