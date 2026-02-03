<?php

namespace App\Models\Base;

use Framework\Database;

class Model {
    protected $db;

    public function __construct($db) {

        $this->db = $db;
    }

    public function lastInsertId() {
        return $this->db->query("SELECT LAST_INSERT_ID();")->fetchColumn();
    }

}