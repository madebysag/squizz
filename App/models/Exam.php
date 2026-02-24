<?php

namespace App\Models;

use App\Models\Base\Model;
// use PDO;

class Exam extends Model{
    protected string $tableName = "exams";

    
    public function save(array $params) {
        
        $this->db->query("INSERT INTO `exams` (title, show_author, author_id, course, tags, duration, start_at, end_at, instructions, questions_count, exam_key) VALUES (:title, :show_author, :author_id, :course, :tags, :duration, :start_at, :end_at, :instructions, :questions_count, :exam_key);", $params);
    }
    
    public function update(array $params) {

        $queryString = ""; 

        foreach($params as $key => $value) {

            if ($key == "exam_key") continue;

            $queryString .= "`{$key}` = :{$key},";
            
        }

        $queryString = trim($queryString, ",");

        $this->db->query("UPDATE `exams` SET {$queryString} WHERE `exam_key` = :exam_key;", $params);

        // $this->db->query("UPDATE `exams` WHERE (title, show_author, author_id, course, tags, duration, start_at, end_at, instructions, questions_count, exam_key) VALUES (:title, :show_author, :author_id, :course, :tags, :duration, :start_at, :end_at, :instructions, :questions_count, :exam_key);", $params);
    }

    public function load(int $examId) {
        return $this->db->query("SELECT DISTINCT questions.id AS question_id, questions.body AS question_body, questions.picture_url, questions.type, answers.id AS answer_id, answers.body AS answer_body, answers.is_correct FROM ((`exams` JOIN questions ON :id = questions.exam_id) JOIN answers ON questions.id = answers.question_id)", ["id" => $examId])->fetchAll();
    }


}