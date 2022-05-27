<?php
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Methods: POST");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Origin: http://www.projecthree.com/");
// header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");

// include_once'autoload.php';

// use ApexPHP\Httpx;


// $data = Httpx::getJSONRequest(["topic", "student_email", "university_name", "department_name"]);


// $db = Httpx::getDB();


// $user = new User($db);

// $user->authorize();

// $pro = new Project($db);

// $pro->set_supervisor($user);
// $pro->set_topic($data['topic']);
// $pro->set_student($data['student_email']);
// $pro->set_university($data['university_name']);
// $pro->set_department($data['department_name']);

// $response = $pro->create();


// if (isset($response['input_errors'])) {
// 	Httpx::sendBadRequest(null, "Input Errors", null, $response['input_errors']);
// } elseif (isset($response[ApexPHP\ApexDB::ERR_KEY])) {
// 	Httpx::sendInternalServerError(null, $response[ApexPHP\ApexDB::ERR_KEY]);
// } else {
// 	Httpx::sendJSONResponse(Httpx::X_CREATED, Httpx::R_SUCCESS, "Project Created", null, ["id"=> $response['success']]);
// }
