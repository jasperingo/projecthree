<?php


header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: POST, PUT");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: http://www.projecthree.com/");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, X-Authorization");


include_once'autoload.php';


use ApexPHP\Httpx as H, ApexPHP\ApexDB as D;


$data = H::getJSONRequest(["project_id"]);


$db = H::getDB();


$user = new User($db);

$user->authorize();


$pro = new Project($db, $data['project_id']);

if (!$pro->exists()) {
	H::sendJSONResponse(H::X_NOT_FOUND, H::R_ERROR, "Project don't exist");
}

if (!$pro->is_participant($user)) {
	H::sendJSONResponse(H::X_FORBIDDEN, H::R_ERROR, "A project can only update messages seen from it's participants");
}


$response = $pro->update_messages_seen($user->get_id());


if (isset($response[D::ERR_KEY])) {
	H::sendInternalServerError(null, $response[D::ERR_KEY]);
} else {
	H::sendJSONResponse(H::X_NO_CONTENT);
}





