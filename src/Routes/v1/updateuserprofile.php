<?php


header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: POST, PUT");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: http://www.projecthree.com/");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, X-Authorization");


include_once'autoload.php';

use ApexPHP\Httpx;


$data = Httpx::getJSONRequest(["first_name", "last_name", "title", "bio"]);


$db = Httpx::getDB();


$user = new User($db);

$user->authorize();

$response = $user->update_profile($data);


if (isset($response['input_errors'])) {
	Httpx::sendBadRequest(null, "Input Errors", null, $response['input_errors']);
} elseif (isset($response[ApexPHP\ApexDB::ERR_KEY])) {
	Httpx::sendInternalServerError(null, $response[ApexPHP\ApexDB::ERR_KEY]);
} else {
	Httpx::sendJSONResponse(Httpx::X_OK, Httpx::R_SUCCESS, "Updated user profile");
}





