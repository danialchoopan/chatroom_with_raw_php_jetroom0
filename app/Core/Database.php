<?php

namespace App\Core;

use PDO;
use PDOException;

class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        require_once __DIR__ . '/../Config/config.php';

        try {
            if (DB_TYPE === 'mysql') {
                $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
                $this->connection = new PDO($dsn, DB_USER, DB_PASS);
            } else {
                $this->connection = new PDO("sqlite:" . SQLITE_PATH);
            }

            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            $this->initialize();

        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    public function executeSql($sql) {
        try {
            return $this->connection->exec($sql);
        } catch (PDOException $e) {
            return false;
        }
    }

    private function initialize() {
        $sql = file_get_contents(__DIR__ . '/../../database.sql');
        if (DB_TYPE === 'mysql') {
            $sql = str_replace('INTEGER PRIMARY KEY AUTOINCREMENT', 'INT AUTO_INCREMENT PRIMARY KEY', $sql);
            $sql = str_replace('INSERT OR IGNORE', 'INSERT IGNORE', $sql);
        }

        // Split SQL by semicolon but ignore semicolons within strings
        // Simple split for this specific schema
        $queries = explode(';', $sql);
        foreach ($queries as $query) {
            $query = trim($query);
            if (!empty($query)) {
                $this->connection->exec($query);
            }
        }
    }
}
