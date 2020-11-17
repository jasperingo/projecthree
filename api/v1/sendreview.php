<?php


header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: http://www.projecthree.com/");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, X-Authorization");


include_once'autoload.php';

use ApexPHP\Httpx as H, ApexPHP\ApexDB as D;


$data = H::getJSONRequest(["project_id", "content", "star"]);


$db = H::getDB();


$user = new User($db);

$user->authorize();


$pro = new Project($db, $data['project_id']);

if (!$pro->exists()) {
	H::sendJSONResponse(H::X_NOT_FOUND, H::R_ERROR, "Project don't exist");
}

if ($pro->get_privacy() == 0 || $pro->is_participant($user)) {
	H::sendJSONResponse(H::X_FORBIDDEN, H::R_ERROR, "A project can only receive reviews when it is public");
}


$r = new Review($db);

$r->set_sender($user);
$r->set_project($pro);
$r->set_star($data['star']);
$r->set_content($data['content']);


$response = $r->send();


if (isset($response['input_errors'])) {
	H::sendBadRequest(null, "Input Errors", null, $response['input_errors']);
} elseif (isset($response[D::ERR_KEY])) {
	H::sendInternalServerError(null, $response[D::ERR_KEY]);
} else {
	H::sendJSONResponse(H::X_OK, H::R_SUCCESS, "Review sent", null, ["id"=> $response['success']]);
}


