<?php 
$currentPage = 'history';
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar_admin.php';
?>

<!-- Filter Form -->
<form class="filter-form" method="GET" action="<?= BASE_URL ?>index.php">
    <input type="hidden" name="page" value="admin/history">
    
    <div class="form-group">
        <label class="form-label">Bulan</label>
        <select name="bulan" class="form-control">
            <option value="">Semua Bulan</option>
            <?php 
            $bulanNames = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                          'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            for ($i = 1; $i <= 12; $i++): 
            ?>
                <option value="<?= $i ?>" <?= ($filters['bulan'] ?? '') == $i ? 'selected' : '' ?>>
                    <?= $bulanNames[$i] ?>
                </option>
            <?php endfor; ?>
        </select>
    </div>
    
    <div class="form-group">
        <label class="form-label">Tahun</label>
        <select name="tahun" class="form-control">
            <option value="">Semua Tahun</option>
            <?php 
            $currentYear = date('Y');
            for ($i = $currentYear; $i >= $currentYear - 5; $i--): 
            ?>
                <option value="<?= $i ?>" <?= ($filters['tahun'] ?? '') == $i ? 'selected' : '' ?>>
                    <?= $i ?>
                </option>
            <?php endfor; ?>
        </select>
    </div>
    
    <div class="form-group">
        <label class="form-label">Status</label>
        <select name="status" class="form-control">
            <option value="">Semua Status</option>
            <option value="Menunggu" <?= ($filters['status'] ?? '') === 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
            <option value="Proses" <?= ($filters['status'] ?? '') === 'Proses' ? 'selected' : '' ?>>Proses</option>
            <option value="Selesai" <?= ($filters['status'] ?? '') === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
        </select>
    </div>
    
    <div class="form-group" style="display: flex; align-items: flex-end; gap: 8px;">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i> Filter
        </button>
        <a href="<?= BASE_URL ?>index.php?page=admin/history" class="btn btn-secondary">
            <i class="fas fa-times"></i> Reset
        </a>
    </div>
</form>

<!-- Timeline History -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-history"></i> History Aspirasi (<?= count($aspirasi) ?>)
        </h3>
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
                            <strong><?= htmlspecialchars($item['nama_siswa']) ?></strong>
                            <span class="text-secondary"> - <?= htmlspecialchars($item['kelas']) ?></span>
                            <span class="badge badge-<?= strtolower($item['status']) ?>" style="margin-left: 8px;">
                                <?= $item['status'] ?>
                            </span>
                        </div>
                        <div class="timeline-body">
                            <p><strong>Kategori:</strong> <?= htmlspecialchars($item['ket_kategori']) ?></p>
                            <p><strong>Lokasi:</strong> <?= htmlspecialchars($item['lokasi']) ?></p>
                            <p><?= htmlspecialchars(substr($item['ket'], 0, 150)) ?><?= strlen($item['ket']) > 150 ? '...' : '' ?></p>
                        </div>
                        <div class="timeline-footer">
                            <small class="text-secondary">
                                <i class="fas fa-clock"></i> <?= date('H:i', strtotime($item['tanggal_input'])) ?>
                            </small>
                            <a href="<?= BASE_URL ?>index.php?page=admin/aspirasi/detail&id=<?= $item['id_pelaporan'] ?>" 
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
                <h4 class="empty-state-title">Tidak ada history</h4>
                <p class="empty-state-text">Belum ada history aspirasi yang sesuai dengan filter</p>
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
</style>

    </div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
