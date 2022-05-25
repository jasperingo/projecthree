<?php

class Project {
	
	
	const DB = "project";
	
	const DB_LIST_JOIN = "JOIN ".University::DB." AS b ON a.university_id = b.id ".
		"JOIN ".Department::DB." AS c ON a.department_id = c.id ".
		"JOIN ".User::DB." AS d ON a.supervisor_id = d.id ".
		"JOIN ".User::DB." AS e ON a.student_id = e.id ".
		"LEFT JOIN ".Review::DB." AS f ON a.id = f.project_id";
	
	const DB_LIST_COLUMNS = array(
		"a.id",
		"a.university_id", 
		"a.department_id", 
		"a.supervisor_id",
		"a.student_id",
		"a.topic", 
		"b.name AS university_name", 
		"c.name AS department_name",
		"TRIM(CONCAT(d.title, \" \", d.first_name, \" \", d.last_name)) AS supervisor_name",
		"d.photo_name AS supervisor_photo_name",
		"TRIM(CONCAT(e.title, \" \", e.first_name, \" \", e.last_name)) AS student_name",
		"e.photo_name AS student_photo_name",
		"IFNULL(ROUND(AVG(f.star), 1), 0) AS rating"
	);
	
	const TOPIC_MIN_LIMIT = 10;
	
	const TOPIC_MAX_LIMIT = 200;
	
	const DESCRIPTION_MIN_LIMIT = 100;
	
	const DESCRIPTION_MAX_LIMIT = 2000;
	
	
	private $db=null;
	
	private $id=0;
	
	private $university;
	
	private $department;
	
	private $supervisor;
	
	private $student;
	
	private $topic;
	
	private $description;
	
	private $privacy;
	
	
	public function __construct ($db, $pid=0) {
		$this->db = $db;
		$this->set_id($pid);
	}
	
	
	public function set_id ($pid) {
		$this->id = (int)$pid;
	}
	
	public function set_university ($u) {
		if (is_string($u)) {
			$this->university = new University($this->db, $u);
		} else {
			$this->university = $u;
		}
	}
	
	public function set_department ($d) {
		if (is_string($d)) {
			$this->department = new Department($this->db, $d);
		} else {
			$this->department = $d;
		}
	}
	
	public function set_topic ($t) {
		$this->topic = trim($t);
	}
	
	public function set_description ($desc) {
		$this->description = trim($desc);
	}
	
	public function set_supervisor ($s) {
		if (is_int($s)) {
			$this->supervisor = new User($this->db, $s);
		} else {
			$this->supervisor = $s;
		}
	}
	
	public function set_student ($s) {
		if (is_string($s)) {
			$this->student = new User($this->db);
			$this->student->set_email($s);
		} elseif (is_int($s)) {
			$this->student = new User($this->db, $s);
		} else {
			$this->student = $s;
		}
	}
	
	public function set_privacy ($p) {
		$this->privacy = $p;
	}
	
	
	public function get_id () {
		return $this->id;
	}
	
	public function get_university () {
		return $this->university;
	}
	
	public function get_department () {
		return $this->department;
	}
	
	public function get_topic () {
		if ($this->topic === null) {
			$this->set_topic($this->get_db_data("topic", ""));
		}
		
		return $this->topic;
	}
	
	public function get_description () {
		return $this->description;
	}
	
	public function get_supervisor () {
		if ($this->supervisor === null) {
			$this->set_supervisor($this->get_db_data("supervisor_id", 0));
		}
		
		return $this->supervisor;
	}
	
	public function get_student () {
		if ($this->student === null) {
			$this->set_student($this->get_db_data("student_id", 0));
		}
		
		return $this->student;
	}
	
	public function get_privacy () {
		if ($this->privacy === null) {
			$this->set_privacy($this->get_db_data("privacy", 0));
		}
		
		return $this->privacy;
	}
	
	
	private function get_db_data ($column, $d=false) {
		return $this->db->selectColumnWhere(self::DB, $column, array("id = ?", $this->get_id()), $d);
	}
	
	public function is_supervisor ($user) {
		return $user->get_id() == $this->get_supervisor()->get_id();
	}
	
	public function is_student ($user) {
		return $user->get_id() == $this->get_student()->get_id();
	}
	
	public function is_participant ($user) {
		return $this->is_student($user) || $this->is_supervisor($user);
	}
	
