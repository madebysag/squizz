<?php

namespace App\Controllers;

use App\Models\Answer;
use App\Models\Exam;
use App\Models\Result;
use Framework\Database;
use Framework\Scoring;
use Framework\Session;
use Framework\Sorter;

use PDOException;
use Exception;

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
     * Show all exams result taken by student 
     * 
     */
    public function showAll() {

        // Fetch result from DB
        $tutor = Session::get("user");

        $examsByTutor = $this->examModel->findMany($tutor["id"], "author_id");

        loadView("results/list", [
            "tutor" => $tutor,
            "exams" => $examsByTutor
        ]);
    }

    /**
     * Show All results of an exam authored by a tutor if a user is tutor
     * Show latest result of an exam taken by a student if a user is student
     * 
     */
    public function show($params){

        // Get current user
        $user = Session::get("user");
        
        if ($user["role"] == "student") {

            $result = $this->resultModel->studentResult($user["id"]);

            if (isset($result)) $exam = $this->examModel->find($result->exam_id);

            else return ErrorController::notFound();
            
            loadView("results/index", [
                "user" => $user,
                "exam" => $exam,
                "score" => $result->score,
                "correct" => $result->correct,
                "wrong" => $result->wrong
            ]);
            
        } else if($user["role"] == "tutor") {

            $exam = $this->examModel->find($params["key"], "exam_key");

            if (isset($exam)) $results = $this->resultModel->tutorResults($exam->id);
            
            loadView("results/show", [
                "results" => $results,
                "exam" => $exam,
                "user" => $user
            ]);
            
        } else {

            ErrorController::forbiddden();
            
        }
    }


    /**
     * Submit an exam
     * 
     */
    public function store($params) {

        // Update the result
        $this->update($params);

        // Clear session 
        Session::clear("exam");
        
        // Show results
        redirect("/exams/results/{$params["key"]}");
    }


    /**
     * Partial submission every 30 seconds
     * 
     * on a second thought... maybe after clicking next and previous btn
     * 
     */
    public function update($params){

        // First submission
        if (!Session::has("exam")) {

            $examDetails = $this->examModel->find($params["key"], "exam_key");

            if (!$examDetails) return;

            /**
             * Retriving the buffer added to options Values (i.e the IDs) in views/partials/questions.php 
             */
            $buffer = strtotime($examDetails->created_at) - 1_000_000;
            
            $answers = Sorter::submittedAnswers($_POST);

            // No answers selected
            if (!$answers) {

                // Set score to zero, others too accordingly
                [$score, $correct, $wrong ] = [0.0, 0.0, $examDetails->questions_count];

            }  else {

                $answersInfo = $this->answerModel->findManyAnswers($answers, $buffer);
        
                [$score, $correct, $wrong ]= Scoring::score($answersInfo, $examDetails->questions_count);
            }
            
            
            try {
                
                $this->db->conn->beginTransaction();

                // Save result
                $this->resultModel->save([
                    "exam_id" => $examDetails->id,
                    "student_id" => Session::get("user")["id"],
                    "score" => $score,
                    "correct" => $correct,
                    "wrong" => $wrong
                ]);

                $resultRecordId = $this->resultModel->lastInsertId();

                Session::set("exam", [
                    "id" => $examDetails->id,
                    "created_at" => $examDetails->created_at,
                    "questions_count" => $examDetails->questions_count,
                    "resultId" => $resultRecordId
                ]);

                //Commit the changes
                $this->db->conn->commit();

            } catch (PDOException $e) {
                    
                // RollBack, revert to autocommit mode
                $this->db->conn->rollback();
                
                throw new Exception("Failed to save result.\nError Message: {$e->getMessage()}");
            }

            // echo "Saved";
            
        } else {    // Subsequent submission
            

            $created_at = Session::get("exam")["created_at"];
            $questions_count = Session::get("exam")["questions_count"];            
            $resultRecordId = Session::get("exam")["resultId"];            
            
            /**
             * Retriving the buffer added to options Values (i.e the IDs) in views/partials/questions.php 
            */
            $buffer = strtotime($created_at) - 1_000_000;
            
            $answers = Sorter::submittedAnswers($_POST);

            // No answers selected
            if (!$answers) {

                // Set score to zero, others too accordingly
                [$score, $correct, $wrong ] = [0.0, 0.0, $questions_count];

            } else {

                $answersInfo = $this->answerModel->findManyAnswers($answers, $buffer);            
    
                [$score, $correct, $wrong ]= Scoring::score($answersInfo, $questions_count);
            }

            $this->resultModel->update([
                "id" => $resultRecordId,
                "score" => $score,
                "correct" => $correct,
                "wrong" => $wrong
            ]);
        }
    }
}