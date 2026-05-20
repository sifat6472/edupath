<?php
namespace App\Models;

use App\Core\Database;

/**
 * Base Model
 */
abstract class Model
{
    protected static string $table;
    protected Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public static function getTable(): string
    {
        return static::$table;
    }

    public static function db(): Database
    {
        return Database::getInstance();
    }
}
