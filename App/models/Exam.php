<?php

namespace App\Models;

use App\Models\Base\Model;
// use PDO;

class Exam extends Model{
    protected string $tableName = "exams";

    
    public function save(array $params) {
        $fields = [];
        $values = [];

        foreach($params as $field => $value) {

            $fields[] = $field; // the query pary

            $values[] = ":" . $field;   // the bound parameters part

            if ($value == "") $params[$field] = null;   // set empty fields to null
        }

        $fieldsString = implode(", ", $fields);
        $valuesString = implode(", ", $values);
        
        $this->db->query("INSERT INTO `exams` ({$fieldsString}) VALUES ({$valuesString});", $params);
    }
    
    public function update(array $params) {

        $queryString = ""; 

        foreach($params as $key => $value) {

            if ($key == "exam_key") continue;

            $queryString .= "`{$key}` = :{$key},";
            
        }

        $queryString = trim($queryString, ",");

        $this->db->query("UPDATE `exams` SET {$queryString} WHERE `exam_key` = :exam_key;", $params);
    }

    public function load(int $examId) {
        return $this->db->query("SELECT DISTINCT questions.id AS question_id, questions.body AS question_body, questions.picture_url, questions.type, answers.id AS answer_id, answers.body AS answer_body, answers.is_correct FROM ((`exams` JOIN questions ON :id = questions.exam_id) JOIN answers ON questions.id = answers.question_id)", ["id" => $examId])->fetchAll();
    }


}