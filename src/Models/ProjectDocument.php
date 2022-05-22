<?php

use ApexPHP\Filex, ApexPHP\ApexDB as DB;


class ProjectDocument {
	
	
	const DB = "project_document";
	
	
	private $db=null;
	
	private $id=0;
	
	private $project;
	
	private $name;
	
	private $approved;
	
	
	public function __construct ($db, $doc_id=0) {
		$this->db = $db;
		$this->set_id($doc_id);
	}
	
	
	public function set_id ($doc_id) {
		$this->id = (int)$doc_id;
	}
	
	public function set_project ($p) {
		if (is_int($p) || is_string($p)) {
			$this->project = new Project($this->db, $p);
		} else {
			$this->project = $p;
		}
	}
	
	public function set_name ($n) {
		$this->name = trim($n);
	}
	
	public function set_approved ($aprv) {
		$this->approved = $aprv;
	}
	
	
	public function get_id () {
		return $this->id;
	}
	
	public function get_project () {
		if ($this->project === null) {
			$this->set_project($this->get_db_data("project_id", 0));
		}
		
		return $this->project;
	}
	
	public function get_name () {
		if ($this->name === null) {
			$this->set_name($this->get_db_data("name", ""));
		}
		
		return $this->name;
	}
	
	public function get_approved () {
		if ($this->approved === null) {
			$this->set_approved($this->get_db_data("approved", 0));
		}
		
		return $this->approved;
	}
	
	private function get_db_data ($column, $d=false) {
		return $this->db->selectColumnWhere(self::DB, $column, array("id = ?", $this->get_id()), $d);
	}
	
	public function exists () {
		return !empty($this->get_name());
	}
	
	
	public function upload ($doc, $dir) {
		
		$doc_check = Filex::validate($doc, array(
			Filex::VALID_EXTENSION=> Filex::APPLICATION_EXTS,  
			Filex::VALID_TYPE=> Filex::APPLICATION_TYPE
		));
		
		if ($doc_check != 0) {
			return array("document_error"=> $doc_check);
		}
		
		$added = $this->db->useTransaction(function () {
			
			if (!$this->db->insert(self::DB, array(
				"project_id"=> $this->get_project()->get_id(), 
				"name"=> $this->get_name()
			))) {
				return false;
			}
			
			$this->set_id($this->db->lastInsertId());
			
			$msg = new Message($this->db);
			$msg->set_project($this->get_project());
			$msg->set_sender($this->get_project()->get_student());
			$msg->set_automated(Message::AUTO_NEW_DOC);
			
			if (!isset($msg->send()['success'])) {
				return false;
			}
		});
		
		if (!$added) {
			return DB::getError(DB::INSERT_ERR);
		}
		
		$dir .= "document".$this->get_id().".".Filex::getExtension($doc);
		
		$uploaded = Filex::upload($doc, $dir);
		
		if ($uploaded != 0) {
			return array("document_error"=> $uploaded);
		}
		
		return array("success"=> $this->get_id());
	}
	
	
	public function approve () {
		
		if ($this->get_approved() == 1) {
			return array("success"=> 1);
		}
		
		$updated = $this->db->useTransaction(function () {
			
			if (!$this->get_project()->disapprove_document()) {
				return false;
			}
			
			if (!$this->update_approved(1)) {
				return false;
			}
			
			$msg = new Message($this->db);
			$msg->set_project($this->get_project());
			$msg->set_sender($this->get_project()->get_supervisor());
			$msg->set_automated(Message::AUTO_DOC_APPROVED);
			
			if (!isset($msg->send()['success'])) {
				return false;
			}
		});
		
		if (!$updated) {
			return DB::getError(DB::UPDATE_ERR);
		}
		
		return array("success"=> 1);
	}
	
	
	public function disapprove () {
		
		if ($this->get_approved() == 0) {
			return array("success"=> 1);
		}
		
		$updated = $this->db->useTransaction(function () {
			
			if (!$this->update_approved(0)) {
				return false;
			}
			
			$msg = new Message($this->db);
			$msg->set_project($this->get_project());
			$msg->set_sender($this->get_project()->get_supervisor());
			$msg->set_automated(Message::AUTO_DOC_DISAPPROVED);
			
			if (!isset($msg->send()['success'])) {
				return false;
			}
		});
		
		if (!$updated) {
			return DB::getError(DB::UPDATE_ERR);
		}
		
		return array("success"=> 1);
	}
	
	
	private function update_approved ($a) {
		return $this->db->update(
			self::DB, 
			array("approved"=> $a), 
			array("id = ?", $this->get_id())
		);
	}
	
	
	public function add_download ($user_id) {
		return $this->db->insert("download", array(
			"user_id"=> $user_id, 
			"document_id"=> $this->get_id()
		));
	}
	
	
}

