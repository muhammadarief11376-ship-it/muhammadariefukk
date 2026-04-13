<?php
/**
 * Model Aspirasi (Status & Feedback)
 */

require_once __DIR__ . '/Model.php';

class Aspirasi extends Model {
    protected $table = 'aspirasi';
    protected $primaryKey = 'id_aspirasi';
    
    /**
     * Update status aspirasi
     * @param int $idPelaporan
     * @param string $status
     * @return bool
     */
    public function updateStatus(int $idPelaporan, string $status): bool {
        $sql = "UPDATE {$this->table} SET status = ?, tanggal_update = NOW() WHERE id_pelaporan = ?";
        $this->db->query($sql, [$status, $idPelaporan]);
        return true;
    }
    
    /**
     * Update feedback
     * @param int $idPelaporan
     * @param string $feedback
     * @return bool
     */
    public function updateFeedback(int $idPelaporan, string $feedback): bool {
        $sql = "UPDATE {$this->table} SET feedback = ?, tanggal_update = NOW() WHERE id_pelaporan = ?";
        $this->db->query($sql, [$feedback, $idPelaporan]);
        return true;
    }
    
    /**
     * Update status dan feedback sekaligus
     * @param int $idPelaporan
     * @param string $status
     * @param string $feedback
     * @return bool
     */
    public function updateStatusAndFeedback(int $idPelaporan, string $status, string $feedback): bool {
        $sql = "UPDATE {$this->table} SET status = ?, feedback = ?, tanggal_update = NOW() WHERE id_pelaporan = ?";
        $this->db->query($sql, [$status, $feedback, $idPelaporan]);
        return true;
    }
    
    /**
     * Mendapatkan aspirasi berdasarkan id_pelaporan
     * @param int $idPelaporan
     * @return array|false
     */
    public function findByPelaporan(int $idPelaporan) {
        return $this->findBy('id_pelaporan', $idPelaporan);
    }
    
    /**
     * Mendapatkan riwayat perubahan status (jika ada tabel log)
     * @param int $idPelaporan
     * @return array
     */
    public function getHistory(int $idPelaporan): array {
        // Untuk sekarang, return data aspirasi saja
        // Bisa dikembangkan dengan tabel log jika diperlukan
        $aspirasi = $this->findByPelaporan($idPelaporan);
        return $aspirasi ? [$aspirasi] : [];
    }
}
