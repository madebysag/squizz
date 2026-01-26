<?php

namespace App\Controllers;

use Framework\Database;
use App\Models\Exam;

class ExamController {
    protected $examModel;


    public function __construct() {

        $config = require basePath("config/db.php");

        $db = new Database($config);

        $this->examModel = new Exam($db);
        
    }

    /**
     * Load Exam Login Screen - whereexam screen is entered
     */
    public function index() : void {

        loadView("exams/index");
    }
    
    /**
     * 
     * Check if key exist and redirect to exam instruction
    */
    public function checkKey() {

        // Check is a key is submitted
        $key = isset($_POST["exam_key"]) ? $_POST["exam_key"] : "";

        if (!$key) {

            loadView("exams/index", [
                "error" => "Exam does not exist!"
            ]);

            return;
            
        } 

        $exam = $this->examModel->findByKey($key);
        
        if (!$exam) {
            
            loadView("exams/index", [
                "error" => "Exam does not exist!"
            ]);
            
            return;
        }

        loadView("exams/instructions", [
            "exam" => $exam
        ]);        
    }

    
    /**
     * Display Exam instructions
     */
    // public function create() : void {
    // }

    public function create() : void {

        loadView("exams/create", [
            // "error" => $error
        ]);
    }
    
    /**
     * Display Exam instructions
     */
    public function store($params) : void {

        $examFields = ["title", "author_id", "course", "tags", "duration", "start_at", "end_at", "instructions", "questions_count", "exam_key"];
        $questionFields = ["body", "picture_url", "correct_answer_id", "exam_id"];
        $answerFields = ["body", "question_id"];

        $metaData = [ "questions_count" => 4, "author_id" => 1];
        $questions = [];
        $answers = [];

        foreach($_POST as $key => $param) {

            if(str_contains($key, "answer")) {
                $answers[$key] = $param;
            } else if (str_contains($key, "question")) {
                $questions[$key] = $param;
            } else {
                $metaData[$key] = $param;
            }
        }

        $this->examModel->save($metaData);
        inspect($questions, false);
        inspect($answers, false);
        // inspect($param, false);
        inspect($metaData, false);

    }
}