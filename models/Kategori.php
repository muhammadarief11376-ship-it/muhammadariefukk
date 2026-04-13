<?php
/**
 * Model Kategori
 */

require_once __DIR__ . '/Model.php';

class Kategori extends Model {
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    
    /**
     * Mendapatkan semua kategori dengan jumlah aspirasi
     * @return array
     */
    public function getAllWithAspirasiCount(): array {
        $sql = "SELECT k.*, COUNT(ia.id_pelaporan) as jumlah_aspirasi 
                FROM {$this->table} k 
                LEFT JOIN input_aspirasi ia ON k.id_kategori = ia.id_kategori 
                GROUP BY k.id_kategori 
                ORDER BY k.ket_kategori ASC";
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Cek apakah kategori sedang digunakan
     * @param int $id
     * @return bool
     */
    public function isInUse(int $id): bool {
        $sql = "SELECT COUNT(*) as total FROM input_aspirasi WHERE id_kategori = ?";
        $result = $this->db->query($sql, [$id])->fetch();
        return $result['total'] > 0;
    }
}
