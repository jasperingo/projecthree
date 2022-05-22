<?php

use ApexPHP\ApexDB as DB;


class Review extends Sendable {
	
	
	const DB = "review";
	
	private $star=0;
	
	
	public function set_star ($s) {
		$this->star = $s;
	}
	
	public function get_star () {
		return $this->star;
	}
	
	
	public function send () {
		
		$e = array();
		
		if ($this->get_star() < 1 || $this->get_star() > 5) {
			$e['star_error'] = 1;
		}
		
		if ($this->get_content() == "") {
			$e['content_error'] = 1;
		}
		
		if (!empty($e)) {
			return array("input_errors"=> $e);
		}
		
		$past_id = $this->get_sender_past_review();
		
		if ($past_id > 0) {
			
			$this->set_id($past_id);
			
			if (!$this->db->update(self::DB, array(
					"star"=> $this->get_star(),
					"content"=> $this->get_content(), 
					"date"=> date("Y-m-d h:i:s")
				), 
				array("id = ?", $this->get_id())
			)) {
				return DB::getError(DB::UPDATE_ERR);
			}
			
		} else {
			
			if (!$this->db->insert(self::DB, array(
				"project_id"=> $this->get_project()->get_id(), 
				"sender_id"=> $this->get_sender()->get_id(), 
				"star"=> $this->get_star(),
				"content"=> $this->get_content(), 
			))) {
				return DB::getError(DB::INSERT_ERR);
			}
			
			$this->set_id($this->db->lastInsertId());
		}
		
		return array("success"=> $this->get_id());
	}
	
	
	private function get_sender_past_review () {
		return $this->db->selectColumnWhere(self::DB, "id", array(
				"project_id = ? AND sender_id = ?",
				array($this->get_project()->get_id(), $this->get_sender()->get_id())
		), 0);
	}
	
	
	
}



