<?php

namespace ApexPHP;


class Httpx {
	
	//1×× Informational
	const X_CONTINUE = 100;
	const X_SWITCHING_PROTOCOLS = 101;
	const X_PROCESSING = 102;
	
	//2×× Success
	const X_OK = 200;
	const X_CREATED = 201;
	const X_ACCEPTED = 202;
	const X_NON_AUTHORITATIVE_INFORMATION = 203;
	const X_NO_CONTENT = 204;
	const X_RESET_CONTENT = 205;
	const X_PARTIAL_CONTENT = 206;
	const X_MULTI_STATUS = 207;
	const X_ALREADY_REPORTED = 208;
	const X_IM_USED = 226;
	
	//3×× Redirection
	const X_MULTIPLE_CHOICES = 300;
	const X_MOVED_PERMANENTLY = 301;
	const X_FOUND = 302;
	const X_SEE_OTHER = 303;
	const X_NOT_MODIFIED = 304;
	const X_USE_PROXY = 305;
	const X_TEMPORARY_REDIRECT = 307;
	const X_PERMANENT_REDIRECT = 308;
	
	//4×× Client Error
	const X_BAD_REQUEST = 400;
	const X_UNAUTHORIZED = 401;
	const X_PAYMENT_REQUIRED = 402;
	const X_FORBIDDEN = 403;
	const X_NOT_FOUND = 404;
	const X_METHOD_NOT_ALLOWED = 405;
	const X_NOT_ACCEPTABLE = 406;
	const X_PROXY_AUTHENTICATION_REQUIRED = 407;
	const X_REQUEST_TIMEOUT = 408;
	const X_CONFLICT = 409;
	const X_GONE = 410;
	const X_LENGTH_REQUIRED = 411;
	const X_PRECONDITION_FAILED = 412;
	const X_PAYLOAD_TOO_LARGE = 413;
	const X_REQUEST_URI_TOO_LONG = 414;
	const X_UNSUPPORTED_MEDIA_TYPE = 415;
	const X_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
	const X_EXPECTATION_FAILED = 417;
	const X_I_M_A_TEAPOT = 418;
	const X_MISDIRECTED_REQUEST = 421;
	const X_UNPROCESSABLE_ENTITY = 422;
	const X_LOCKED = 423;
	const X_FAILED_DEPENDENCY = 424;
	const X_UPGRADE_REQUIRED = 426;
	const X_PRECONDITION_REQUIRED = 428;
	const X_TOO_MANY_REQUESTS = 429;
	const X_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;
	const X_CONNECTION_CLOSED_WITHOUT_RESPONSE = 444;
	const X_UNAVAILABLE_FOR_LEGAL_REASONS = 451;
	const X_CLIENT_CLOSED_REQUEST = 499;
	
	//5×× Server Error
	const X_INTERNAL_SERVER_ERROR = 500;
	const X_NOT_IMPLEMENTED = 501;
	const X_BAD_GATEWAY = 502;
	const X_SERVICE_UNAVAILABLE = 503;
	const X_GATEWAY_TIMEOUT = 504;
	const X_HTTP_VERSION_NOT_SUPPORTED = 505;
	const X_VARIANT_ALSO_NEGOTIATES = 506;
	const X_INSUFFICIENT_STORAGE = 507;
	const X_LOOP_DETECTED = 508;
	const X_NOT_EXTENDED = 510;
	const X_NETWORK_AUTHENTICATION_REQUIRED = 511;
	const X_NETWORK_CONNECT_TIMEOUT_ERROR = 599;
	
	
	const CONTENT_JSON = 0;
	const CONTENT_XML = 1;
	const CONTENT_HTML = 2;
	
	const R_SUCCESS = "success";
	const R_ERROR = "error";
	const R_TITLE = "title";
	const R_MESSAGE = "message";
	const R_REQUIRED_PARAMETERS = "required_parameters";
	
	
	public static $contentType = 0;
	
	
	
	public static function getContentType ($local=null) {
		return $local == null ? self::$contentType : $local;
	}
	