	public function exists () {
		return !empty($this->get_topic());
	}
	
	
	public function create () {
		
		$input_errors = array();
		
		$topic_check = Valid::string($this->get_topic(), self::TOPIC_MAX_LIMIT, self::TOPIC_MIN_LIMIT);
		
		if ($topic_check != 0) {
			$input_errors['topic_error'] = $topic_check;
		}
		
		if ($this->get_university()->get_id() == 0) {
			$input_errors['university_name_error'] = 1;
		}
		
		if ($this->get_department()->get_id() == 0) {
			$input_errors['department_name_error'] = 1;
		}
		
		if (!isset($input_errors['university_name_error']) && !isset($input_errors['department_name_error'])) {
			if (UniversityDepartment::inst($this->db, $this->get_university(), $this->get_department())->get_id() == 0) {
				$input_errors['university_department_error'] = 1;
			}
		}
		
		if ($this->get_student()->get_id() == 0) {
			$input_errors['student_email_error'] = 1;
		}
		
		if (!isset($input_errors['student_email'])) {
			if ($this->get_student()->get_id() == $this->get_supervisor()->get_id()) {
				$input_errors['student_email_error'] = 2;
			}
		}
		
		if (!empty($input_errors)) { 
			return array("input_errors"=>$input_errors); 
		}
		
		$added = $this->db->useTransaction(function () {
			
			if (!$this->db->insert(self::DB, array(
				"supervisor_id"=> $this->get_supervisor()->get_id(), 
				"student_id"=> $this->get_student()->get_id(), 
				"university_id"=> $this->get_university()->get_id(), 
				"department_id"=> $this->get_department()->get_id(), 
				"topic"=> $this->get_topic()
			))) {
				return false;
			}
			
			$this->set_id($this->db->lastInsertId());
			
			$msg = new Message($this->db);
			$msg->set_project($this);
			$msg->set_sender($this->get_supervisor());
			$msg->set_automated(Message::AUTO_NEW_PROJECT);
			
			if (!isset($msg->send()['success'])) {
				return false;
			}
		});
		
		if (!$added) {
			return DB::getError(DB::INSERT_ERR);
		}
		
		return array("success"=> $this->get_id());
	}
	
	
	public function update ($topic, $privacy, $description) : array {
		
		$input_errors = array();
		
		$topic_check = Valid::string($topic, self::TOPIC_MAX_LIMIT, self::TOPIC_MIN_LIMIT);
		
		if ($topic_check != 0) {
			$input_errors['topic_error'] = $topic_check;
		}
		
		$desc_check = Valid::string($description, self::DESCRIPTION_MAX_LIMIT, self::DESCRIPTION_MIN_LIMIT);
		
		if ($desc_check != 0) {
			$input_errors['description_error'] = $desc_check;
		}
		
		if (!in_array($privacy, array(0,1))) {
			$input_errors['privacy_error'] = 1;
		}
		
		if (!empty($input_errors)) { 
			return array("input_errors"=> $input_errors); 
		}
		
		$updated = $this->db->useTransaction(function () use ($topic, $description, $privacy) {
			
			$columns = array(
				"topic"=> $topic,
				"description"=> $description, 
				"privacy"=> $privacy
			);
			
			$query = $this->db->getUpdateQuery(self::DB, array_keys($columns), array("id = ?"));
			
			try {
				$stmt = $this->db->prepare($query);
				
				if (!$stmt->execute(array_merge(array_values($columns), [$this->get_id()]))) {
					return false;
				}
				
			} catch (PDOException $e) {
				return false;
			}
			
			$msg = new Message($this->db);
			$msg->set_project($this);
			$msg->set_sender($this->get_supervisor());
			$msg->set_automated(Message::AUTO_PROJECT_EDIT);
			
			if (!isset($msg->send()['success'])) {
				return false;
			}
		});
		
		if (!$updated) {
			return DB::getError(DB::UPDATE_ERR);
		}
		
		return array("success"=> 1);
	}
	
	
	public function get_approved_document_id () {
		
		return $this->db->selectColumnWhere(ProjectDocument::DB, "id", array(
			"approved = ? AND project_id = ?", 
			array(1, $this->get_id())
		), 0);
	}
	
	public function disapprove_document () {
		
		$id = $this->get_approved_document_id();
		
		if (!$id) {
			return true;
		}
		
		return $this->db->update(ProjectDocument::DB, array("approved"=> 0), array("id = ?", $id));
	}
	
	
	public function update_messages_seen ($user_id) {
		
		if (!$this->db->update(Message::DB, array("seen"=> 1), array(
			"project_id = ? AND NOT sender_id = ?", 
			array($this->get_id(), $user_id)
		))) {
			return DB::getError(DB::UPDATE_ERR);
		}
		
		return array("success"=> 1);
	}
	
	
	public function get_data () {
		
		$data = $this->db->selectRow(
			self::DB." AS a", 
			array_merge(self::DB_LIST_COLUMNS, array("a.description", "a.privacy", "a.creation_date")), 
			array(
				DB::SELECT_JOIN=> self::DB_LIST_JOIN, 
				DB::SELECT_WHERE=> array("a.id = ?", $this->get_id())
			),
			array()
		);
		
		$data['document_id'] = $this->get_approved_document_id();
		
		return $data;
	}
	
