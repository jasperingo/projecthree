<?php


header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: POST, PUT");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: http://www.projecthree.com/");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, X-Authorization");


include_once'autoload.php';


use ApexPHP\Httpx as H;


$data = H::getJSONRequest(["project_document_id"]);


$db = H::getDB();


$user = new User($db);

$user->authorize();


$doc = new ProjectDocument($db, $data['project_document_id']);

if (!$doc->exists()) {
	H::sendJSONResponse(H::X_NOT_FOUND, H::R_ERROR, "Project document don't exist");
}

if (!$doc->get_project()->is_supervisor($user)) {
	H::sendJSONResponse(H::X_FORBIDDEN, H::R_ERROR, "A project document can only be approved by it's supervisor");
}

$response = $doc->approve();


if (isset($response[ApexPHP\ApexDB::ERR_KEY])) {
	H::sendInternalServerError(null, $response[ApexPHP\ApexDB::ERR_KEY]);
} else {
	H::sendJSONResponse(H::X_NO_CONTENT);
}




