<?php

namespace App\Controllers;

use Framework\Database;

use App\Models\User;
use Framework\Validator;

class UserController {

    protected $db;

    protected $userModel;

    public function __construct() {

        $config = require basePath("config/db.php");
        $this->db = new Database($config);

        $this->userModel = new User($this->db);
    }

    /**
     * Show create form
     * 
     */
    public function create () : void {

        loadView("users/create");
    }


    public function store () : void {

    inspect($_POST["name"], false);
    inspect(Validator::name($_POST["name"]));

        
        // $exams = $this->db->query("SELECT * FROM `exams` WHERE `exams` . `accessibility` = 'public'")->fetchAll();

        // if (!$exams) {
            
        //     loadView("public", [
        //         "error" => "No public exam at the moment!"
        //     ]);

        //     return;
        // }
        
        // loadView("public", [
        //     "exams" => $exams
        // ]);

        // return;
    }
}