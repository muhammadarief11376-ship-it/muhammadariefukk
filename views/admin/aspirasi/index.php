<?php 
$currentPage = 'aspirasi';
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar_admin.php';
?>

<!-- Filter Form -->
<form class="filter-form" method="GET" action="<?= BASE_URL ?>index.php">
    <input type="hidden" name="page" value="admin/aspirasi">
    
    <div class="form-group">
        <label class="form-label">Status</label>
        <select name="status" class="form-control">
            <option value="">Semua Status</option>
            <option value="Menunggu" <?= ($filters['status'] ?? '') === 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
            <option value="Proses" <?= ($filters['status'] ?? '') === 'Proses' ? 'selected' : '' ?>>Proses</option>
            <option value="Selesai" <?= ($filters['status'] ?? '') === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
        </select>
    </div>
    
    <div class="form-group">
        <label class="form-label">Kategori</label>
        <select name="kategori" class="form-control">
            <option value="">Semua Kategori</option>
            <?php foreach ($kategori as $kat): ?>
                <option value="<?= $kat['id_kategori'] ?>" <?= ($filters['kategori'] ?? '') == $kat['id_kategori'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($kat['ket_kategori']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="form-group">
        <label class="form-label">Siswa</label>
        <select name="nis" class="form-control">
            <option value="">Semua Siswa</option>
            <?php foreach ($siswa as $s): ?>
                <option value="<?= $s['nis'] ?>" <?= ($filters['nis'] ?? '') == $s['nis'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($s['nama']) ?> (<?= $s['nis'] ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
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
    
    <div class="form-group" style="display: flex; align-items: flex-end; gap: 8px;">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i> Filter
        </button>
        <a href="<?= BASE_URL ?>index.php?page=admin/aspirasi" class="btn btn-secondary">
            <i class="fas fa-times"></i> Reset
        </a>
    </div>
</form>

<!-- Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Aspirasi (<?= count($aspirasi) ?>)</h3>
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
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Status</th>
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
                                    <small class="text-secondary">NIS: <?= $item['nis'] ?> | <?= htmlspecialchars($item['kelas']) ?></small>
                                </td>
                                <td><?= htmlspecialchars($item['ket_kategori']) ?></td>
                                <td><?= htmlspecialchars($item['lokasi']) ?></td>
                                <td>
                                    <span class="badge badge-<?= strtolower($item['status']) ?>">
                                        <?= $item['status'] ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= BASE_URL ?>index.php?page=admin/aspirasi/detail&id=<?= $item['id_pelaporan'] ?>" 
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
                    <i class="fas fa-search"></i>
                </div>
                <h4 class="empty-state-title">Tidak ada aspirasi ditemukan</h4>
                <p class="empty-state-text">Coba ubah filter pencarian Anda</p>
            </div>
        <?php endif; ?>
    </div>
</div>

    </div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