	public function get_edit_data () {
		
		return $this->db->selectRowWhere(
			self::DB, 
			array(
				"topic",
				"description",
				"privacy",
			), 
			array("id = ?", $this->get_id()),
			array()
		);
		
	}
	
	public function get_participants () {
		
		return $this->db->selectRowWhere(
			self::DB, 
			array(
				"supervisor_id",
				"student_id",
			), 
			array("id = ?", $this->get_id()),
			array()
		);
		
	}
	
	
	public function get_messages ($page_start, $page_limit) {
		
		return $this->db->select(
			Message::DB." AS a", 
			array(
				"a.id",
				"a.sender_id",
				"a.automated",
				"a.seen",
				"a.content",
				"a.date",
				"b.photo_name AS sender_photo_name",
				"TRIM(CONCAT(b.title, \" \", b.first_name, \" \", b.last_name)) AS sender_name",
			), 
			array(
				DB::SELECT_JOIN=> "JOIN ".User::DB." AS b ON a.sender_id = b.id", 
				DB::SELECT_WHERE=> array("project_id = ?", $this->get_id()), 
				DB::SELECT_ORDER_BY=> array("a.date DESC"),
				DB::SELECT_LIMIT=> array($page_start, $page_limit)
			),
			array()
		);
		
	}
	
	public function get_messages_count () {
		
		return $this->db->selectColumnWhere(Message::DB, "COUNT(id)", array(
			"project_id = ?", 
			$this->get_id()
		), 0);
	}
	
	
	public function get_reviews ($page_start, $page_limit) {
		
		return $this->db->select(
			Review::DB." AS a", 
			array(
				"a.id",
				"a.sender_id",
				"a.star",
				"a.content",
				"a.date",
				"b.photo_name AS sender_photo_name",
				"TRIM(CONCAT(b.title, \" \", b.first_name, \" \", b.last_name)) AS sender_name",
			), 
			array(
				DB::SELECT_JOIN=> "JOIN ".User::DB." AS b ON a.sender_id = b.id", 
				DB::SELECT_WHERE=> array("project_id = ?", $this->get_id()), 
				DB::SELECT_ORDER_BY=> array("a.date DESC"),
				DB::SELECT_LIMIT=> array($page_start, $page_limit)
			),
			array()
		);
		
	}
	
	public function get_reviews_count () {
		
		return $this->db->selectColumnWhere(Review::DB, "COUNT(id)", array(
			"project_id = ?", 
			$this->get_id()
		), 0);
	}
	
	
	public function get_documents ($page_start, $page_limit) {
		
		return $this->db->select(
			ProjectDocument::DB, 
			array(
				"id",
				"name",
				"approved",
				"upload_date",
			), 
			array(
				DB::SELECT_WHERE=> array("project_id = ?", $this->get_id()), 
				DB::SELECT_ORDER_BY=> array("upload_date DESC"),
				DB::SELECT_LIMIT=> array($page_start, $page_limit)
			),
			array()
		);
		
	}
	
	public function get_documents_count () {
		
		return $this->db->selectColumnWhere(
			ProjectDocument::DB, 
			"COUNT(id)",
			array("project_id = ?", $this->get_id()), 
			0
		);
		
	}
	
	
	public static function get_random_projects ($db, $page_start, $page_limit) {
		
		return $db->select(
			Project::DB." AS a", 
			Project::DB_LIST_COLUMNS, 
			array(
				DB::SELECT_JOIN=> Project::DB_LIST_JOIN, 
				DB::SELECT_WHERE=> array("a.privacy = ?", 1), 
				DB::SELECT_GROUP_BY=> array("a.id"),
				DB::SELECT_ORDER_BY=> array("RAND()"),
				DB::SELECT_LIMIT=> array($page_start, $page_limit)
			),
			array()
		);
	}
	
	
	public static function get_search ($db, $q, $page_start, $page_limit) {
		
		return $db->select(Project::DB." AS a", Project::DB_LIST_COLUMNS, array(
				DB::SELECT_JOIN=> Project::DB_LIST_JOIN, 
				DB::SELECT_WHERE=> array("a.topic LIKE ? AND a.privacy = ?", array("%".$q."%", 1)), 
				DB::SELECT_GROUP_BY=> array("a.id"),
				DB::SELECT_LIMIT=> array($page_start, $page_limit)
		), array());
	}
	
	
	public static function get_search_count ($db, $q) {
		
		return $db->selectColumnWhere(Project::DB, "COUNT(id)", array(
			"topic LIKE ? AND privacy = ?", 
			array("%".$q."%", 1)
		), 0);
	}
	
	
	
}