<?php


header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: PUT, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: http://www.projecthree.com/");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, X-Authorization");


use ApexPHP\Httpx;


include_once'autoload.php';


$db = Httpx::getDB();


$user = new User($db);

$user->authorize();

$response = $user->sign_out();


if (isset($response[ApexPHP\ApexDB::ERR_KEY])) {
	Httpx::sendInternalServerError(null, $response[ApexPHP\ApexDB::ERR_KEY]);
} else {
	Httpx::sendJSONResponse(Httpx::X_NO_CONTENT);
}


