<?php

namespace ApexPHP;


class Filex {
	
	const VALID_TYPE = "t";
	
	const VALID_SIZE_MAX = "x";
	
	const VALID_SIZE_MIN = "i";
	
	const VALID_TYPE_FULL = "f";
	
	const VALID_EXTENSION = "e";
	
	const IMAGE_TYPE = "image";
	
	const APPLICATION_TYPE = "application";
	
	const IMAGE_EXTS = array('png', 'jpg', 'jpeg');
	
	const APPLICATION_EXTS = array('doc', 'docx', 'pdf');
	
	
	
	public static function upload (array $f, string $directory, array $options=array()) : int {
		
		if (!empty($options)) {
			
			$valid = self::validate($f, $options);
			
			if ($valid != 0) {
				return $valid;
			}
		}
		
		if (!move_uploaded_file($f['tmp_name'], $directory)) {
			return 7;
		}
		
		return 0;
	}
	
	public static function validate (array $f, array $options) : int {
		
		if ($f['error'] > 0) {
			return 1;
		}
		
		if (isset($options[self::VALID_SIZE_MAX])) {
			if ($f['size'] > $options[self::VALID_SIZE_MAX]) {
				return 2;
			}
		}
		
		if (isset($options[self::VALID_SIZE_MIN])) {
			if ($f['size'] < $options[self::VALID_SIZE_MIN]) {
				return 3;
			}
		}
		
		if (isset($options[self::VALID_EXTENSION])) {
			if (!in_array(self::getExtension($f['name']), $options[self::VALID_EXTENSION])) {
				return 4;
			}
		}
		
		if (isset($options[self::VALID_TYPE])) {
			if (explode("/", $f['type'])[0] != $options[self::VALID_TYPE]) {
				return 5;
			}
		}
		
		if (isset($options[self::VALID_TYPE_FULL])) {
			if ($f['type'] != $options[self::VALID_TYPE_FULL]) {
				return 6;
			}
		}
		
		return 0;
	}
	
	public static function getExtension ($f) : string {
		
		$ext = is_array($f) ? explode(".", $f['name']) : explode(".", $f);
		
		return strtolower(end($ext));
	}
	
	
	
	
}

