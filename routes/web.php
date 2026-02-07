<?php

$router->get("/", "HomeController@index");  //  List all Public exams #

$router->get("/exams/write", "ExamController@index"); //  Where exam key is entered to take exam  #
$router->get("/exams/create", "ExamController@create"); //  show Form where new exams are uploaded # 

$router->post("/exams/write", "ExamController@checkKey"); //  Where exam key is entered to take exam #

$router->post("/exams", "ExamController@store");  // Upload a new exam
// $router->get("/exams/{id}", "ExamController@show");   // Get an uploaded exam

$router->get("auth/users/register", "UserController@create"); //  show Form where new user(student / tutor) or tutor are created # 
$router->get("auth/users/login", "UserController@login"); //  show user(student / tutor) Login form # 

$router->post("auth/users/register", "UserController@store");  
$router->post("auth/users/login", "UserController@authenticate");  
$router->post("auth/users/logout", "UserController@logout");  


$router->get("auth/organisations/register", "OrganisationController@create");  
$router->get("auth/organisations/login", "OrganisationController@login");  

$router->post("auth/organisations/register", "OrganisationController@store"); 
$router->post("auth/organisations/login", "OrganisationController@authenticate"); 
$router->post("auth/organisations/logout", "OrganisationController@logout"); 



// $router->post("/auth/exams/write", "ExamController@getExam"); // Get exam

$router->put("/exams/{id}/edit", "ExamController@edit");   // edit an exam
$router->delete("/exams/{id}", "ExamController@delete");   // Delete an uploaded exam

$router->post("/exams/{id}/start", "ExamController@start");  // Start an exam
$router->post("/exams/{id}/submit", "ExamController@submit"); // submit an exam
$router->get("/exams/{id}/finish", "ExamController@finish"); // Get the finish page which may have result displayed

$router->get("/tutors/{name}/exams", "TutorController@exams"); // show all exams by the tutor


// $router->get("/students/{id}", "HomeController@create");