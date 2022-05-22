<?php


header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: http://www.projecthree.com/");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");


include_once'autoload.php';

use ApexPHP\Httpx;


$data = Httpx::getGETRequest(["id", "page_start", "page_limit"]);


$db = Httpx::getDB();


$user = new User($db);

$user->authorize();

$pro = new Project($db, $data['id']);

if (!$pro->exists()) {
	Httpx::sendJSONResponse(Httpx::X_NOT_FOUND, Httpx::R_ERROR, "Project don't exist");
}

if (!$pro->is_participant($user)) {
	Httpx::sendJSONResponse(Httpx::X_FORBIDDEN, Httpx::R_ERROR, "You can't view documents of a project you don't participate in");
}

$documents = $pro->get_documents($data['page_start'], $data['page_limit']);

$count = $pro->get_documents_count();


Httpx::sendJSONResponse(Httpx::X_OK, Httpx::R_SUCCESS, null, null, array(
	"project_topic"=> $pro->get_topic(),
	"project_documents"=> $documents,
	"project_documents_count"=> $count
));





