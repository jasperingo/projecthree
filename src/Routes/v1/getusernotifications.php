<?php


header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: http://www.projecthree.com/");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, X-Authorization");


include_once'autoload.php';


use ApexPHP\Httpx;


$data = Httpx::getGETRequest(["page_start", "page_limit"]);


$db = Httpx::getDB();


$user = new User($db);

$user->authorize();

$notifications = $user->get_notifications($data['page_start'], $data['page_limit']);

$count = $user->get_notifications_count();


Httpx::sendJSONResponse(Httpx::X_OK, Httpx::R_SUCCESS, null, null, array(
	"user_notifications"=> $notifications,
	"user_notifications_count"=> $count
));







