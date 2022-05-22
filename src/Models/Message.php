<?php

use ApexPHP\ApexDB as DB;


class Message extends Sendable {
	
	
	const DB = "message";
	
	const AUTO_NEW_PROJECT = 1;
	
	const AUTO_PROJECT_EDIT = 2;
	
	const AUTO_NEW_DOC = 3;
	
	const AUTO_DOC_APPROVED = 4;
	
	const AUTO_DOC_DISAPPROVED = 5;
	
	
	private $automated=0;
	
	private $seen=0;
	
	
	public function __construct ($db) {
		$this->db = $db;
	}
	
	
	public function set_automated ($a) {
		$this->automated = $a;
	}
	
	public function set_seen ($s) {
		$this->seen = $s;
	}
	
	
	public function get_automated () {
		return $this->automated;
	}
	
	public function get_seen () {
		return $this->seen;
	}
	
	
	public function send () {
		
		if ($this->get_automated() == 0 && $this->get_content() == "") {
			return array("content_error"=> 1);
		}
		
		if (!$this->db->insert(self::DB, array(
			"project_id"=> $this->get_project()->get_id(), 
			"sender_id"=> $this->get_sender()->get_id(), 
			"automated"=> $this->get_automated(), 
			"content"=> $this->get_content(), 
		))) {
			return DB::getError(DB::INSERT_ERR);
		}
		
		$this->set_id($this->db->lastInsertId());
		
		return array("success"=> $this->get_id());
	}
	
	
	
	
}


