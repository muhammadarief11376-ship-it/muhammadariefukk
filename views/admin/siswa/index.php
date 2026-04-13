<?php 
$currentPage = 'siswa';
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar_admin.php';
?>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
    <!-- Form Tambah Siswa -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-user-plus"></i> Tambah Siswa Baru
            </h3>
        </div>
        <div class="card-body">
            <form action="<?= BASE_URL ?>index.php?page=admin/siswa&action=store" method="POST">
                <div class="form-group">
                    <label class="form-label">NIS <span class="text-danger">*</span></label>
                    <input type="number" name="nis" class="form-control" placeholder="Contoh: 2024001" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama lengkap siswa" required maxlength="100">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Kelas <span class="text-danger">*</span></label>
                    <input type="text" name="kelas" class="form-control" placeholder="Contoh: XII IPA 1" required maxlength="10">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" placeholder="Password untuk login" required minlength="6">
                    <small class="text-secondary">Minimal 6 karakter</small>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-plus"></i> Tambah Siswa
                </button>
            </form>
        </div>
    </div>
    
    <!-- Daftar Siswa -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-user-graduate"></i> Daftar Siswa (<?= count($siswa) ?>)
            </h3>
        </div>
        <div class="card-body" style="padding: 0;">
            <?php if (!empty($siswa)): ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Jumlah Aspirasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($siswa as $index => $s): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><strong><?= $s['nis'] ?></strong></td>
                                    <td><?= htmlspecialchars($s['nama']) ?></td>
                                    <td><?= htmlspecialchars($s['kelas']) ?></td>
                                    <td>
                                        <span class="badge badge-<?= $s['jumlah_aspirasi'] > 0 ? 'proses' : 'menunggu' ?>">
                                            <?= $s['jumlah_aspirasi'] ?> aspirasi
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button type="button" class="btn btn-warning btn-sm" 
                                                    onclick="openEditModal(<?= $s['nis'] ?>, '<?= htmlspecialchars(addslashes($s['nama'])) ?>', '<?= htmlspecialchars(addslashes($s['kelas'])) ?>')"
                                                    title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <?php if ($s['jumlah_aspirasi'] == 0): ?>
                                                <a href="<?= BASE_URL ?>index.php?page=admin/siswa&action=delete&nis=<?= $s['nis'] ?>" 
                                                   class="btn btn-danger btn-sm" title="Hapus"
                                                   onclick="return confirm('Yakin ingin menghapus siswa ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            <?php else: ?>
                                                <button class="btn btn-secondary btn-sm" title="Tidak dapat dihapus (memiliki aspirasi)" disabled>
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
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h4 class="empty-state-title">Belum ada data siswa</h4>
                    <p class="empty-state-text">Tambahkan siswa baru menggunakan form di samping</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Edit Siswa -->
<div id="editModal" class="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title">Edit Data Siswa</h3>
            <button class="modal-close" onclick="closeEditModal()">&times;</button>
        </div>
        <form action="<?= BASE_URL ?>index.php?page=admin/siswa&action=update" method="POST">
            <div class="modal-body">
                <input type="hidden" id="edit_nis" name="nis">
                
                <div class="form-group">
                    <label class="form-label">NIS</label>
                    <input type="text" id="edit_nis_display" class="form-control" disabled>
                    <small class="text-secondary">NIS tidak dapat diubah</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" id="edit_nama" name="nama" class="form-control" required maxlength="100">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Kelas <span class="text-danger">*</span></label>
                    <input type="text" id="edit_kelas" name="kelas" class="form-control" required maxlength="10">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah" minlength="6">
                    <small class="text-secondary">Kosongkan jika tidak ingin mengubah password</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(nis, nama, kelas) {
    document.getElementById('edit_nis').value = nis;
    document.getElementById('edit_nis_display').value = nis;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_kelas').value = kelas;
    document.getElementById('editModal').classList.add('active');
}

function closeEditModal() {
    document.getElementById('editModal').classList.remove('active');
}

// Close modal when clicking outside
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});
</script>

    </div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
