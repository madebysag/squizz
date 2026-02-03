<?php

namespace Framework;

use PDO;
use PDOException;
use Exception;

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
    }

    public function query(string $query, array $params = [], bool $limited = true) {
        try {
            $stmt = $this->conn->prepare($query);

            if ($limited) { #number of parameter is known
                
                foreach ($params as $param => $value) {
                    $stmt->bindValue(":". $param, $value);
                }
    
                $stmt->execute();

            } else {    #unknown params as (? , ?)

                $stmt->execute($params);
            } 

            // inspect($this->conn);
            return $stmt;

        } catch (PDOException $e) {
            throw new Exception("Failed to execute query.\nError Message: {$e->getMessage()}");
        }

    }
}