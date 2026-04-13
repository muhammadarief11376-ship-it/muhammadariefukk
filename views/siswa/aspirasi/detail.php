<?php 
$currentPage = 'aspirasi';
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar_siswa.php';
?>

<!-- Breadcrumb -->
<div class="mb-3">
    <a href="<?= BASE_URL ?>index.php?page=siswa/aspirasi" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Aspirasi #<?= $detail['id_pelaporan'] ?></h3>
        <span class="badge badge-<?= strtolower($detail['status']) ?>">
            <?= $detail['status'] ?>
        </span>
    </div>
    <div class="card-body">
        <!-- Progress Steps -->
        <div class="progress-steps">
            <div class="progress-step <?= $detail['status'] === 'Menunggu' ? 'active' : 'completed' ?>">
                <div class="progress-step-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <span class="progress-step-label">Menunggu</span>
            </div>
            <div class="progress-step <?= $detail['status'] === 'Proses' ? 'active' : ($detail['status'] === 'Selesai' ? 'completed' : '') ?>">
                <div class="progress-step-icon">
                    <i class="fas fa-spinner"></i>
                </div>
                <span class="progress-step-label">Proses</span>
            </div>
            <div class="progress-step <?= $detail['status'] === 'Selesai' ? 'active' : '' ?>">
                <div class="progress-step-icon">
                    <i class="fas fa-check"></i>
                </div>
                <span class="progress-step-label">Selesai</span>
            </div>
        </div>
        
        <div class="detail-grid">
            <div class="detail-item">
                <div class="detail-label">Tanggal Pengajuan</div>
                <div class="detail-value"><?= date('d F Y, H:i', strtotime($detail['tanggal_input'])) ?></div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Terakhir Update</div>
                <div class="detail-value">
                    <?= $detail['tanggal_update'] ? date('d F Y, H:i', strtotime($detail['tanggal_update'])) : '-' ?>
                </div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Kategori</div>
                <div class="detail-value"><?= htmlspecialchars($detail['ket_kategori']) ?></div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Lokasi</div>
                <div class="detail-value"><?= htmlspecialchars($detail['lokasi']) ?></div>
            </div>
            
            <div class="detail-item full-width">
                <div class="detail-label">Keterangan / Isi Aspirasi</div>
                <div class="detail-value" style="white-space: pre-wrap;"><?= htmlspecialchars($detail['ket']) ?></div>
            </div>
        </div>
        
        <!-- Feedback Section -->
        <?php if ($detail['feedback']): ?>
            <div class="mt-4">
                <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 12px;">
                    <i class="fas fa-comment-dots text-success"></i> Feedback / Tanggapan
                </h4>
                <div style="background: var(--success-light); padding: 20px; border-radius: var(--border-radius-sm); border-left: 4px solid var(--success-color);">
                    <p style="white-space: pre-wrap; margin: 0;"><?= htmlspecialchars($detail['feedback']) ?></p>
                </div>
            </div>
        <?php else: ?>
            <div class="mt-4">
                <div class="alert alert-info" style="margin-bottom: 0;">
                    <i class="fas fa-info-circle"></i>
                    <div>
                        <strong>Menunggu Feedback</strong><br>
                        Aspirasi Anda sedang dalam proses. Feedback akan muncul di sini setelah admin memberikan tanggapan.
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

    </div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
