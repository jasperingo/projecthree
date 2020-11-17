<?php

use ApexPHP\Httpx, ApexPHP\Valid;


class Admin {
	
	
	const DB = "admin";
	
	
	public static function authorize ($db, $id, $password) {
		
		if (!$db->selectColumnWhere(self::DB, "id", array("id = ?", $id))) { 
			Httpx::sendUnauthorized(null, "Invalid Admin id");
		}
		
		$db_password = $db->selectColumnWhere(self::DB, "password", array("id = ?", $id));
		
		$pwd_check = Valid::string($password, 10, 5, password_verify($password, $db_password));
		
		if ($pwd_check != 4) {
			Httpx::sendUnauthorized(null, "Invalid Admin password");
		}
	}
	
	
	
}




