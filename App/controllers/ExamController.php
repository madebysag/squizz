<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Sorter;

use App\Models\Exam;
use App\Models\Question;
use App\Models\Answer;

use PDOException;
use Exception;
use Framework\Session;

class ExamController {
    protected $db;

    protected $examModel;
    protected $answerModel;
    protected $questionModel;

    protected $examId;
    protected $firstQuestionId;


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

        $exam = $this->examModel->find($key, "exam_key");
        
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

        $metaData["author_id"] = Session::get("user")["id"];
        $metaData["questions_count"] = count($sortedQuestions);
        $metaData["exam_key"] = hash("crc32b", Session::get("user")["name"] . (string) time()); // Name + time created in base 64 is key
        // $metaData["exam_key"] = base64_encode(Session::get("user")["name"] . (string) time()); // Name + time created in base 64 is key

        try {

            // Begin Transaction
            $this->db->conn->beginTransaction();

            $this->examModel->save($metaData);
            
            $this->examId = $this->examModel->lastInsertId();
            
            $this->questionModel->saveMany($sortedQuestions, $this->examId);
                        
            $this->firstQuestionId = $this->questionModel->lastInsertId();

            $this->answerModel->saveMany($sortedAnswers, $this->firstQuestionId);

            // Commit Transaction
            $this->db->conn->commit();
            
        } catch (PDOException $e) {

            // RollBack, revert to autocommit mode
            $this->db->conn->rollback();
            
            throw new Exception("Failed to perform Transaction.\nError Message: {$e->getMessage()}");
        }        

        redirect("/exams/list");

    }

    public function list() {
        $tutor = Session::get("user");

        $examsByTutor = $this->examModel->findMany($tutor["id"], "author_id");

        // inspect($tutor, false);
        // inspect($examsByTutor, );

        loadView("exams/list", [
            "tutor" => $tutor,
            "exams" => $examsByTutor
        ]);
    }

    public function start($params) {

        $examDetails = $this->examModel->find($params["key"], "exam_key");
        
        // SELECT questions.body, answers.body, answers.id, questions.id, exams.id FROM ((`exams` JOIN questions ON 1 = questions.exam_id) JOIN answers ON questions.id = answers.question_id)
        
        $fullExam = $this->examModel->load($examDetails->id);
        $sortedExam = Sorter::buildQuestionsToShow($fullExam);

        loadView("exams/show", [
            "exam" => $examDetails,
            "questions" => $sortedExam
            ]);
    }
}