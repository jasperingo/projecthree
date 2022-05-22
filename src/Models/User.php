<?php

use ApexPHP\Httpx, ApexPHP\Valid, ApexPHP\Cryptograph, ApexPHP\Filex, ApexPHP\ApexDB as DB;


class User {
	
	
	const DB = "user";
	
	const DB_SIGN_IN = "user_sign_in";
	
	const TITLES = array("Doctor", "Engineer", "Professor");
	
	const BIO_MIN_LIMIT = 50;
	
	const BIO_MAX_LIMIT = 200;
	
	const PASSWORD_MIN_LIMIT = 6;
	
	const PASSWORD_MAX_LIMIT = 15;
	
	const PHOTO_NAME_DEFAULT = "user.jpg";
	
	
	private $db=null;
	
	private $id=0;
	
	private $title;
	
	private $first_name;
	
	private $last_name;
	
	private $email;
	
	private $password;
	
	private $photo_name;
	
	
	public function __construct ($db, $id=0) {
		$this->db = $db;
		$this->set_id($id);
	}
	
	
	public function set_id ($user_id) {
		$this->id = (int)$user_id;
	}
	
	public function set_title ($lect_title) {
		$this->title = trim($lect_title);
	}
	
	public function set_first_name ($user_fname) {
		$this->first_name = trim($user_fname);
	}
	
	public function set_last_name ($user_lname) {
		$this->last_name = trim($user_lname);
	}
	
	public function set_email ($user_email) {
		$this->email = strtolower(trim($user_email));
	}
	
	public function set_password ($user_pwd) {
		$this->password = $user_pwd;
	}
	
	public function set_photo_name ($user_photo) {
		$this->photo_name = $user_photo;
	}
	
	
	public function get_id () {
		if ($this->id === 0) {
			$this->set_id($this->get_db_id($this->get_email()));
		}
		
		return $this->id;
	}
	
	public function get_title () {
		return $this->title;
	}
	
	public function get_first_name () {
		return $this->first_name;
	}
	
	public function get_last_name () {
		return $this->last_name;
	}
	
	public function get_email () {
		if ($this->email === null) {
			$this->set_email($this->get_db_data("email"));
		}
		
		return $this->email;
	}
	
	public function get_password () {
		if ($this->password === null) {
			$this->set_password($this->get_db_data("password"));
		}
		
		return $this->password;
	}
	
	public function get_photo_name () {
		if ($this->photo_name === null) {
			$this->set_photo_name($this->get_db_data("photo_name"));
		}
		
		return $this->photo_name;
	}
	
	
	public static function is_authorizable () {
		if (isset($_SERVER['HTTP_X_AUTHORIZATION'])) {
			return true;
		}
		
		return false;
	}
	
	public function get_authorization_code () {
		return Cryptograph::encrypt(array("id" => $this->get_id()), USER_AUTH_KEY);
	}
	
	public function authorize () {
		
		if (!self::is_authorizable()) {
			Httpx::sendUnauthorized(null, "Authorization header not sent");
		}
		
		$arr = explode(" ", $_SERVER['HTTP_X_AUTHORIZATION']);
		
		if(!isset($arr[1])){ 
			Httpx::sendUnauthorized(null, "Invalid authorization header format");
		}
		
		$decoded = Cryptograph::decrypt($arr[1], USER_AUTH_KEY);
		
		if (empty($decoded)) { 
			Httpx::sendUnauthorized(null, "Invalid token sent");
		}
		
		$expired = $this->db->selectColumnWhere(self::DB_SIGN_IN, "expired", array(
			"user_id = ? AND code = ?", 
			array($decoded['id'], $arr[1])
		));
		
		if ($expired) {
			Httpx::sendUnauthorized(null, "Expired token sent");
		}
		
		$this->set_id($decoded['id']);
	}
	
	
	
	private function get_db_data ($column) {
		return $this->db->selectColumnWhere(self::DB, $column, array("id = ?", $this->get_id()));
	}
	
	private function get_db_id ($email) {
		return $this->db->selectColumnWhere(self::DB, "id", array("email = ?", $email), 0);
	}
	
	public function email_exists ($email) {
		return $this->get_db_id($email);
	}
	
