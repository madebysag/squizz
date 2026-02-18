<?php

namespace App\Controllers;

use App\Models\Answer;
use App\Models\Exam;
use App\Models\Result;
use Framework\Database;
use Framework\Scoring;
use Framework\Sorter;

class ResultController {

    protected Database $db;
    protected $examModel;
    protected $resultModel;
    protected $answerModel;

    public function __construct() {

        $config = require basePath("config/db.php");

        $this->db = new Database($config);
        $this->examModel = new Exam($this->db);
        $this->resultModel = new Result($this->db);
        $this->answerModel = new Answer($this->db);

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
        inspect("All REsults by user");
    }

    /**
     * Submit an exam
     * 
     */
    public function store($params) {

        $examDetails = $this->examModel->find($params["key"], "exam_key");

        /**
         * Retriving the buffer added to options Values (i.e the IDs) in views/partials/questions.php 
         */
        $buffer = strtotime($examDetails->created_at) - 1_000_000;
        
        $answers = Sorter::submittedAnswers($_POST);
        $answersInfo = $this->answerModel->findManyAnswers($answers, $buffer);

        [$score, $correct, $wrong ]= Scoring::score($answersInfo, $examDetails->questions_count);
        
        loadView("exams/finish", [
            "score" => $score,
            "correct" => $correct,
            "wrong" => $wrong,
        ]);
    }


    /**
     * Partial submission every 30 seconds
     * 
     */
    public function update($key){

    }
}