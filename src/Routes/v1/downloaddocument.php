<?php


header("Access-Control-Allow-Methods: GET");
header('Content-Type: application/json; charset=UTF-8');
header("Access-Control-Allow-Origin: http://www.projecthree.com/");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, X-Authorization");


include_once'autoload.php';

use ApexPHP\Httpx;


$data = Httpx::getGETRequest(["id"]);


$db = Httpx::getDB();


$user = null;

if (User::is_authorizable()) {
	$user = new User($db);
	$user->authorize();
}

$doc = new ProjectDocument($db, $data['id']);

$filepath = "../documents/document".$data['id'].".".ApexPHP\Filex::getExtension($doc->get_name());

if (!$doc->exists() || !file_exists($filepath)) {
	Httpx::sendJSONResponse(Httpx::X_NOT_FOUND, Httpx::R_ERROR, "Project document don't exist");
}

if (($user == null || ($user != null && !$doc->get_project()->is_participant($user))) && ($doc->get_project()->get_privacy() == 0 || $doc->get_approved() == 0)) {
	Httpx::sendJSONResponse(Httpx::X_FORBIDDEN, Httpx::R_ERROR, "A private project or unapproved document cannot be downloaded");
}


$response = $doc->add_download($user==null?0:$user->get_id());


if (!$response) {
	Httpx::sendInternalServerError(null, ApexPHP\ApexDB::INSERT_ERR);
}


header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.$doc->get_name().'"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($filepath));

flush();

readfile($filepath);

exit;




