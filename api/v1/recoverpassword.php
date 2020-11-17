<?php


header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: POST, PUT");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: http://www.projecthree.com/");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");


include_once'autoload.php';

use ApexPHP\Httpx;


$data = Httpx::getJSONRequest(["email", "code", "password"]);


$db = Httpx::getDB();


$rp = new RecoverPassword($db);

$response = $rp->recover($data['email'], $data['code'], $data['password']);


if (isset($response['code_error'])) {
	Httpx::sendBadRequest(null, "Code Error", null, $response);
} elseif (isset($response['password_error'])) {
	Httpx::sendBadRequest(null, "Password Error", null, $response);
} elseif (isset($response[ApexPHP\ApexDB::ERR_KEY])) {
	Httpx::sendInternalServerError(null, $response[ApexPHP\ApexDB::ERR_KEY]);
} else {
	Httpx::sendJSONResponse(Httpx::X_NO_CONTENT);
}







