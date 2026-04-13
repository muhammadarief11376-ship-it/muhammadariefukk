<?php
/**
 * Model Siswa
 */

require_once __DIR__ . '/Model.php';

class Siswa extends Model {
    protected $table = 'siswa';
    protected $primaryKey = 'nis';
    
    /**
     * Login siswa
     * @param int $nis
     * @param string $password
     * @return array|false
     */
    public function login(int $nis, string $password) {
        $siswa = $this->find($nis);
        
        if ($siswa && password_verify($password, $siswa['password'])) {
            return $siswa;
        }
        
        return false;
    }
    
    /**
     * Registrasi siswa baru
     * @param array $data
     * @return bool
     */
    public function register(array $data): bool {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->create($data);
    }
    
    /**
     * Update password
     * @param int $nis
     * @param string $newPassword
     * @return bool
     */
    public function updatePassword(int $nis, string $newPassword): bool {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->update($nis, ['password' => $hashedPassword]);
    }
    
    /**
     * Mendapatkan semua siswa dengan jumlah aspirasi
     * @return array
     */
    public function getAllWithAspirasiCount(): array {
        $sql = "SELECT s.*, COUNT(ia.id_pelaporan) as jumlah_aspirasi 
                FROM {$this->table} s 
                LEFT JOIN input_aspirasi ia ON s.nis = ia.nis 
                GROUP BY s.nis 
                ORDER BY s.nama ASC";
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Mendapatkan siswa dengan jumlah aspirasi berdasarkan NIS
     * @param int $nis
     * @return array|null
     */
    public function getWithAspirasiCount(int $nis): ?array {
        $sql = "SELECT s.*, COUNT(ia.id_pelaporan) as jumlah_aspirasi 
                FROM {$this->table} s 
                LEFT JOIN input_aspirasi ia ON s.nis = ia.nis 
                WHERE s.nis = ? 
                GROUP BY s.nis";
        $result = $this->db->query($sql, [$nis])->fetch();
        return $result ?: null;
    }
}
