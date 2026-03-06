<?php

$router->get("/", "HomeController@index");

$router->get("/exams/write", "ExamController@index", ["student"]); 
$router->get("/exams/create", "ExamController@create", ["tutor"]); 
$router->get("/exams/list", "ExamController@list", ["tutor"]);  

$router->post("/exams/write", "ExamController@checkKey", ["student"]); 

$router->post("/exams", "ExamController@store", ["tutor"]);

$router->get("/exams/results", "ResultController@showAll", ["tutor"]); 

$router->get("/exams/{key}", "ExamController@edit", ["tutor"]);  

$router->put("/exams/{key}", "ExamController@update", ["tutor"]);  

$router->delete("/exams/{key}", "ExamController@delete", ["tutor"]);

$router->get("/exams/start/{key}", "ExamController@start", ["student"]);  

$router->get("/exams/results/{key}", "ResultController@show", ["user"]); 

$router->put("/exams/results/{key}", "ResultController@update", ["student"]); 

$router->post("/exams/results/{key}", "ResultController@store", ["student"]); 


$router->get("auth/users/register", "UserController@create", ["org"]); 
$router->get("auth/users/login", "UserController@login", ["guest"]);  

$router->post("auth/users/register", "UserController@store", ["org"]);  
$router->post("auth/users/login", "UserController@authenticate", ["guest"]);  
$router->post("auth/users/logout", "UserController@logout", ["user"]);  


$router->get("auth/organisations/register", "OrganisationController@create", ["guest"]);  
$router->get("auth/organisations/login", "OrganisationController@login", ["guest"]);  

$router->post("auth/organisations/register", "OrganisationController@store", ["guest"]); 
$router->post("auth/organisations/login", "OrganisationController@authenticate", ["guest"]); 
$router->post("auth/organisations/logout", "OrganisationController@logout", ["org"]); 
