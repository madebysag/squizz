<?php

namespace App\Controllers;

use Framework\Database;

class ExamController {

    public function index() : void {

        $config = require basePath("config/db.php");

        $db = new Database($config);

        loadView("exams/index", [
            // "error" => $error
        ]);
    }
    public function create() : void {

        loadView("exams/create", [
            // "error" => $error
        ]);
    }
}