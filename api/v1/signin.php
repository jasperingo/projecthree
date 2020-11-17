<?php


header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: http://www.projecthree.com/");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");


include_once'autoload.php';


use ApexPHP\Httpx;


$data = Httpx::getJSONRequest(["email", "password"]);


$db = Httpx::getDB();


$user = new User($db);


$response = $user->sign_in($data['email'], $data['password']);


if (isset($response['email_error'])) {
	Httpx::sendBadRequest(null, "Email Error", null, $response);
} elseif (isset($response['password_error'])) {
	Httpx::sendBadRequest(null, "Password Error", null, $response);
} elseif (isset($response[ApexPHP\ApexDB::ERR_KEY])) {
	Httpx::sendInternalServerError(null, $response[ApexPHP\ApexDB::ERR_KEY]);
} else {
	Httpx::sendJSONResponse(Httpx::X_OK, Httpx::R_SUCCESS, "Signed In", null, $response['success']);
}


