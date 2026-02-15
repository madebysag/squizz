<?php

namespace App\Controllers;

use App\Models\Exam;
use Framework\Database;
use Framework\Session;

class HomeController {

    protected $db;
    
    protected $examModel;

    public function __construct() {

        $config = require basePath("config/db.php");
        $this->db = new Database($config);

        $this->examModel = new Exam($this->db);
    }

    /**
     * List all Public Exams
     * 
     */
    public function index () : void {

        $exams = $this->examModel->findMany("public", "accessibility");

        $error = "";

        // If no exam found
        if (!$exams)    $error = "No public exam at the moment!";

        // Get user or admin from session if exists
        $admin = Session::get("admin");
        $user = Session::get("user");

        loadView("public", [
            "error" => $error,
            "exams" => $exams,
            "admin" => $admin,
            "user" => $user
        ]);

        return;
    }
}