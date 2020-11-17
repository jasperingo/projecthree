<?php

use ApexPHP\Valid, ApexPHP\RandString as Rs, ApexPHP\ApexDB as DB;


class RecoverPassword {
	
	
	const DB = "user_recover_password";
	
	const TIME_INTERVAL = 1800;
	
	private $db;
	
	private $user;
	
	
	public function __construct ($db) {
		$this->db = $db;
	}
	
	
	public function send_request ($email) {
		
		$this->user = new User($this->db);
		
		$email_check = Valid::email($email, $this->user->email_exists($email));
		
		if ($email_check != 3) { 
			return array("email_error"=> $email_check);
		}
		
		$this->user->set_email($email);
		
		$code = Rs::get(6, Rs::TYPE_ALPHANUM, Rs::ALPHA_UP);
		
		$requested = $this->db->useTransaction(function () use ($code) {
			if ($this->user_has_pending() && !$this->db->update(self::DB, array("used"=> 1), array("user_id = ?", $this->user->get_id()))) {
				return false;
			}
			
			if (!$this->db->insert(self::DB, array("user_id"=> $this->user->get_id(), "code"=> $code))) {
				return false;
			}
		});
		
		if (!$requested) {
			return DB::getError(DB::INSERT_ERR);
		}
		
		return array("success"=> $code);
	}
	
	
	private function user_has_pending () {
		return $this->db->selectColumnWhere(self::DB, "id", array(
			"user_id = ? AND used = ?", 
			array($this->user->get_id(), 0)
		), 0);
	}
	
	
	public function recover ($email, $code, $password) {
		
		$this->user = new User($this->db);
		
		$this->user->set_email($email);
		
		$result = $this->db->selectRowWhere(self::DB, array("id", "code", "date"), array(
			"user_id = ? AND used = ?", 
			array($this->user->get_id(), 0)
		));
		
		if (!$result || $code != $result['code']) {
			return array("code_error"=> 1);
		}
		
		if ((strtotime($result['date'])+self::TIME_INTERVAL) <= time()) {
			return array("code_error"=> 2);
		}
		
		$pwd_check = Valid::string($password, User::PASSWORD_MAX_LIMIT, User::PASSWORD_MIN_LIMIT);
		
		if ($pwd_check != 0) {
			return array("password_error"=> $pwd_check);
		}
		
		$updated = $this->db->useTransaction(function () use ($password, $result) {
			if (!$this->user->update_db_password($password)) {
				return false;
			}
			
			if (!$this->db->update(self::DB, array("used"=> 1), array("id = ?", $result['id']))) {
				return false;
			}
		});
		
		if (!$updated) {
			return DB::getError(DB::INSERT_ERR);
		}
		
		return array("success"=> 1);
	}
	
	
	
	
}


