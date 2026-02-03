<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Sorter;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Answer;

class ExamController {
    protected $db;

    protected $examModel;
    protected $answerModel;
    protected $questionModel;

    protected $examId;


    public function __construct() {

        $config = require basePath("config/db.php");

        $this->db = new Database($config);

        $this->examModel = new Exam($this->db);
        $this->answerModel = new Answer($this->db);
        $this->questionModel = new Question($this->db);
        
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

        // $examFields = ["title", "author_id", "course", "tags", "duration", "start_at", "end_at", "instructions", "questions_count", "exam_key"];
        // $questionFields = ["body", "picture_url", "correct_answer_id", "exam_id"];
        // $answerFields = ["body", "question_id"];

        $metaData = [];
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
        
        $sortedQuestions = Sorter::sort($questions);
        $sortedAnswers = Sorter::sort($answers);
        
        $metaData["author_id"] = 1;
        $metaData["questions_count"] = count($sortedQuestions);

        // inspect($metaData, false);
        // inspect($questions, false);
        // inspect($answers, false);
        // inspect($sortedQuestions, false);
        // inspect($sortedAnswers, false);
        
        // Begin Transaction
        
        $this->examModel->save($metaData);
        
        $this->examId = $this->examModel->lastInsertId();
                
        $this->questionModel->saveMany($sortedQuestions, $this->examId);
        
        // $this->answerModel->saveMany($sortedAnswers);

        echo "Heloo";

    }
}