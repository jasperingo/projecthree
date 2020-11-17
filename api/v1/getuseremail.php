<?php


header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: http://www.projecthree.com/");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, X-Authorization");


include_once'autoload.php';

use ApexPHP\Httpx;


$db = Httpx::getDB();


$user = new User($db);

$user->authorize();

$response = $user->get_email();


Httpx::sendJSONResponse(Httpx::X_OK, Httpx::R_SUCCESS, null, null, array("user_email"=> $response));





