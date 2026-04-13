<?php 
$currentPage = 'create';
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar_siswa.php';
?>

<div style="max-width: 800px;">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Aspirasi Baru</h3>
        </div>
        <div class="card-body">
            <form action="<?= BASE_URL ?>index.php?page=siswa/aspirasi/store" method="POST">
                <div class="form-group">
                    <label class="form-label">Kategori Aspirasi <span class="text-danger">*</span></label>
                    <select name="id_kategori" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($kategori as $kat): ?>
                            <option value="<?= $kat['id_kategori'] ?>">
                                <?= htmlspecialchars($kat['ket_kategori']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-secondary">Pilih kategori yang sesuai dengan aspirasi Anda</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                    <input type="text" name="lokasi" class="form-control" 
                           placeholder="Contoh: Ruang Kelas XII IPA 1, Lapangan Sekolah, dll" 
                           required maxlength="50">
                    <small class="text-secondary">Masukkan lokasi terkait aspirasi Anda</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Keterangan / Isi Aspirasi <span class="text-danger">*</span></label>
                    <textarea name="ket" class="form-control" rows="6" 
                              placeholder="Jelaskan aspirasi Anda secara detail..." required></textarea>
                    <small class="text-secondary">Jelaskan aspirasi Anda dengan jelas dan lengkap</small>
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <div>
                        <strong>Informasi:</strong><br>
                        Aspirasi Anda akan ditinjau oleh admin. Anda dapat memantau status aspirasi melalui menu "Aspirasi Saya".
                    </div>
                </div>
                
                <div style="display: flex; gap: 12px;">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-paper-plane"></i> Kirim Aspirasi
                    </button>
                    <a href="<?= BASE_URL ?>index.php?page=siswa/dashboard" class="btn btn-secondary btn-lg">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

    </div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
