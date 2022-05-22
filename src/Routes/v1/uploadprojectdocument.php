<?php


header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: http://www.projecthree.com/");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, X-Authorization");


include_once'autoload.php';


use ApexPHP\Httpx;


$data = Httpx::getPOSTRequest(["project_id"]);

$f = Httpx::getFILESRequest(["document"]);


$db = Httpx::getDB();


$user = new User($db);

$user->authorize();


$doc = new ProjectDocument($db);

$doc->set_project($data['project_id']);
$doc->set_name($f['document']['name']);


if (!$doc->get_project()->exists()) {
	Httpx::sendJSONResponse(Httpx::X_NOT_FOUND, Httpx::R_ERROR, "Project don't exist");
}

if (!$doc->get_project()->is_student($user)) {
	Httpx::sendJSONResponse(Httpx::X_FORBIDDEN, Httpx::R_ERROR, "A project document can only be uploaded by it's student");
}


$response = $doc->upload($f['document'], "../documents/");


if (isset($response['document_error'])) {
	Httpx::sendBadRequest(null, "Document Error", null, $response);
} elseif (isset($response[ApexPHP\ApexDB::ERR_KEY])) {
	Httpx::sendInternalServerError(null, $response[ApexPHP\ApexDB::ERR_KEY]);
} else {
	Httpx::sendJSONResponse(Httpx::X_OK, Httpx::R_SUCCESS, "Document uploaded", null, ["id"=> $response['success']]);
}




