<?php
namespace Config;

use PDO;

class Database {
    private static $instance = null;

    public static function getConnection() {
        if (self::$instance === null) {
            self::$instance = new PDO("mysql:host=localhost;dbname=memory;charset=utf8mb4", "root", "");
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$instance;
    }
}