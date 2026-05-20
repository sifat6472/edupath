<?php
namespace App\Core;

use PDO;
use PDOException;

/**
 * Database Connection
 * Implements Singleton Pattern
 */
class Database
{
    private static ?Database $instance = null;
    private PDO $connection;
    private string $driver;

    private function __construct()
    {
        $config = $GLOBALS['config'];
        
        // Try MySQL first
        try {
            $dsn = "mysql:host={$config['database']['host']};port={$config['database']['port']};dbname={$config['database']['database']};charset={$config['database']['charset']}";
            $this->connection = new PDO($dsn, $config['database']['username'], $config['database']['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
            $this->driver = 'mysql';
            return;
        } catch (PDOException $e) {
            // Fallback to SQLite
            if (!$config['use_sqlite_fallback']) {
                throw $e;
            }
        }

        // SQLite fallback (so the app runs even without MySQL)
        $sqlitePath = $config['sqlite_path'];
        $needsInit = !file_exists($sqlitePath);
        
        if (!is_dir(dirname($sqlitePath))) {
            mkdir(dirname($sqlitePath), 0755, true);
        }

        $this->connection = new PDO("sqlite:{$sqlitePath}", null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        $this->connection->exec('PRAGMA foreign_keys = ON');
        $this->driver = 'sqlite';

        if ($needsInit) {
            $this->initializeSchema();
        }
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function pdo(): PDO { return $this->connection; }
    public function driver(): string { return $this->driver; }

    public function query(string $sql, array $params = []): \PDOStatement
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function fetchAll(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll();
    }

    public function fetchOne(string $sql, array $params = []): ?array
    {
        $result = $this->query($sql, $params)->fetch();
        return $result === false ? null : $result;
    }

    public function insert(string $table, array $data): int
    {
        $columns = array_keys($data);
        $placeholders = array_map(fn($c) => ":$c", $columns);
        $sql = "INSERT INTO $table (" . implode(',', $columns) . ") VALUES (" . implode(',', $placeholders) . ")";
        $this->query($sql, $data);
        return (int) $this->connection->lastInsertId();
    }

    public function update(string $table, array $data, string $where, array $whereParams = []): int
    {
        $set = [];
        foreach ($data as $key => $val) {
            $set[] = "$key = :$key";
        }
        $sql = "UPDATE $table SET " . implode(', ', $set) . " WHERE $where";
        $stmt = $this->query($sql, array_merge($data, $whereParams));
        return $stmt->rowCount();
    }

    public function delete(string $table, string $where, array $params = []): int
    {
        $sql = "DELETE FROM $table WHERE $where";
        return $this->query($sql, $params)->rowCount();
    }

    private function initializeSchema(): void
    {
        $schemaFile = BASE_PATH . '/database/migrations/sqlite_schema.sql';
        if (file_exists($schemaFile)) {
            $sql = file_get_contents($schemaFile);
            $this->connection->exec($sql);
        }
        
        $seederFile = BASE_PATH . '/database/seeders/seed.php';
        if (file_exists($seederFile)) {
            require $seederFile;
        }
    }
}
