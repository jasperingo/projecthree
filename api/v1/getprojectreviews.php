<?php


header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: http://www.projecthree.com/");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, X-Authorization");


include_once'autoload.php';

use ApexPHP\Httpx;


$data = Httpx::getGETRequest(["id", "page_start", "page_limit"]);


$db = Httpx::getDB();


$user = null;

if (User::is_authorizable()) {
	$user = new User($db);
	$user->authorize();
}


$pro = new Project($db, $data['id']);

if (!$pro->exists()) {
	Httpx::sendJSONResponse(Httpx::X_NOT_FOUND, Httpx::R_ERROR, "Project don't exist");
}

if ($pro->get_privacy() == 0 && ($user == null || ($user != null && !$pro->is_participant($user)))) {
	Httpx::sendJSONResponse(Httpx::X_FORBIDDEN, Httpx::R_ERROR, "You can't view reviews of a private project you don't participate in");
}

$reviews = $pro->get_reviews($data['page_start'], $data['page_limit']);

$count = $pro->get_reviews_count();


Httpx::sendJSONResponse(Httpx::X_OK, Httpx::R_SUCCESS, null, null, array(
	"project_topic"=> $pro->get_topic(),
	"project_reviews"=> $reviews,
	"project_reviews_count"=> $count
));




