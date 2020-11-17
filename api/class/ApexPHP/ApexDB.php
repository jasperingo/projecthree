<?php

namespace ApexPHP;


class ApexDB extends \PDO {
	
	
	const RESULT_BOOL = 0;
	const RESULT_ROWS = 1;
	const RESULT_ROW = 2;
	const RESULT_COLUMNS = 3;
	const RESULT_COLUMN = 4;
	
	
	const SELECT_JOIN = "JOIN";
	const SELECT_WHERE = "WHERE";
	const SELECT_GROUP_BY = "GROUP BY";
	const SELECT_HAVING = "HAVING";
	const SELECT_ORDER_BY = "ORDER BY";
	const SELECT_LIMIT = "LIMIT";
	
	
	const ERR_KEY = "database_error";
	const CONNECT_ERR = "An error occurred while connecting to the database";
	const CREATE_TABLE_ERR = "An error occurred while creating a table in the database";
	const INSERT_ERR = "An error occurred while inserting data into a table in the database";
	const UPDATE_ERR = "An error occurred while updating data in a table in the database";
	const DELETE_ERR = "An error occurred while deleting data in a table in the database";
	const SELECT_ERR = "An error occurred while selecting data from a table in the database";
	
	
	
	public static function getNew () {
		
		try {
			
			$options = array(
				\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
				\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
				\PDO::ATTR_EMULATE_PREPARES => false,
			);
			
			$db = new self(DB_DSN, DB_USERNAME, DB_PASSWORD, $options);
			
			return $db;
			
		} catch (\PDOException $e) {
			
			return null;
		}
	}
	
	
	public static function getError ($msg="") : array {
		return array(self::ERR_KEY=> $msg);
	}
	
	
	private function getWhere ($where) {
		
		if (!isset($where[0])) {
			return "";
		}
		
		return " WHERE ".$where[0];
	}
	
	private function getWhereArgs ($where) {
		
		if (!isset($where[1])) {
			return array();
		} elseif (!is_array($where[1])) {
			$where[1] = array($where[1]);
		}
		
		return $where[1];
	}
	
	public static function getArrayHolders ($w) {
		return implode(", ", array_fill(0, count($w), '?'));
	}
	
	
	private function getLimit ($limit) {
		
		if (!empty($limit)) {
			return " LIMIT ".(count($limit) == 2 ? "?, ?" : "?");
		}
		
		return "";
	}
	
	
	public function executeQuery ($query, $values, $returnType=0) {
		
		try {
			$stmt = $this->prepare($query);
		} catch (\PDOException $e) {
			return false;
		}
		
		if ($stmt->execute($values)) {
			
			switch ($returnType) {
				case 1 :
					return $stmt->fetchAll();
				case 2 :
					return $stmt->fetch();
				case 3 :
					return $stmt->fetchAll(\PDO::FETCH_COLUMN);
				case 4 :
					return $stmt->fetchColumn();
				default :
					return $stmt->rowCount() > 0 ? true : false;
			}
		}
		
		return false;
	}
	
	
	public function getInsertQuery ($table, $data) {
		
		$firstValue = array_values($data)[0];
		
		if (is_array($firstValue)) {
			
			$values = "";
			$len = count($firstValue);
			
			for ($i=0;$i<$len;$i++) {
				$values .= "(".self::getArrayHolders(array_keys($data)).")";
				if ($i != $len-1) {
					$values .= ", ";
				}
			}
			
		} else {
			
			$values = "(".self::getArrayHolders($data).") ";
		}
		
		return "INSERT INTO ".$table." (".implode(", ", array_keys($data)).") VALUES ".$values;
	}
	
	public function insert ($table, $data) {
		
		$firstValue = array_values($data)[0];
		
		if (is_array($firstValue)) {
			
			$values = array();
			$len = count($firstValue);
			$keys = array_keys($data);
			
			for ($i=0;$i<$len;$i++) {
				for ($j=0;$j<count($keys);$j++) {
					array_push($values, $data[$keys[$j]][$i]);
				}
			}
			
		} else {
			
			$values = array_values($data);
		}
		
		return $this->executeQuery($this->getInsertQuery($table, $data), $values);
	}
	
