<?php

namespace App\Models;

use Framework\Database;

class Exam {
    protected $db;

    public function __construct($db) {

        $this->db = $db;
    }

    public function all(int $limit) {
    }

    public function findByKey(string $key) {

        $params = [
            "key" => $key
        ];

        return $this->db->query("SELECT * FROM `exams` WHERE `exam_key` = :key; ", $params)->fetch();
    }
    
    public function save(array $params) {
        
        $this->db->query("INSERT INTO `exams` (title, author_id, course, tags, duration, start_at, end_at, instructions, questions_count, exam_key) VALUES (:title, :author_id, :course, :tags, :duration, :start_at, :end_at, :instructions, :questions_count, :exam_key)", $params);
    }

    // public function saveArray(ar)
}