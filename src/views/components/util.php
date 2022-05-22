<?php

session_start();

define("PAGE_LIMIT", 2);

define("API_URL", "http://localhost:8080/www.project3.com/api/v1/");

$strings = json_decode(file_get_contents(dirname(__DIR__).'/strings/english.json'), true);

$icons = json_decode(file_get_contents(dirname(__DIR__).'/icons/icons.json'), true);

header("Cache-Control: no-store");


function signed_in () {
	
	if (!isset($_COOKIE['_PJ3_'])) {
		return false;
	}
	
	return true;
}

function make_cookie ($id, $token) {
	setcookie("_PJ3_", json_encode(array(
		"id"=> $id, 
		"token"=> $token
	)), (time() + (10 * 365 * 24 * 60 * 60)), "/");
}

function burn_cookie () {
	session_unset();
	session_destroy();
	setcookie("_PJ3_", "", (time() - (10 * 365 * 24 * 60 * 60)), "/");
}


function user_id () {
	
	if (!signed_in()) {
		return 0;
	}
	
	return json_decode($_COOKIE['_PJ3_'], true)['id'];
}


function user_token () {
	
	if (!signed_in()) {
		return "";
	}
	
	return json_decode($_COOKIE['_PJ3_'], true)['token'];
}


function app_headers () {
	return array_merge(array("Content-type:application/json"), auth_header());
}

function auth_header () {
	
	if (!signed_in()) {
		return array();
	}
	
	return array("X-Authorization:Bearer ".user_token());
}


function urlRedirect ($url) {
	header("Location: ".$url);
	exit;
}

function httpCodeCurl ($r) {
	return curl_getinfo($r)['http_code'];
}

function postCurl (string $url, $postData, array $headers=array()) : array {
	
	$handle = curl_init();
	
	$options = array(
		CURLOPT_URL=> $url,
		CURLOPT_POST=> true,
		CURLOPT_RETURNTRANSFER=> true, 
		CURLOPT_POSTFIELDS=> $postData, 
	);
	
	if (!empty($headers)) {
		$options[CURLOPT_HTTPHEADER] = $headers;
	}
	
	curl_setopt_array($handle, $options);
	
	$response = curl_exec($handle);
	
	return [$handle, $response];
}


function getCurl (string $url,  array $headers=array()) : array {
	
	$handle = curl_init();
	
	$options = array(
		CURLOPT_URL=> $url,
		CURLOPT_RETURNTRANSFER=> true, 
	);
	
	if (!empty($headers)) {
		$options[CURLOPT_HTTPHEADER] = $headers;
	}
	
	curl_setopt_array($handle, $options);
	
	$response = curl_exec($handle);
	
	return [$handle, $response];
}

function getCurlHeaders ($headers) {
	
	$headers_indexed_arr = explode("\r\n", $headers);
	
	$headers_arr = array();
	
	foreach ($headers_indexed_arr as $value) {
		if(count($matches = explode(':', $value, 2)) == 2) {
			$headers_arr[$matches[0]] = trim($matches[1]);
		}                
	}
	
	return $headers_arr;
}





function getPageStart (string $key, int $limit) : int {
	
	$page = isset($_GET[$key]) ? (int)$_GET[$key] : 1;
	
	if ($page < 1 || $page == 1) {
		$page1 = 0;
	} else {
		$page1 = ($page * $limit)-$limit;
	}

	return $page1;
}


function lineBreakString (string $text) : string {
	return preg_replace("/\s{2}/", "&nbsp;", nl2br($text)); 
}


function makeDate (string $date) : string {
	return date("d M Y", strtotime($date));
}