	public function getUpdateQuery ($table, $data, $where=array(), $limit=array()) {
		$keys = array_map(function ($i) { return $i." = ?"; }, $data);
		return "UPDATE ".$table." SET ".implode(", ", $keys).$this->getWhere($where).$this->getLimit($limit);
	}
	
	public function update ($table, $data, $where=array(), $limit=array()) {
		return $this->executeQuery($this->getUpdateQuery($table, array_keys($data), $where, $limit), array_merge(array_values($data), $this->getWhereArgs($where), $limit));
	}
	
	public function getDeleteQuery ($table, $where=array(), $limit=array()) {
		return "DELETE FROM ".$table.$this->getWhere($where).$this->getLimit($limit);
	}
	
	public function delete ($table, $where=array(), $limit=array()) {
		return $this->executeQuery($this->getDeleteQuery($table, $where, $limit), array_merge($this->getWhereArgs($where), $limit));
	}
	
	
	public function getSelectQuery ($table, $data, $options=array()) {
		
		$query = "SELECT ".implode(", ", $data)." FROM ".$table;
		
		if (isset($options[self::SELECT_JOIN])) {
			$query .= " ".$options[self::SELECT_JOIN];
		}
		
		if (isset($options[self::SELECT_WHERE])) {
			$query .= $this->getWhere($options[self::SELECT_WHERE]);
		}
		
		if (isset($options[self::SELECT_GROUP_BY])) {
			$query .= " GROUP BY ".implode(", ", $options[self::SELECT_GROUP_BY]);
		}
		
		if (isset($options[self::SELECT_HAVING])) {
			$query .= str_replace("WHERE", "HAVING", $this->getWhere($options[self::SELECT_HAVING]));
		}
		
		if (isset($options[self::SELECT_ORDER_BY])) {
			$query .= " ORDER BY ".implode(", ", $options[self::SELECT_ORDER_BY]);
		}
		
		if (isset($options[self::SELECT_LIMIT])) {
			$query .= $this->getLimit($options[self::SELECT_LIMIT]);
		}
		
		return $query;
	}
	
	public function select ($table, $data, $options=array(), $default=false, $returnType=1) {
		
		$values = array();
		
		if (isset($options[self::SELECT_WHERE])) {
			$values = array_merge($values, $this->getWhereArgs($options[self::SELECT_WHERE]));
		}
		
		if (isset($options[self::SELECT_HAVING])) {
			$values = array_merge($values, $this->getWhereArgs($options[self::SELECT_HAVING]));
		}
		
		if (isset($options[self::SELECT_LIMIT])) {
			$values = array_merge($values, $options[self::SELECT_LIMIT]);
		}
		
		$result = $this->executeQuery($this->getSelectQuery($table, $data, $options), $values, $returnType);
		
		return $result === false ? $default : $result;
	}
	
	
	public function selectRow ($table, $data, $options=array(), $default=false) {
		return $this->select($table, $data, $options, $default, 2);
	}
	
	
	public function selectColumns ($table, $data, $options=array(), $default=false) {
		return $this->select($table, array($data), $options, $default, 3);
	}
	
	public function selectColumn ($table, $data, $options=array(), $default=false) {
		return $this->select($table, array($data), $options, $default, 4);
	}
	
	
	public function selectWhere ($table, $data, $where, $default=false, $returnType=1) {
		return $this->select($table, $data, array(self::SELECT_WHERE=> $where), $default, $returnType);
	}
	
	public function selectRowWhere ($table, $data, $where, $default=false) {
		return $this->selectWhere($table, $data, $where, $default, 2);
	}
	
	public function selectColumnsWhere ($table, $data, $where, $default=false) {
		return $this->selectWhere($table, array($data), $where, $default, 3);
	}
	
	public function selectColumnWhere ($table, $data, $where, $default=false) {
		return $this->selectWhere($table, array($data), $where, $default, 4);
	}
	
	
	public function useTransaction ($func, $args=array()) {
		
		try {
			
			$this->beginTransaction();
			
			$result = $func($args);
			
			if ($result === false) {
				$this->rollback();
				return false;
			}
			
			$this->commit();
			
			return true;
			
		} catch (\PDOException $e) {
			
			if ($this->inTransaction()) {
				$this->rollback();
			}
			
			return false;
		}
	}
	
	
	
	
}