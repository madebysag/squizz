<?php

namespace App\Controllers;

use App\Models\Exam;
use App\Models\Result;
use Framework\Database;
use Framework\Sorter;

class ResultController {

    protected Database $db;
    protected $examModel;
    protected $resultModel;

    public function __construct() {

        $config = require basePath("config/db.php");

        $this->db = new Database($config);
        $this->examModel = new Exam($this->db);
        $this->resultModel = new Result($this->db);

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
    public function store($params) {

        
        $examDetails = $this->examModel->find($params["key"], "exam_key");
        
        $answers = Sorter::submittedAnswers($_POST);
        inspect($answers);
        
        loadView("exams/finish");
    }


    /**
     * Partial submission every 30 seconds
     * 
     */
    public function update($key){

    }
}