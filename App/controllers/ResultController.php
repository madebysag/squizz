<?php

namespace App\Controllers;

use Framework\Database;

class ResultController {

    protected Database $db;

    public function __construct() {

        $config = require basePath("config/db.php");

        $this->db = new Database($config);

    }

    /**
     * Show an exams result taken by student 
     * 
     */
    public function show($key) {

   
        loadView("exams/results");
    }

    /**
     * Show All exams taken by student or authored by a tutor
     * 
     */
    public function showAll(){
        
    }

    /**
     * Submit an exam
     * 
     */
    public function store($key) {

        inspect($_POST, false);

        
        loadView("exams/finish");
    }


    /**
     * Partial submission every 30 seconds
     * 
     */
    public function update($key){

    }
}