<?php 
$currentPage = 'dashboard';
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar_admin.php';
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

<!-- Content Grid -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    <!-- Recent Aspirasi -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Aspirasi Terbaru</h3>
            <a href="<?= BASE_URL ?>index.php?page=admin/aspirasi" class="btn btn-secondary btn-sm">
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
                                <th>Siswa</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentAspirasi as $item): ?>
                                <tr>
                                    <td><?= date('d/m/Y', strtotime($item['tanggal_input'])) ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($item['nama_siswa']) ?></strong><br>
                                        <small class="text-secondary"><?= htmlspecialchars($item['kelas']) ?></small>
                                    </td>
                                    <td><?= htmlspecialchars($item['ket_kategori']) ?></td>
                                    <td>
                                        <span class="badge badge-<?= strtolower($item['status']) ?>">
                                            <?= $item['status'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= BASE_URL ?>index.php?page=admin/aspirasi/detail&id=<?= $item['id_pelaporan'] ?>" 
                                           class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye"></i>
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
                    <p class="empty-state-text">Aspirasi dari siswa akan muncul di sini</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Statistik per Kategori -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Berdasarkan Kategori</h3>
        </div>
        <div class="card-body">
            <?php if (!empty($statisticsByKategori)): ?>
                <?php foreach ($statisticsByKategori as $kat): ?>
                    <div style="margin-bottom: 16px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                            <span><?= htmlspecialchars($kat['ket_kategori']) ?></span>
                            <span class="text-secondary"><?= $kat['jumlah'] ?></span>
                        </div>
                        <div style="height: 8px; background: var(--bg-primary); border-radius: 4px; overflow: hidden;">
                            <?php 
                            $maxJumlah = max(array_column($statisticsByKategori, 'jumlah'));
                            $percentage = $maxJumlah > 0 ? ($kat['jumlah'] / $maxJumlah) * 100 : 0;
                            ?>
                            <div style="height: 100%; width: <?= $percentage ?>%; background: var(--primary-color); border-radius: 4px;"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-secondary text-center">Belum ada data</p>
            <?php endif; ?>
        </div>
    </div>
</div>

    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
