<?php


header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: http://www.projecthree.com/");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, X-Authorization");


include_once'autoload.php';

use ApexPHP\Httpx;


$data = Httpx::getJSONRequest(["topic", "privacy", "description", "id"]);


$db = Httpx::getDB();


$user = new User($db);

$user->authorize();

$pro = new Project($db, $data['id']);

if (!$pro->exists()) {
	Httpx::sendJSONResponse(Httpx::X_NOT_FOUND, Httpx::R_ERROR, "Project don't exist");
}

if (!$pro->is_supervisor($user)) {
	Httpx::sendJSONResponse(Httpx::X_FORBIDDEN, Httpx::R_ERROR, "A project can only be edited by it's supervisor");
}

$response = $pro->update($data['topic'], $data['privacy'], $data['description']);


if (isset($response['input_errors'])) {
	Httpx::sendBadRequest(null, "Input Errors", null, $response['input_errors']);
} elseif (isset($response[ApexPHP\ApexDB::ERR_KEY])) {
	Httpx::sendInternalServerError(null, $response[ApexPHP\ApexDB::ERR_KEY]);
} else {
	Httpx::sendJSONResponse(Httpx::X_NO_CONTENT);
}



