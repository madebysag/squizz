<?php

namespace App\Controllers;

use Framework\Database;

class HomeController {

    public function __construct() {

        $config = require basePath("config/db.php");
        $this->db = new Database($config);
    }

    /**
     * List all Public Exams
     * 
     */
    public function index () : void {

        $exams = $this->db->query("SELECT * FROM `exams` WHERE `exams` . `accessibility` = 'public'")->fetchAll();

        if (!$exams) {
            
            loadView("public", [
                "error" => "No public exam at the moment!"
            ]);

            return;
        }
        
        loadView("public", [
            "exams" => $exams
        ]);

        return;
    }
}