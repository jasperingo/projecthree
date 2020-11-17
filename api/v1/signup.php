<?php


header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: http://www.projecthree.com/");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");


include_once'autoload.php';


use ApexPHP\Httpx;


$data = Httpx::getJSONRequest(["title", "first_name", "last_name", "email", "password"]);


$db = Httpx::getDB();


$user = new User($db);

$user->set_title($data['title']);
$user->set_first_name($data['first_name']);
$user->set_last_name($data['last_name']);
$user->set_email($data['email']);
$user->set_password($data['password']);


$response = $user->sign_up();


if (isset($response['input_errors'])) {
	Httpx::sendBadRequest(null, "Input Errors", null, $response['input_errors']);
} elseif (isset($response[ApexPHP\ApexDB::ERR_KEY])) {
	Httpx::sendInternalServerError(null, $response[ApexPHP\ApexDB::ERR_KEY]);
} else {
	Httpx::sendJSONResponse(Httpx::X_CREATED, Httpx::R_SUCCESS, "Sign Up", null, $response['success']);
}