	private function password_is_correct ($password) {
		return password_verify($password, $this->get_password());
	}
	
	
	public function sign_up () {
		
		$input_errors = array();
		
		if (!empty($this->get_title()) && !in_array($this->get_title(), self::TITLES)) {
			$input_errors['title_error'] = 1;
		}
		
		if (empty($this->get_first_name())) {
			$input_errors['first_name_error'] = 1;
		}
		
		if (empty($this->get_last_name())) {
			$input_errors['last_name_error'] = 1;
		}
		
		$email_check = Valid::email($this->get_email(), $this->email_exists($this->get_email()));
		
		if ($email_check != 0) { 
			$input_errors['email_error'] = $email_check;
		}
		
		$pwd_check = Valid::string($this->get_password(), self::PASSWORD_MAX_LIMIT, self::PASSWORD_MIN_LIMIT);
		
		if ($pwd_check != 0) {
			$input_errors['password_error'] = $pwd_check;
		}
		
		if (!empty($input_errors)) { 
			return array("input_errors"=> $input_errors); 
		}
		
		$this->set_password(password_hash($this->get_password(), PASSWORD_DEFAULT));
		
		
		$result = $this->db->insert(self::DB, array(
			"title"=> $this->get_title(), 
			"first_name"=> $this->get_first_name(), 
			"last_name"=> $this->get_last_name(), 
			"email"=> $this->get_email(), 
			"password"=> $this->get_password(), 
			"photo_name"=> self::PHOTO_NAME_DEFAULT, 
		));
		
		if (!$result) { 
			return $this->db::getError($this->db::INSERT_ERR); 
		}
		
		
		$this->set_id($this->db->lastInsertId());
		
		$code = $this->add_sign_in();
		
		
		return array("success"=> array(
			"id"=> $this->get_id(), 
			"token"=> $code
		));
	}
	
	
	public function sign_in ($email, $password) {
		
		$email_check = Valid::email($email, $this->email_exists($email));
		
		if ($email_check != 3) { 
			return array("email_error"=> $email_check);
		}
		
		$this->set_email($email);
		
		$pwd_check = Valid::string($password, self::PASSWORD_MAX_LIMIT, self::PASSWORD_MIN_LIMIT, $this->password_is_correct($password));
		
		if ($pwd_check != 4) {
			return array("password_error"=> $pwd_check);
		}
		
		
		$code = $this->add_sign_in();
		
		if ($code == "") {
			return $this->db::getError($this->db::INSERT_ERR);
		}
		
		
		return array("success"=> array(
			"id"=> $this->get_id(), 
			"token"=> $code
		));
	}
	
	
	private function add_sign_in () {
		
		$code = $this->get_authorization_code();
		
		$result = $this->db->insert(self::DB_SIGN_IN, array(
			"user_id"=> $this->get_id(),
			"code"=> $code, 
		));
		
		if (!$result) {
			$code = "";
		}
		
		return $code;
	}
	
	
	public function sign_out () {
		
		$code = explode(" ", $_SERVER['HTTP_X_AUTHORIZATION'])[1];
		
		$result = $this->db->update(self::DB_SIGN_IN, array("expired"=> 1), array(
			"user_id = ? AND code = ?", 
			array($this->get_id(), $code)
		));
		
		if (!$result) {
			return $this->db::getError($this->db::UPDATE_ERR);
		}
		
		return array("success"=> 1);
	}
	
	
	public function update_email ($email) {
		
		$email_check = Valid::email($email, $this->email_exists($email));
		
		if ($email_check != 0) { 
			return array("email_error"=> $email_check);
		}
		
		$query = $this->db->getUpdateQuery(self::DB, array("email"), array("id = ?"));
		
		try {
			$stmt = $this->db->prepare($query);
			
			$result = $stmt->execute([$email, $this->get_id()]);
			
		} catch (PDOException $e) {
			$result = false;
		}
		
		if (!$result) {
			return $this->db::getError($this->db::UPDATE_ERR);
		}
		
		
		return array("success"=> 1);
	}
	
	
	public function update_profile ($data) {
		
		$input_errors = array();
		
		if (!empty($data['title']) && !in_array($data['title'], self::TITLES)) {
			$input_errors['title_error'] = 1;
		}
		
		if (empty(trim($data['first_name']))) {
			$input_errors['first_name_error'] = 1;
		}
		
		if (empty(trim($data['last_name']))) {
			$input_errors['last_name_error'] = 1;
		}
		
		if (!empty(trim($data['bio']))) {
			$bio_check = Valid::string(trim($data['bio']), self::BIO_MAX_LIMIT, self::BIO_MIN_LIMIT);
			
			if ($bio_check != 0) { 
				$input_errors['bio_error'] = $bio_check;
			}
		}
		
		if (!empty($input_errors)) { 
			return array("input_errors"=> $input_errors); 
		}
		
		
		$columns = array(
			"title"=> $data['title'],
			"first_name"=> $data['first_name'],
			"last_name"=> $data['last_name'],
			"bio"=> $data['bio']
		);
		
		$query = $this->db->getUpdateQuery(self::DB, array_keys($columns), array("id = ?"));
		
		try {
			$stmt = $this->db->prepare($query);
			
			$result = $stmt->execute(array_merge(array_values($columns), [$this->get_id()]));
			
		} catch (PDOException $e) {
			$result = false;
		}
		
		if (!$result) { 
			return $this->db::getError($this->db::UPDATE_ERR); 
		}
		
		return array("success"=> 1);
	}
	
	
	public function update_photo ($photo, $dir) {
		
		$photo_name = "user".$this->get_id().".jpg";
		
		$uploaded = Filex::upload($photo, $dir.$photo_name, array(
			Filex::VALID_EXTENSION=> Filex::IMAGE_EXTS, 
			Filex::VALID_TYPE=> Filex::IMAGE_TYPE
		));
		
		if ($uploaded != 0) {
			return array("photo_error"=> $uploaded);
		}
		
		$query = $this->db->getUpdateQuery(self::DB, array("photo_name"), array("id = ?"));
		
		try {
			$stmt = $this->db->prepare($query);
			
			$result = $stmt->execute([$photo_name, $this->get_id()]);
			
		} catch (PDOException $e) {
			$result = false;
		}
		
		if (!$result) {
			return $this->db::getError($this->db::UPDATE_ERR);
		}
		
		return array("success"=> 1);
	}
	
	
	public function update_password ($password, $new_password) {
		
		$pwd_check = Valid::string($password, self::PASSWORD_MAX_LIMIT, self::PASSWORD_MIN_LIMIT, $this->password_is_correct($password));
		
		if ($pwd_check != 4) {
			return array("password_error"=> $pwd_check);
		}
		
		$pwd_check2 = Valid::string($new_password, self::PASSWORD_MAX_LIMIT, self::PASSWORD_MIN_LIMIT);
		
		if ($pwd_check2 != 0) {
			return array("new_password_error"=> $pwd_check2);
		}
		
		if (!$this->update_db_password($new_password)) { 
			return $this->db::getError($this->db::UPDATE_ERR); 
		}
		
		return array("success"=> 1);
	}
	
