<?php

namespace App\Controllers;

use Framework\Database;

use App\Models\User;
use Framework\Session;
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

        $error = [];

        if (!Validator::name($_POST["name"]))    
            $error["name"] = "Firstname and lastname should be 2 to 55 characters";
        
        if (!Validator::email($_POST["email"]))    
            $error["email"] = "Enter a valid email";
        
        if (!Validator::password($_POST["password"]))    
            $error["password"] = "Password too short!";

        if (!Validator::match($_POST["password"], $_POST["password2"]))    
            $error["password2"] = "Passwords does not match";


        if(!empty($error)) {
            loadView("users/create", [
                "error" => $error,
                "user" => [
                    "name" => $_POST["name"],
                    "email" => $_POST["email"],
                ]
            ]);
            
            return;
        }

        // Save to datwabase
        $params = [
            "name" => $_POST["name"],
            "email" => $_POST["email"],
            "role" => $_POST["role"],
            "password" => password_hash($_POST["password"], PASSWORD_DEFAULT),
            "organisation_id" => 1 # Get this from session when user authenticates
        ];

        $this->userModel->save($params);

        $newUserId = $this->userModel->lastInsertId();

        Session::set("user", [
            "id" => $newUserId,
            "name" => $params["name"],
            "email" => $params["email"],
            "role" => $params["role"],
            "organisation_id" => $params["organisation_id"]
        ]);


        redirect("/");

        exit;
    }


    /**
     * Log in both Student and Tutor
     */
    public function login() : void {

        loadView("users/login");
    }

    /**
     * Log in both Student and Tutor
     */
    public function authenticate() {

        $error = [];
        
        if (!Validator::email($_POST["email"]))    
            $error["email"] = "Please enter a valid email!";
        
        if (!Validator::password($_POST["password"]))    
            $error["password"] = "Password too short!";


        if(!empty($error)) {
            loadView("users/login", [
                "error" => $error,
                "user" => [
                    "email" => $_POST["email"],
                ]
            ]);
            
            return;
        }

        // Check user in database
        $email = $_POST["email"];
        $password = $_POST["password"];

        $user = $this->userModel->find($email, "email");

        // No User found
        if(!$user) {

            $error["password"] = "Invalid Credentials";

            loadView("users/login", [
                "error" => $error,
                "user" => [
                    "email" => $email,
                ]
            ]);
            
            return;
        }

        // Wrong password
        if(!password_verify($password, $user->password)) {

            $error["password"] = "Invalid Credentials";

            loadView("users/login", [
                "error" => $error,
                "user" => [
                    "email" => $email,
                ]
            ]);
            
            return;
        }

        Session::set("user", [
            "id" => $user->id,
            "name" => $user->name,
            "email" => $user->email,
            "role" => $user->role,
            "organisation_id" => $user->organisation_id
        ]);

        redirect("/");

        exit;
    }

    public function logout() {

        Session::clearAll();

        $params = session_get_cookie_params();

        setcookie("PHPSESSID", "", time() - 86400, $params["path"], $params["domain"]);

        redirect("/");
    }
}