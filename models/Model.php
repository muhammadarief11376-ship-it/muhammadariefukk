<?php
/**
 * Base Model Class
 * Semua model mewarisi class ini
 */

require_once __DIR__ . '/../config/Database.php';

abstract class Model {
    protected $db;
    protected $table;
    protected $primaryKey = 'id';
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Mendapatkan semua data
     * @param string $orderBy Kolom untuk sorting
     * @param string $order ASC atau DESC
     * @return array
     */
    public function findAll(string $orderBy = '', string $order = 'ASC'): array {
        $sql = "SELECT * FROM {$this->table}";
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy} {$order}";
        }
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Mencari berdasarkan primary key
     * @param mixed $id
     * @return array|false
     */
    public function find($id) {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";
        return $this->db->query($sql, [$id])->fetch();
    }
    
    /**
     * Mencari berdasarkan kondisi
     * @param string $column
     * @param mixed $value
     * @return array|false
     */
    public function findBy(string $column, $value) {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = ?";
        return $this->db->query($sql, [$value])->fetch();
    }
    
    /**
     * Mencari semua berdasarkan kondisi
     * @param string $column
     * @param mixed $value
     * @return array
     */
    public function findAllBy(string $column, $value): array {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = ?";
        return $this->db->query($sql, [$value])->fetchAll();
    }
    
    /**
     * Insert data baru
     * @param array $data
     * @return bool
     */
    public function create(array $data): bool {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $this->db->query($sql, array_values($data));
        
        return true;
    }
    
    /**
     * Update data
     * @param mixed $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data): bool {
        $setClause = implode(' = ?, ', array_keys($data)) . ' = ?';
        
        $sql = "UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = ?";
        $params = array_values($data);
        $params[] = $id;
        
        $this->db->query($sql, $params);
        
        return true;
    }
    
    /**
     * Hapus data
     * @param mixed $id
     * @return bool
     */
    public function delete($id): bool {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $this->db->query($sql, [$id]);
        
        return true;
    }
    
    /**
     * Menghitung jumlah data
     * @param string $condition
     * @param array $params
     * @return int
     */
    public function count(string $condition = '', array $params = []): int {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        if ($condition) {
            $sql .= " WHERE {$condition}";
        }
        $result = $this->db->query($sql, $params)->fetch();
        return (int) $result['total'];
    }
    
    /**
     * Mendapatkan ID terakhir yang di-insert
     * @return string
     */
    public function getLastInsertId(): string {
        return $this->db->lastInsertId();
    }
}
