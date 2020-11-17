<?php


header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: http://www.projecthree.com/");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");


include_once'autoload.php';

use ApexPHP\Httpx;


$data = Httpx::getGETRequest(["q", "page_start", "page_limit"]);


$db = Httpx::getDB();


$projects = Project::get_search($db, $data['q'], $data['page_start'], $data['page_limit']);

$count = Project::get_search_count($db, $data['q']);


Httpx::sendJSONResponse(Httpx::X_OK, Httpx::R_SUCCESS, null, null, array(
	"projects"=> $projects,
	"projects_count"=> $count
));





