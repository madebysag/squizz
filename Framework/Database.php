<?php

namespace Framework;

use PDO;

class Database {

    public $conn;

    public function __construct(array $config) {

        $dsn = "mysql:host={$config["host"]};port={$config["port"]};dbname={$config["dbname"]};";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];

        try {
            $this->conn = new PDO($dsn, $config["username"], $config["password"], $options);
        } catch (PDOException $e) {
            throw new Exception("Database Connection Failed.\n Message: {$e->getMessage()}");
        }
        inspect($this->conn, false);
    }
}