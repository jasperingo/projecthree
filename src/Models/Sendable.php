<?php

class Sendable {
	
	
	protected $db;
	
	protected $id=0;
	
	protected $project;
	
	protected $sender;
	
	protected $content="";
	
	
	public function __construct ($db) {
		$this->db = $db;
	}
	
	
	public function set_id ($sid) {
		$this->id = (int)$sid;
	}
	
	public function set_project ($p) {
		if (is_int($p)) {
			$this->project = new Project($this->db, $p);
		} else {
			$this->project = $p;
		}
	}
	
	public function set_sender ($s) {
		$this->sender = $s;
	}
	
	public function set_content ($c) {
		$this->content = trim($c);
	}
	
	
	public function get_id () {
		return $this->id;
	}
	
	public function get_project () {
		return $this->project;
	}
	
	public function get_sender () {
		return $this->sender;
	}
	
	public function get_content () {
		return $this->content;
	}
	
	
	
}