function getPagesBox (string $key, int $maxPages, string $url, string $className=null, string $id="", array $icons=array("next"=> ">", "previous"=> "<")) : string {
	
	if ($maxPages == 0) {
		return "";
	}
	
	$page = isset($_GET[$key]) ? (int)$_GET[$key] : 1;
	
	$className = $className==null ? "pagination-box" : $className;
	
	$box = "";
	if ($page-1 <= 1 || $page-1 >= $maxPages) {
		$box .= "<span>".$icons['previous']."</span> ";
	} else {
		$box .= "<a href=\"".$url.($page-2).$id."\" >".$icons['previous']."</a> ";
	}
	
	if ($page == 1) {
		$start = 1; 
	} elseif ($page >= $maxPages) {
		if ($maxPages > 2) {
			$start = $maxPages-2;
		} elseif ($maxPages == 2 || $maxPages == 1) {
			$start = 1;
		} else {
			$start = 0;
		}
	} else {
		$start = $page-1;
	}
	
	if ($maxPages == 0) {
		$len = 0;
	} elseif ($maxPages < 3) {
		$len = $maxPages+1;
	} else {
		$len = $start+3;
	}
	
	for ($i=$start;$i<$len;$i++) {
		$box .= "<a href=\"".$url.$i.$id."\" class=\"".($page == $i ? "active" : "")."\">".$i."</a> ";
	}
	
	if ($page+1 >= $maxPages) {
		$box .= "<span>".$icons['next']."</span> ";
	} else {
		$box .= "<a href=\"".$url.($page+2).$id."\" >".$icons['next']."</a> ";
	}
	
	return !empty($box) ? "<div class=\"".$className."\">".$box."</div>" : "";
}




function get_no_data_box ($txt) {
	return "<div class=\"no-data-box\">".$txt."</div>";
}

function get_input_error ($t) {
	return '<span class="input-error-span">'.$t.'</span>';
}

function get_form_error ($t) {
	return '<div class="form-error-box">'.$t.'.</div>';
}

function get_form_success ($t) {
	return '<div class="form-success-box">'.$t.'.</div>';
}



/*array(
	"name"=> "Federal University of Technology Owerri", 
	"abbreviation"=> "FUTO", 
	"departments"=> array(
		"Agricultural Economics", 
		"Agricultural Extension", 
		"Animal Science and Technology", 
		"Crop Science and Technology", 
		"Fisheries and Aquaculture Technology", 
		"Forestry and Wildlife Technology", 
		"Soil Science and Technology",
		"Anatomy", 
		"Physiology", 
		"Biochemistry", 
		"Biology", 
		"Biotechnology", 
		"Microbiology", 
		"Forensic Science", 
		"Computer Science", 
		"Information Technology", 
		"Cyber Security", 
		"Software Engineering", 
		"Agricultural and Bio-Resources Engineering", 
		"Chemical Engineering", 
		"Civil Engineering", 
		"Electrical and Electronics Engineering", 
		"Food Science Technology", 
		"Material and Metallurgical Engineering", 
		"Mechanical Engineering", 
		"Mechatronics Engineering", 
		"Petroleum Engineering", 
		"Polymer and Textile Engineering",
		"Architecture", 
		"Building Technology", 
		"Environmental Technology", 
		"Quantity Surveying", 
		"Surveying and Geoinformatics", 
		"Urban and Regional Planning", 
		"Biomedical Technology", 
		"Dental Technology", 
		"Optometry", 
		"Prosthetics and Othortics", 
		"Public Health Technology", 
		"Financial Management Technology", 
		"Maritime Management Technology", 
		"Project Management Technology", 
		"Transport Management Technology", 
		"Management Technology", 
		"Chemistry", 
		"Geology", 
		"Mathematics", 
		"Physics", 
		"Science Laboratory Technology", 
		"Statistics"
	)
);*/


/*'In view of the global *outbreak of coronavirus* ,  All Nigerians should take care of their health and maintain hand and respiratory hygiene to protect themselves and others, including their own families, following the precautions below:

1. Regularly and thoroughly wash your hands with soap and water, and use alcohol-based hand sanitiser.

2. Maintain at least 1 & half metres (5 feet) distance between yourself and anyone who is coughing or sneezing.

3. Persons with persistent cough or sneezing should stay home or keep a social distance, but not mix in crowd.

4. Make sure you and people around you, follow good respiratory hygiene, meaning cover your mouth and nose with a tissue or into your sleeve at the bent elbow or tissue when you cough or sneeze. Then dispose of the used tissue immediately.

5. Stay home if you feel unwell with symptoms like fever, cough and difficulty in breathing. Please call NCDC toll free number which is available day and night, for guidance- 0800-970000-10. Do not engage in self-medication

6. Stay informed on the latest developments about COVID-19 through official channels on TV and Radio, including the Lagos State Ministry of Health, NCDC and Federal Ministry of Health.';*/







