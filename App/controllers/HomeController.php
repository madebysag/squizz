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

        if (!$exams) {
            
            loadView("public", [
                "error" => "No public exam at the moment!"
            ]);

            return;
        }

        // Get user from session if exists
        $user = Session::get("user");
        
        loadView("public", [
            "exams" => $exams,
            "user" => $user
        ]);

        return;
    }
}