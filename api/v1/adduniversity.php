<?php


header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: http://www.projecthree.com/");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, X-Authorization");


include_once'autoload.php';

use ApexPHP\Httpx as H, ApexPHP\ApexDB as D;


$data = H::getJSONRequest(["id", "password", "name", "acronym", "address", "description", "departments"]);


$db = H::getDB();


Admin::authorize($db, $data['id'], $data['password']);


$uni = new University($db, $data['name']); 

$uni->set_acronym($data['acronym']);
$uni->set_address($data['address']);
$uni->set_description($data['description']);

$response = $uni->add($data['departments']);


if (isset($response['input_errors'])) {
	H::sendBadRequest(null, "Input Errors", null, $response['input_errors']);
} elseif (isset($response[D::ERR_KEY])) {
	H::sendInternalServerError(null, $response[D::ERR_KEY]);
} else {
	H::sendJSONResponse(H::X_CREATED, H::R_SUCCESS, "University added", null, ["id"=> $response['success']]);
}








