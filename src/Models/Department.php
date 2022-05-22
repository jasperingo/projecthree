<?php



class Department {
	
	
	const DB = "department";
	
	private $db;
	
	private $id=0;
	
	private $name;
	
	private $acronym;
	
	
	public function __construct ($db, $id=null, $ac=null) {
		$this->db = $db;
		
		if (is_int($id)) {
			$this->id = $id;
		} elseif (is_string($id)) {
			$this->name = $id;
		}
		
		if ($ac !== null) {
			$this->acronym = $ac;
		}
	}
	
	public function get_id () {
		if ($this->id == 0) {
			$this->id = $this->db->selectColumnWhere(self::DB, "id", array("name = ?", $this->name));
		}
		
		return $this->id;
	}
	
	
	public function add () {
		$added = $this->db->insert(self::DB, array("name"=> $this->name, "acronym"=> $this->acronym));
		
		if ($added) {
			$this->id = $this->db->lastInsertId();
		}
		
		return $added;
	}
	
	
	
}





