<?php

$router->get("/", "HomeController@index");  //  List all Public exams

$router->get("/exams/write", "ExamController@index"); //  Where exam key is entered to take exam 
$router->get("/exams/create", "ExamController@create"); //  show Form where new exams are uploaded

$router->post("/exams/write", "ExamController@checkKey"); //  Where exam key is entered to take exam 
// $router->post("/auth/exams/write", "ExamController@getExam"); // Get exam

$router->get("/auth/students/register", "StudentController@create"); // show register screen for auth/students
$router->get("/auth/students/login", "StudentController@login"); // show login screen for auth/students

$router->post("/auth/students/login", "StudentController@authenticate"); // login the student
$router->post("/auth/students/logout", "StudentController@logout"); // logout the student

$router->get("/auth/tutors/register", "TutorController@create"); // show register screen for tutors 
$router->get("/auth/tutors/login", "TutorController@login"); // show login screen for tutors 

$router->post("/auth/tutors/login", "TutorController@authenticate"); // login the tutors 
$router->post("/auth/tutors/logout", "TutorController@logout"); // logout the tutor

$router->post("/exams", "ExamController@store");  // Upload a new exam
$router->get("/exams/{id}", "ExamController@show");   // Get an uploaded exam
$router->put("/exams/{id}/edit", "ExamController@edit");   // edit an exam
$router->delete("/exams/{id}", "ExamController@delete");   // Delete an uploaded exam

$router->get("/exams/{id}/instructions", "ExamController@instructions"); // Get exam instruction
$router->post("/exams/{id}/start", "ExamController@start");  // Start an exam
$router->post("/exams/{id}/submit", "ExamController@submit"); // submit an exam
$router->get("/exams/{id}/finish", "ExamController@finish"); // Get the finish page which may have result displayed

$router->get("/tutors/{name}/exams", "TutorController@exams"); // show all exams by the tutor


// $router->get("/students/{id}", "HomeController@create");