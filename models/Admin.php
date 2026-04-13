<?php
/**
 * Model Admin
 */

require_once __DIR__ . '/Model.php';

class Admin extends Model {
    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    
    /**
     * Login admin
     * @param string $username
     * @param string $password
     * @return array|false
     */
    public function login(string $username, string $password) {
        $admin = $this->findBy('username', $username);
        
        if ($admin && password_verify($password, $admin['password'])) {
            return $admin;
        }
        
        return false;
    }
    
    /**
     * Mendapatkan admin berdasarkan username
     * @param string $username
     * @return array|false
     */
    public function findByUsername(string $username) {
        return $this->findBy('username', $username);
    }
    
    /**
     * Update password
     * @param int $id
     * @param string $newPassword
     * @return bool
     */
    public function updatePassword(int $id, string $newPassword): bool {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->update($id, ['password' => $hashedPassword]);
    }
}
