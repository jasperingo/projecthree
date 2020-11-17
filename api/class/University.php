<?php

use ApexPHP\ApexDB as DB;


class University {
	
	
	const DB = "university";
	
	
	private $db;
	
	private $id=0;
	
	private $name;
	
	private $acronym;
	
	private $address;
	
	private $description;
	
	
	public function __construct ($db, $id=null) {
		$this->db = $db;
		
		if (is_int($id)) {
			$this->set_id($id);
		} elseif (is_string($id)) {
			$this->set_name($id);
		}
	}
	
	
	public function set_id ($_id) {
		$this->id = (int)$_id;
	}
	
	public function set_name ($n) {
		$this->name = trim($n);
	}
	
	public function set_acronym ($acr) {
		$this->acronym = strtoupper(trim($acr));
	}
	
	public function set_address ($addr) {
		$this->address = trim($addr);
	}
	
	public function set_description ($desc) {
		$this->description = trim($desc);
	}
	
	
	public function get_id () {
		if ($this->id == 0) {
			$this->id = $this->db->selectColumnWhere(self::DB, "id", array("name = ?", $this->get_name()));
		}
		
		return $this->id;
	}
	
	public function get_name () {
		if ($this->name === null) {
			$this->set_name($this->db->selectColumnWhere(self::DB, "name", array("id = ?", $this->get_id())));
		}
		
		return $this->name;
	}
	
	public function get_acronym () {
		return $this->acronym;
	}
	
	public function get_address () {
		return $this->address;
	}
	
	public function get_description () {
		return $this->description;
	}
	
	
	public function exists ($name=true) {
		if ($name) {
			return !empty($this->get_name());
		} else {
			return $this->get_id() != 0;
		}
	}
	
	
	public function add ($departments) {
		
		$input_errors = array();
		
		if (empty($this->get_name())) {
			$input_errors['name_error'] = 1;
		}
		
		if ($this->get_id() > 0) {
			$input_errors['name_error'] = 2;
		}
		
		if (empty($this->get_acronym())) {
			$input_errors['acronym_error'] = 1;
		}
		
		if (empty($this->get_address())) {
			$input_errors['address_error'] = 1;
		}
		
		if (empty($this->get_description())) {
			$input_errors['description_error'] = 1;
		}
		
		if (empty($departments)) {
			$input_errors['departments_error'] = 1;
		}
		
		foreach ($departments as $dept) {
			if (empty(trim($dept['name']))) {
				$input_errors['departments_error'] = 2;
			}
		}
		
		if (!empty($input_errors)) { 
			return array("input_errors"=> $input_errors); 
		}
		
		
		$added = $this->db->useTransaction(function () use ($departments) {
			
			if (!$this->db->insert(self::DB, array(
				"name"=> $this->get_name(), 
				"acronym"=> $this->get_acronym(), 
				"address"=> $this->get_address(), 
				"description"=> $this->get_description()
			))) {
				return false;
			}
			
			$this->set_id($this->db->lastInsertId());
			
			foreach ($departments as $dept) {
				
				$dp = new Department($this->db, $dept['name'], $dept['acronym']);
				
				if (!$dp->get_id()) {
					if (!$dp->add()) {
						return false;
					}
				}
				
				if (!UniversityDepartment::inst($this->db, $this, $dp)->add()) {
					return false;
				}
			}
		
		});
		
		
		if (!$added) {
			return DB::getError(DB::INSERT_ERR);
		}
		
		return array("success"=> $this->get_id());
	}
	
	
	public function add_departments ($departments) {
		
		if (empty($departments)) {
			return array("departments_error"=> 1);
		}
		
		foreach ($departments as $dept) {
			if (empty(trim($dept['name']))) {
				return array("departments_error"=> 2);
			}
		}
		
		$added = $this->db->useTransaction(function () use ($departments) {
			
			foreach ($departments as $dept) {
				
				$dp = new Department($this->db, $dept['name'], $dept['acronym']);
				
				if (!$dp->get_id()) {
					if (!$dp->add()) {
						return false;
					}
				}
				
				$ud = new UniversityDepartment($this->db, $this, $dp);
				
				if (!$ud->get_id()) {
					if (!$ud->add()) {
						return false;
					}
				}
			}
		
		});
		
		if (!$added) {
			return DB::getError(DB::INSERT_ERR);
		}
		
		return array("success"=> 1);
	}
	
	
	public function remove_departments ($departments) {
		
		if (empty($departments)) {
			return array("departments_error"=> 1);
		}
		
		$removed = $this->db->useTransaction(function ($params) use ($departments) {
			
			foreach ($departments as $dept) {
				
				$dp = new Department($this->db, $dept);
				
				if ($dp->get_id()) {
					$ud = new UniversityDepartment($this->db, $this, $dp);
					
					if ($ud->get_id()) {
						if (!$ud->remove()) {
							return false;
						}
					}
				}
			}
		
		});
		
		if (!$removed) {
			return DB::getError(DB::DELETE_ERR);
		}
		
		return array("success"=> 1);
	} 
	
	
	public function get_data () {
		
		return $this->db->selectRowWhere(
			self::DB, 
			array("name", "acronym", "address", "description"), 
			array("id = ?", $this->get_id()),
			array()
		);
	}
	
	
	public function get_projects ($page_start, $page_limit) {
		
		return $this->db->select(
			Project::DB." AS a", 
			Project::DB_LIST_COLUMNS, 
			array(
				DB::SELECT_JOIN=> Project::DB_LIST_JOIN, 
				DB::SELECT_WHERE=> array(
					"a.privacy = ? AND a.university_id = ?", 
					array(1, $this->get_id())
				), 
				DB::SELECT_GROUP_BY=> array("a.id"),
				DB::SELECT_ORDER_BY=> array("a.creation_date DESC"),
				DB::SELECT_LIMIT=> array($page_start, $page_limit)
			),
			array()
		);
		
	}
	
	
	public function get_projects_count () {
		
		return $this->db->selectColumnWhere(
			Project::DB, 
			"COUNT(id)", 
			array(
				"privacy = ? AND university_id = ?", 
				array(1, $this->get_id())
			), 
			0
		);
		
	}
	
	
	public function get_departments ($page_start, $page_limit) {
		
		return $this->db->select(
			UniversityDepartment::DB." AS a", 
			array(
				"a.id",
				"a.department_id",
				"b.name",
				"b.acronym",
			), 
			array(
				DB::SELECT_JOIN=> "JOIN ".Department::DB." AS b ON a.department_id = b.id",
				DB::SELECT_WHERE=> array("a.university_id = ?", $this->get_id()), 
				DB::SELECT_ORDER_BY=> array("a.add_date DESC"),
				DB::SELECT_LIMIT=> array($page_start, $page_limit)
			),
			array()
		);
		
	}
	
	public function get_departments_count () {
		
		return $this->db->selectColumnWhere(
			UniversityDepartment::DB, 
			"COUNT(id)",
			array("university_id = ?", $this->get_id()), 
			0
		);
		
	}
	
	
	public static function get_list ($db, $page_start, $page_limit) {
		
		return $db->select(
			University::DB, 
			array(
				"id",
				"name",
				"acronym",
			), 
			array(
				DB::SELECT_ORDER_BY=> array("name"),
				DB::SELECT_LIMIT=> array($page_start, $page_limit)
			),
			array()
		);
	}
	
	public static function get_list_count ($db) {
		
		return $db->selectColumn(University::DB, "COUNT(id)", array(), 0);
	}
	
	
}

