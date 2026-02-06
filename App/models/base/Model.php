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

    public function lastInsertId() {
        return $this->db->query("SELECT LAST_INSERT_ID();")->fetchColumn();
    }

}