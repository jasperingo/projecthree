<?php



class UniversityDepartment {
	
	
	const DB = "university_department";
	
	private $db;
	
	private $id=0;
	
	private $university;
	
	private $department;
	
	
	public function __construct ($db, $v1=null, $v2=null) {
		$this->db = $db;
		
		if (is_int($v1)) {
			$this->id = $v1;
		} elseif ($v1 instanceof University) {
			$this->university = $v1;
		}
		
		if ($v2 instanceof Department) {
			$this->department = $v2;
		}
	}
	
	public static function inst ($db, $v1=null, $v2=null) {
		return new UniversityDepartment($db, $v1, $v2);
	}
	
	public function get_id () {
		if ($this->id === 0) {
			$this->id = $this->db->selectColumnWhere(self::DB, "id", array(
				"university_id = ? AND department_id = ?", 
				array($this->university->get_id(), $this->department->get_id())
			));
		}
		
		return $this->id;
	}
	
	
	public function add () {
		return $this->db->insert(self::DB, array(
			"university_id"=> $this->university->get_id(), 
			"department_id"=> $this->department->get_id()
		));
	}
	
	public function remove () {
		return $this->db->delete(self::DB, array("id = ?", $this->get_id()));
	}
	
}



