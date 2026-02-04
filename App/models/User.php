<?php

namespace App\Models;

use App\Models\Base\Model;

class User extends Model{
    protected string $tableName = "users";

    // public function all(int $limit) {
    // }

    // public function findByKey(string $key) {

    //     $params = [
    //         "key" => $key
    //     ];

    //     return $this->db->query("SELECT * FROM `exams` WHERE `exam_key` = :key; ", $params)->fetch();
    // }
    
    public function save(array $params) {
        
        $this->db->query("INSERT INTO `users` (name, email, role, password, organisation_id) VALUES (:name, :email, :role, :password, :organisation_id);", $params);
    }


}