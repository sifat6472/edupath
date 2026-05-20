<?php
namespace App\Repositories;

use App\Core\Database;

/**
 * Base Repository
 * Implements Repository Pattern for data access abstraction
 */
abstract class BaseRepository
{
    protected Database $db;
    protected string $table;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function all(): array
    {
        return $this->db->fetchAll("SELECT * FROM {$this->table}");
    }

    public function find(int $id): ?array
    {
        return $this->db->fetchOne("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
    }

    public function findBy(string $column, $value): ?array
    {
        return $this->db->fetchOne("SELECT * FROM {$this->table} WHERE $column = ?", [$value]);
    }

    public function create(array $data): int
    {
        return $this->db->insert($this->table, $data);
    }

    public function update(int $id, array $data): int
    {
        return $this->db->update($this->table, $data, 'id = :id', ['id' => $id]);
    }

    public function delete(int $id): int
    {
        return $this->db->delete($this->table, 'id = ?', [$id]);
    }

    public function count(string $where = '', array $params = []): int
    {
        $sql = "SELECT COUNT(*) as cnt FROM {$this->table}";
        if ($where) $sql .= " WHERE $where";
        $result = $this->db->fetchOne($sql, $params);
        return (int) ($result['cnt'] ?? 0);
    }
}
