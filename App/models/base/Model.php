<?php

namespace App\Models\Base;

use Framework\Database;

class Model {
    protected Database $db;
    protected string $tableName = "";

    public function __construct($db) {

        $this->db = $db;
    }

    public function find($value, $columnName = "id") {
        return $this->db->query("SELECT * FROM `{$this->tableName}` WHERE {$columnName} = :{$columnName};", [ "{$columnName}" => $value])->fetch();
    }

    public function findMany($value, $columnName = "id", $limit = 10, $order = "DESC") {

        #   SELECT * FROM `exams` WHERE accessibility = "public" ORDER BY created_at DESC LIMIT 10;
        return $this->db->query("SELECT * FROM `{$this->tableName}` WHERE {$columnName} = :{$columnName} ORDER BY created_at {$order} LIMIT {$limit};", [ "{$columnName}" => $value])->fetchAll();
    }

    public function lastInsertId() {
        return $this->db->query("SELECT LAST_INSERT_ID();")->fetchColumn();
    }

    public function delete(int $id) {      
        $this->db->query("DELETE FROM `{$this->tableName}` WHERE id = :id", ["id" => $id]);
    }
}