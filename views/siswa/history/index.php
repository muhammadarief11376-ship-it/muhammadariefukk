<?php 
$currentPage = 'history';
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar_siswa.php';
?>

<!-- Filter Tabs -->
<div style="display: flex; gap: 12px; margin-bottom: 24px; flex-wrap: wrap;">
    <a href="<?= BASE_URL ?>index.php?page=siswa/history" 
       class="btn <?= empty($filter) ? 'btn-primary' : 'btn-secondary' ?>">
        Semua
    </a>
    <a href="<?= BASE_URL ?>index.php?page=siswa/history&filter=Menunggu" 
       class="btn <?= $filter === 'Menunggu' ? 'btn-primary' : 'btn-secondary' ?>">
        <i class="fas fa-clock"></i> Menunggu
    </a>
    <a href="<?= BASE_URL ?>index.php?page=siswa/history&filter=Proses" 
       class="btn <?= $filter === 'Proses' ? 'btn-primary' : 'btn-secondary' ?>">
        <i class="fas fa-spinner"></i> Proses
    </a>
    <a href="<?= BASE_URL ?>index.php?page=siswa/history&filter=Selesai" 
       class="btn <?= $filter === 'Selesai' ? 'btn-primary' : 'btn-secondary' ?>">
        <i class="fas fa-check-circle"></i> Selesai
    </a>
</div>

<!-- Timeline History -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-history"></i> History Aspirasi Saya (<?= count($aspirasi) ?>)
        </h3>
        <a href="<?= BASE_URL ?>index.php?page=siswa/aspirasi/create" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Buat Baru
        </a>
    </div>
    <div class="card-body">
        <?php if (!empty($aspirasi)): ?>
            <div class="timeline">
                <?php 
                $currentDate = '';
                foreach ($aspirasi as $item): 
                    $itemDate = date('d F Y', strtotime($item['tanggal_input']));
                    if ($currentDate !== $itemDate):
                        $currentDate = $itemDate;
                ?>
                    <div class="timeline-date">
                        <span class="badge badge-proses"><?= $itemDate ?></span>
                    </div>
                <?php endif; ?>
                
                <div class="timeline-item">
                    <div class="timeline-marker status-<?= strtolower($item['status']) ?>"></div>
                    <div class="timeline-content">
                        <div class="timeline-header">
                            <strong><?= htmlspecialchars($item['ket_kategori']) ?></strong>
                            <span class="badge badge-<?= strtolower($item['status']) ?>" style="margin-left: 8px;">
                                <?= $item['status'] ?>
                            </span>
                        </div>
                        <div class="timeline-body">
                            <p><strong>Lokasi:</strong> <?= htmlspecialchars($item['lokasi']) ?></p>
                            <p><?= htmlspecialchars(substr($item['ket'], 0, 150)) ?><?= strlen($item['ket']) > 150 ? '...' : '' ?></p>
                            <?php if ($item['feedback']): ?>
                                <div class="feedback-box">
                                    <strong><i class="fas fa-comment-dots"></i> Feedback:</strong><br>
                                    <?= htmlspecialchars(substr($item['feedback'], 0, 100)) ?><?= strlen($item['feedback']) > 100 ? '...' : '' ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="timeline-footer">
                            <small class="text-secondary">
                                <i class="fas fa-clock"></i> <?= date('H:i', strtotime($item['tanggal_input'])) ?>
                                <?php if ($item['tanggal_update']): ?>
                                    | <i class="fas fa-sync-alt"></i> Update: <?= date('d/m/Y H:i', strtotime($item['tanggal_update'])) ?>
                                <?php endif; ?>
                            </small>
                            <a href="<?= BASE_URL ?>index.php?page=siswa/aspirasi/detail&id=<?= $item['id_pelaporan'] ?>" 
                               class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-history"></i>
                </div>
                <h4 class="empty-state-title">Belum ada history</h4>
                <p class="empty-state-text">Anda belum pernah membuat aspirasi</p>
                <a href="<?= BASE_URL ?>index.php?page=siswa/aspirasi/create" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Buat Aspirasi Baru
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 10px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--border-color);
}

.timeline-date {
    margin: 20px 0 10px -30px;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding-bottom: 24px;
}

.timeline-marker {
    position: absolute;
    left: -25px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 0 0 2px var(--border-color);
}

.timeline-marker.status-menunggu {
    background: var(--warning-color);
    box-shadow: 0 0 0 2px var(--warning-color);
}

.timeline-marker.status-proses {
    background: var(--info-color);
    box-shadow: 0 0 0 2px var(--info-color);
}

.timeline-marker.status-selesai {
    background: var(--success-color);
    box-shadow: 0 0 0 2px var(--success-color);
}

.timeline-content {
    background: var(--bg-primary);
    border-radius: var(--border-radius-sm);
    padding: 16px;
}

.timeline-header {
    margin-bottom: 8px;
}

.timeline-body p {
    margin: 4px 0;
    font-size: 14px;
}

.timeline-footer {
    margin-top: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.feedback-box {
    margin-top: 12px;
    padding: 12px;
    background: var(--success-light);
    border-radius: var(--border-radius-sm);
    border-left: 3px solid var(--success-color);
    font-size: 13px;
}
</style>

    </div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
