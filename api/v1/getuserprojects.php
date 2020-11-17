<?php


header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: http://www.projecthree.com/");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, X-Authorization");


include_once'autoload.php';

use ApexPHP\Httpx;


$data = Httpx::getGETRequest(["id", "page_start", "page_limit"]);


$db = Httpx::getDB();


$viewer = 0;

if (User::is_authorizable()) {
	$v = new User($db);
	$v->authorize();
	$viewer = $v->get_id();
}

$user = new User($db, $data['id']);

if ($data['id'] < 1 || empty($user->get_email())) {
	Httpx::sendJSONResponse(Httpx::X_NOT_FOUND, Httpx::R_ERROR, "User don't exist");
}

$projects = $user->get_projects($viewer, $data['page_start'], $data['page_limit']);

$count = $user->get_projects_count($viewer);


Httpx::sendJSONResponse(Httpx::X_OK, Httpx::R_SUCCESS, null, null, array(
	"user_projects"=> $projects,
	"user_projects_count"=> $count
));



