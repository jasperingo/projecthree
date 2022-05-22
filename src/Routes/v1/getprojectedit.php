<?php


header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: http://www.projecthree.com/");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, X-Authorization");


include_once'autoload.php';

use ApexPHP\Httpx;


$data = Httpx::getGETRequest(["id"]);


$db = Httpx::getDB();


$user = new User($db);

$user->authorize();


$pro = new Project($db, $data['id']);

if (!$pro->exists()) {
	http_response_code(HTTP_NOT_FOUND);
	exit;
}

if (!$pro->is_supervisor($user)) {
	Httpx::sendJSONResponse(Httpx::X_FORBIDDEN, Httpx::R_ERROR, "A project can only be edited by it's supervisor");
}

$response = $pro->get_edit_data();


if (empty($response)) {
	Httpx::sendJSONResponse(Httpx::X_NOT_FOUND, Httpx::R_ERROR, "Project don't exist");
} else {
	Httpx::sendJSONResponse(Httpx::X_OK, Httpx::R_SUCCESS, null, null, array("project"=> $response));
}