	public function update_db_password ($password) {
		return $this->db->update(
			self::DB, 
			array("password"=> password_hash($password, PASSWORD_DEFAULT)), 
			array("id = ?", $this->get_id())
		);
	}
	
	
	public function get_data () {
		
		return $this->db->selectRowWhere(
			self::DB, 
			array("title", "first_name", "last_name", "photo_name", "bio"), 
			array("id = ?", $this->get_id()),
			array()
		);
		
	}
	
	
	public function get_projects ($viewer_id, $page_start, $page_limit) {
		
		if ($viewer_id == $this->get_id()) {
			$where = array("a.supervisor_id = ? OR a.student_id = ?", array($this->get_id(), $this->get_id()));
		} else {
			$where = array(
				"a.privacy = ? AND (a.supervisor_id = ? OR a.student_id = ?)", 
				array(1, $this->get_id(), $this->get_id())
			);
		}
		
		return $this->db->select(Project::DB." AS a", Project::DB_LIST_COLUMNS, array(
				DB::SELECT_JOIN=> Project::DB_LIST_JOIN, 
				DB::SELECT_WHERE=> $where, 
				DB::SELECT_GROUP_BY=> array("a.id"),
				DB::SELECT_ORDER_BY=> array("a.creation_date DESC"),
				DB::SELECT_LIMIT=> array($page_start, $page_limit)
		), array());
	}
	
	
	public function get_projects_count ($viewer_id) {
		
		if ($viewer_id == $this->get_id()) {
			$where = array("a.supervisor_id = ? OR a.student_id = ?", array($this->get_id(), $this->get_id()));
		} else {
			$where = array(
				"a.privacy = ? AND (a.supervisor_id = ? OR a.student_id = ?)", 
				array(1, $this->get_id(), $this->get_id())
			);
		}
		
		return $this->db->selectColumn(Project::DB." AS a", "COUNT(a.id)", array(DB::SELECT_WHERE=> $where), 0);
	}
	
	
	public function get_notifications ($page_start, $page_limit) {
		
		return $this->db->select(
			Project::DB." AS a", 
			array(
				"a.id",
				"a.topic",
				"COUNT(b.id) AS count"
			), 
			array(
				DB::SELECT_JOIN=> "JOIN ".Message::DB." AS b ON a.id = b.project_id", 
				DB::SELECT_WHERE=> array(
					"(a.supervisor_id = ? OR a.student_id = ?) AND NOT b.sender_id = ? AND b.seen = ?", 
					array($this->get_id(), $this->get_id(), $this->get_id(), 0)
				),
				DB::SELECT_GROUP_BY=> array("a.id"),
				DB::SELECT_ORDER_BY=> array("b.date DESC"),
				DB::SELECT_LIMIT=> array($page_start, $page_limit)
			),
			array()
		);
		
	}
	
	public function get_notifications_count () {
		
		return count($this->db->selectColumns(Project::DB." AS a", "a.id", array(
				DB::SELECT_JOIN=> "JOIN ".Message::DB." AS b ON a.id = b.project_id", 
				DB::SELECT_WHERE=> array(
					"(a.supervisor_id = ? OR a.student_id = ?) AND NOT b.sender_id = ? AND b.seen = ?", 
					array($this->get_id(), $this->get_id(), $this->get_id(), 0)
				),
				DB::SELECT_GROUP_BY=> array("a.id")
		), []));
	}
	
	
	
	
}