	public static function getDB ($contentType=null, $message=null, $title=null, $more=array()) : ApexDB {
		
		$db = ApexDB::getNew();
		
		if ($db === null) {
			$message = $message == null ? ApexDB::CONNECT_ERR : $message;
			self::sendInternalServerError($contentType, $message, $title, $more);
		}
	
		return $db;
	}
	
	
	public static function getJSONRequest ($keys, $contentType=null, $message=null, $title=null, $more=array()) : array {
		
		$j = json_decode(file_get_contents("php://input"), true); 
	
		if ($j === null || !self::checkRequestParameters($j, $keys)) {
			$more[self::R_REQUIRED_PARAMETERS] = $keys;
			self::sendBadRequest($contentType, $message, $title, $more);
		}
	
		return $j;
	}
	
	public static function getGETRequest ($keys, $contentType=null, $message=null, $title=null, $more=array()) {
	
		if (empty($_GET) || !self::checkRequestParameters($_GET, $keys)) {
			$more[self::R_REQUIRED_PARAMETERS] = $keys;
			self::sendBadRequest($contentType, $message, $title, $more);
		}
		
		return $_GET;
	}
	
	public static function getPOSTRequest ($keys, $contentType=null, $message=null, $title=null, $more=array()) {
	
		if (empty($_POST) || !self::checkRequestParameters($_POST, $keys)) {
			$more[self::R_REQUIRED_PARAMETERS] = $keys;
			self::sendBadRequest($contentType, $message, $title, $more);
		}
		
		return $_POST;
	}
	
	public static function getFILESRequest ($keys, $contentType=null, $message=null, $title=null, $more=array()) {
	
		if (empty($_FILES) || !self::checkRequestParameters($_FILES, $keys)) {
			$more[self::R_REQUIRED_PARAMETERS] = $keys;
			self::sendBadRequest($contentType, $message, $title, $more);
		}
		
		return $_FILES;
	}
	
	public static function checkRequestParameters ($data, $keys) {
		foreach ($keys as $i=> $k) {
			if (is_array($k)) {
				if (!isset($data[$i])) {
					return false;
				}
				if (!self::checkRequestParameters($data[$i], $k)) {
					return false;
				}
			} elseif (!isset($data[$k])) {
				return false;
			}
		}
		
		return true;
	}
	
	public static function sendBadRequest (int $contentType=null, $message=null, string $title=null, array $more=array()) {
		
		if (self::getContentType($contentType) == self::CONTENT_JSON) {
			if (is_array($message)) {
				self::sendJSONResponse(self::X_BAD_REQUEST, $message);
			} else {
				$title = $title == null ? "Request Error" : $title;
				$message = $message == null ? "Request is invalid" : $message;
				self::sendJSONResponse(self::X_BAD_REQUEST, self::R_ERROR, $message, $title, $more);
			}
			
		}
		
	}
	
	public static function sendUnauthorized ($contentType=null, $message=null, $title=null, $more=array()) {
		
		if (self::getContentType($contentType) == self::CONTENT_JSON) {
			if (is_array($message)) {
				self::sendJSONResponse(self::X_UNAUTHORIZED, $message);
			} else {
				$title = $title == null ? "Authorization Error" : $title;
				$message = $message == null ? "Authorization failed" : $message;
				header("WWW-Authenticate: Custom");
				self::sendJSONResponse(self::X_UNAUTHORIZED, self::R_ERROR, $message, $title, $more);
			}
		}
		
		
	}
	
	public static function sendInternalServerError ($contentType=null, $message=null, $title=null, $more=array()) {
		
		if (self::getContentType($contentType) == self::CONTENT_JSON) {
			if (is_array($message)) {
				self::sendJSONResponse(self::X_INTERNAL_SERVER_ERROR, $message);
			} else {
				$title = $title == null ? "Internal Server Error" : $title;
				$message = $message == null ? "An error occurred on the server. Try again" : $message;
				self::sendJSONResponse(self::X_INTERNAL_SERVER_ERROR, self::R_ERROR, $message, $title, $more);
			}
			
		}
		
	}
	
	
	public static function sendJSONResponse (int $code, $type=null, string $message=null, string $title=null, array $more=array()) : void {
		
		if (!is_array($type)) {
			$response = [];
			
			if ($title != null) {
				$response[$type][self::R_TITLE] = $title;
			}
			
			if ($message != null) {
				$response[$type][self::R_MESSAGE] = $message;
			}
			
			foreach ($more as $i=> $v) {
				$response[$type][$i] = $v;
			}
			
		} else {
			$response = $type;
		}
		
		http_response_code($code);
		echo json_encode($response);
		exit;
	}
	
	
	
	
	
}




