<?php


header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: http://www.projecthree.com/");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, X-Authorization");


include_once'autoload.php';

use ApexPHP\Httpx as H, ApexPHP\ApexDB as D;


$data = H::getJSONRequest(["id", "password", "name", "departments"]);


$db = H::getDB();


Admin::authorize($db, $data['id'], $data['password']);


$uni = new University($db, $data['name']);

if (!$uni->exists(false)) {
	H::sendJSONResponse(H::X_NOT_FOUND, H::R_ERROR, "University don't exist");
}

$response = $uni->add_departments($data['departments']);


if (isset($response['departments_error'])) {
	H::sendBadRequest(null, "Departments Error", null, $response);
} elseif (isset($response[D::ERR_KEY])) {
	H::sendInternalServerError(null, $response[D::ERR_KEY]);
} else {
	H::sendJSONResponse(H::X_NO_CONTENT);
}





