<?php


header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: http://www.projecthree.com/");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");


include_once'autoload.php';

use ApexPHP\Httpx;


$data = Httpx::getGETRequest(["page_start", "page_limit"]);


$db = Httpx::getDB();


$response = University::get_list($db, $data['page_start'], $data['page_limit']);

$count = University::get_list_count($db);


Httpx::sendJSONResponse(Httpx::X_OK, Httpx::R_SUCCESS, null, null, array(
	"universities"=> $response, 
	"universities_count"=> $count
));





