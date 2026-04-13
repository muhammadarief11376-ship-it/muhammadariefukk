<?php 
$currentPage = 'aspirasi';
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar_siswa.php';
?>

<!-- Filter Tabs -->
<div style="display: flex; gap: 12px; margin-bottom: 24px; flex-wrap: wrap;">
    <a href="<?= BASE_URL ?>index.php?page=siswa/aspirasi" 
       class="btn <?= empty($currentFilter) ? 'btn-primary' : 'btn-secondary' ?>">
        Semua
    </a>
    <a href="<?= BASE_URL ?>index.php?page=siswa/aspirasi&status=Menunggu" 
       class="btn <?= $currentFilter === 'Menunggu' ? 'btn-primary' : 'btn-secondary' ?>">
        <i class="fas fa-clock"></i> Menunggu
    </a>
    <a href="<?= BASE_URL ?>index.php?page=siswa/aspirasi&status=Proses" 
       class="btn <?= $currentFilter === 'Proses' ? 'btn-primary' : 'btn-secondary' ?>">
        <i class="fas fa-spinner"></i> Proses
    </a>
    <a href="<?= BASE_URL ?>index.php?page=siswa/aspirasi&status=Selesai" 
       class="btn <?= $currentFilter === 'Selesai' ? 'btn-primary' : 'btn-secondary' ?>">
        <i class="fas fa-check-circle"></i> Selesai
    </a>
</div>

<!-- Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Aspirasi Saya (<?= count($aspirasi) ?>)</h3>
        <a href="<?= BASE_URL ?>index.php?page=siswa/aspirasi/create" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Buat Baru
        </a>
    </div>
    <div class="card-body" style="padding: 0;">
        <?php if (!empty($aspirasi)): ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Feedback</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($aspirasi as $index => $item): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
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
                                    <?php if ($item['feedback']): ?>
                                        <span class="badge badge-selesai">
                                            <i class="fas fa-comment"></i> Ada
                                        </span>
                                    <?php else: ?>
                                        <span class="text-secondary">-</span>
                                    <?php endif; ?>
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
                <h4 class="empty-state-title">Tidak ada aspirasi</h4>
                <p class="empty-state-text">
                    <?= empty($currentFilter) ? 'Anda belum pernah mengirimkan aspirasi' : 'Tidak ada aspirasi dengan status ' . $currentFilter ?>
                </p>
                <a href="<?= BASE_URL ?>index.php?page=siswa/aspirasi/create" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Buat Aspirasi Baru
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

    </div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
