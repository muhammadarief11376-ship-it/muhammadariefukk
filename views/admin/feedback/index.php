<?php 
$currentPage = 'feedback';
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar_admin.php';
?>

<!-- Filter Tabs -->
<div style="display: flex; gap: 12px; margin-bottom: 24px; flex-wrap: wrap;">
    <a href="<?= BASE_URL ?>index.php?page=admin/feedback" 
       class="btn <?= empty($filter) ? 'btn-primary' : 'btn-secondary' ?>">
        Semua
    </a>
    <a href="<?= BASE_URL ?>index.php?page=admin/feedback&filter=belum" 
       class="btn <?= $filter === 'belum' ? 'btn-primary' : 'btn-secondary' ?>">
        <i class="fas fa-clock"></i> Belum Diberi Feedback
    </a>
    <a href="<?= BASE_URL ?>index.php?page=admin/feedback&filter=sudah" 
       class="btn <?= $filter === 'sudah' ? 'btn-primary' : 'btn-secondary' ?>">
        <i class="fas fa-check"></i> Sudah Diberi Feedback
    </a>
</div>

<!-- Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-comments"></i> Umpan Balik Aspirasi (<?= count($aspirasi) ?>)
        </h3>
    </div>
    <div class="card-body" style="padding: 0;">
        <?php if (!empty($aspirasi)): ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Siswa</th>
                            <th>Aspirasi</th>
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
                                <td>
                                    <strong><?= htmlspecialchars($item['nama_siswa']) ?></strong><br>
                                    <small class="text-secondary"><?= htmlspecialchars($item['kelas']) ?></small>
                                </td>
                                <td style="max-width: 200px;">
                                    <strong><?= htmlspecialchars($item['ket_kategori']) ?></strong><br>
                                    <small><?= htmlspecialchars(substr($item['ket'], 0, 50)) ?>...</small>
                                </td>
                                <td>
                                    <span class="badge badge-<?= strtolower($item['status']) ?>">
                                        <?= $item['status'] ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($item['feedback']): ?>
                                        <span class="badge badge-selesai">
                                            <i class="fas fa-check"></i> Ada
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-menunggu">
                                            <i class="fas fa-times"></i> Belum
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" 
                                            onclick="openFeedbackModal(<?= $item['id_pelaporan'] ?>, '<?= htmlspecialchars(addslashes($item['feedback'] ?? '')) ?>', '<?= $item['status'] ?>')">
                                        <i class="fas fa-edit"></i> Edit Feedback
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <h4 class="empty-state-title">Tidak ada data</h4>
                <p class="empty-state-text">Tidak ada aspirasi yang memerlukan feedback</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Feedback -->
<div id="feedbackModal" class="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title">Edit Feedback</h3>
            <button class="modal-close" onclick="closeFeedbackModal()">&times;</button>
        </div>
        <form action="<?= BASE_URL ?>index.php?page=admin/feedback&action=update" method="POST">
            <div class="modal-body">
                <input type="hidden" id="modal_id_pelaporan" name="id_pelaporan">
                
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select id="modal_status" name="status" class="form-control" required>
                        <option value="Menunggu">Menunggu</option>
                        <option value="Proses">Proses</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Feedback / Tanggapan</label>
                    <textarea id="modal_feedback" name="feedback" class="form-control" rows="5" 
                              placeholder="Berikan tanggapan atau feedback untuk aspirasi ini..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeFeedbackModal()">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openFeedbackModal(id, feedback, status) {
    document.getElementById('modal_id_pelaporan').value = id;
    document.getElementById('modal_feedback').value = feedback;
    document.getElementById('modal_status').value = status;
    document.getElementById('feedbackModal').classList.add('active');
}

function closeFeedbackModal() {
    document.getElementById('feedbackModal').classList.remove('active');
}

// Close modal when clicking outside
document.getElementById('feedbackModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeFeedbackModal();
    }
});
</script>

    </div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
