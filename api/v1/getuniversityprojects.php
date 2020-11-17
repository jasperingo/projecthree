<?php


header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: http://www.projecthree.com/");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");


include_once'autoload.php';

use ApexPHP\Httpx;


$data = Httpx::getGETRequest(["id", "page_start", "page_limit"]);


$db = Httpx::getDB();


$uni = new University($db, (int)$data['id']);

if ($data['id'] < 1 || !$uni->exists()) {
	Httpx::sendJSONResponse(Httpx::X_NOT_FOUND, Httpx::R_ERROR, "University don't exist");
}

$projects = $uni->get_projects($data['page_start'], $data['page_limit']);

$count = $uni->get_projects_count();


Httpx::sendJSONResponse(Httpx::X_OK, Httpx::R_SUCCESS, null, null, array(
	"university_projects"=> $projects,
	"university_projects_count"=> $count
));








