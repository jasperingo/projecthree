<?php


header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: http://www.projecthree.com/");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");


include_once'autoload.php';

use ApexPHP\Httpx;


$data = Httpx::getGETRequest(["id"]);


$db = Httpx::getDB();

if ($data['id'] < 1) {
	Httpx::sendJSONResponse(Httpx::X_NOT_FOUND, Httpx::R_ERROR, "User don't exist");
}

$user = new User($db, $data['id']);


$response = $user->get_data();


if (empty($response)) {
	Httpx::sendJSONResponse(Httpx::X_NOT_FOUND, Httpx::R_ERROR, "User don't exist");
} else {
	Httpx::sendJSONResponse(Httpx::X_OK, Httpx::R_SUCCESS, null, null, array("user"=> $response));
}




