<?php

namespace App\Controllers;

use Framework\Database;

class ResultController {

    protected Database $db;

    public function __construct() {

        $config = require basePath("config/db.php");

        $this->db = new Database($config);

    }

    public function show() {

    
    loadView("exams/results");
    }


    public function store() {

    inspect($_POST, false);

    
    loadView("exams/finish");
    }
}