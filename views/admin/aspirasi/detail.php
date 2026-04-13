<?php 
$currentPage = 'aspirasi';
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar_admin.php';
?>

<!-- Breadcrumb -->
<div class="mb-3">
    <a href="<?= BASE_URL ?>index.php?page=admin/aspirasi" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
    </a>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    <!-- Detail Aspirasi -->
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
                    <div class="detail-label">Tanggal Laporan</div>
                    <div class="detail-value"><?= date('d F Y, H:i', strtotime($detail['tanggal_input'])) ?></div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Terakhir Update</div>
                    <div class="detail-value">
                        <?= $detail['tanggal_update'] ? date('d F Y, H:i', strtotime($detail['tanggal_update'])) : '-' ?>
                    </div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Nama Siswa</div>
                    <div class="detail-value"><?= htmlspecialchars($detail['nama_siswa']) ?></div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">NIS / Kelas</div>
                    <div class="detail-value"><?= $detail['nis'] ?> / <?= htmlspecialchars($detail['kelas']) ?></div>
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
                
                <?php if ($detail['feedback']): ?>
                    <div class="detail-item full-width">
                        <div class="detail-label">Feedback / Tanggapan</div>
                        <div class="detail-value" style="white-space: pre-wrap; background: var(--success-light); padding: 16px; border-radius: 8px; margin-top: 8px;">
                            <?= htmlspecialchars($detail['feedback']) ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Update Status Form -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Update Status</h3>
        </div>
        <div class="card-body">
            <form action="<?= BASE_URL ?>index.php?page=admin/aspirasi/update" method="POST">
                <input type="hidden" name="id_pelaporan" value="<?= $detail['id_pelaporan'] ?>">
                
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Menunggu" <?= $detail['status'] === 'Menunggu' ? 'selected' : '' ?>>
                            Menunggu
                        </option>
                        <option value="Proses" <?= $detail['status'] === 'Proses' ? 'selected' : '' ?>>
                            Proses
                        </option>
                        <option value="Selesai" <?= $detail['status'] === 'Selesai' ? 'selected' : '' ?>>
                            Selesai
                        </option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Feedback / Tanggapan</label>
                    <textarea name="feedback" class="form-control" rows="6" 
                              placeholder="Berikan tanggapan atau feedback untuk aspirasi ini..."><?= htmlspecialchars($detail['feedback'] ?? '') ?></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>

    </div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
