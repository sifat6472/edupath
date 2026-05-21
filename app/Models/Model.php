<?php

namespace App\Models;

use App\Core\Database;



/**
 * Base Model
 * Provides shared database access and table resolution for all models.
 */



abstract class model
{
    protected static string $table;
    protected Database $db;

    public function __construct(){

        // Initialize database connection on model instantiation

        $this->db = Database::getInstance();
    }

    public static function getTable(): string{

        return static::$table;
    }

    public static function db(): Database
    {
        // Returns singleton database instance for static access

         return Database::getInstance();
    }
}