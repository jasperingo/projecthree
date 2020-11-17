<?php


include_once'res/php/util.php';


if (!isset($_GET['id'])) {
	urlRedirect("400.html");
}


$handle = curl_init();

$options = array(
	CURLOPT_URL=> API_URL."downloaddocument.php?id=".$_GET['id'],
	CURLOPT_RETURNTRANSFER=> true, 
	CURLOPT_HTTPHEADER=> auth_header(),
	CURLOPT_HEADER=> true,
);

curl_setopt_array($handle, $options);
	
$response = curl_exec($handle);

if (curl_errno($handle)) {
	urlRedirect("500.html");
}

$code = httpCodeCurl($handle);

switch ($code) {
	case 404 :
		urlRedirect("404.html");
	case 403 :
		urlRedirect("403.html");
	case 500 :
		urlRedirect("500.html");
}
	

$header_size = curl_getinfo($handle, CURLINFO_HEADER_SIZE);

$headers = getCurlHeaders(substr($response, 0, $header_size));

$body = substr($response, $header_size);


$file_name;

preg_match('/\".+\"/', $headers['Content-Disposition'], $file_name);

$file_name = substr($file_name[0], 1, (strlen($file_name[0])-2));


curl_close($handle);


header('Content-Description: File Transfer');
header('Content-Type: application/pdf');
header("Content-Transfer-Encoding: Binary");
header('Content-Disposition: attachment; filename="'.$file_name.'"');
header('Content-Length: '.$headers['Content-Length']);
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Expires: 0');

flush();

echo $body;





