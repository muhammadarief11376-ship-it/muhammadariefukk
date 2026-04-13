<?php 
$currentPage = 'kategori';
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar_admin.php';
?>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
    <!-- Form Tambah Kategori -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Kategori Baru</h3>
        </div>
        <div class="card-body">
            <form action="<?= BASE_URL ?>index.php?page=admin/kategori&action=store" method="POST">
                <div class="form-group">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="ket_kategori" class="form-control" 
                           placeholder="Contoh: Fasilitas, Kegiatan, dll" required maxlength="30">
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Kategori
                </button>
            </form>
        </div>
    </div>
    
    <!-- Daftar Kategori -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Kategori</h3>
        </div>
        <div class="card-body" style="padding: 0;">
            <?php if (!empty($kategori)): ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Jumlah Aspirasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kategori as $index => $kat): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <form action="<?= BASE_URL ?>index.php?page=admin/kategori&action=update" method="POST" 
                                              style="display: flex; gap: 8px;" id="form-edit-<?= $kat['id_kategori'] ?>">
                                            <input type="hidden" name="id_kategori" value="<?= $kat['id_kategori'] ?>">
                                            <input type="text" name="ket_kategori" class="form-control" 
                                                   value="<?= htmlspecialchars($kat['ket_kategori']) ?>" 
                                                   style="padding: 6px 12px;" required maxlength="30">
                                        </form>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?= $kat['jumlah_aspirasi'] > 0 ? 'proses' : 'menunggu' ?>">
                                            <?= $kat['jumlah_aspirasi'] ?> aspirasi
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button type="submit" form="form-edit-<?= $kat['id_kategori'] ?>" 
                                                    class="btn btn-success btn-sm" title="Simpan">
                                                <i class="fas fa-save"></i>
                                            </button>
                                            <?php if ($kat['jumlah_aspirasi'] == 0): ?>
                                                <a href="<?= BASE_URL ?>index.php?page=admin/kategori&action=delete&id=<?= $kat['id_kategori'] ?>" 
                                                   class="btn btn-danger btn-sm" title="Hapus"
                                                   onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            <?php else: ?>
                                                <button class="btn btn-secondary btn-sm" title="Tidak dapat dihapus" disabled>
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <h4 class="empty-state-title">Belum ada kategori</h4>
                    <p class="empty-state-text">Tambahkan kategori baru menggunakan form di samping</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

    </div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
