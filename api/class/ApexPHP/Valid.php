<?php

namespace ApexPHP;


class Valid {
	
	
	public static function cleanString (string $text) : string {
		return htmlspecialchars(strip_tags(trim($text)));
	}
	
	public static function checks ($values, $start=1) : int {
		foreach ($values as $i=> $v) {
			if ($v == false) {
				return $i+$start;
			}
		}
		
		return 0;
	}
	
	public static function string (string $text, int $maxLimit=null, int $minLimit=null, $checks=false) : int {
		
		if ($text === "") {
			return 1;
		}
		
		if ($maxLimit != null && strlen($text) > $maxLimit) {
			return 2;
		}
		
		if ($minLimit != null && strlen($text) < $minLimit) {
			return 3;
		}
		
		if (is_array($checks)) {
			
			$c = self::checks($checks, 4);
			
			if ($c > 0) {
				return $c;
			}
			
		} elseif ($checks == true) {
			return 4;
		}
		
		return 0;
	}
	
	public static function number (float $numb, float $maxLimit=null, float $minLimit=null, $checks=false) : int {
		
		if ($maxLimit !== null && $numb > $maxLimit) {
			return 1;
		}
		
		if ($minLimit !== null && $numb < $minLimit) {
			return 2;
		}
		
		if (is_array($checks)) {
			
			$c = self::checks($checks, 3);
			
			if ($c > 0) {
				return $c;
			}
			
		} elseif ($checks == true) {
			return 3;
		}
		
		return 0;
	}
	
	public static function email (string $email, $checks=false) : int {
		
		if (empty($email)) {
			return 1;
		}
		
		if (!filter_var($email, FILTER_VALIDATE_EMAIL) /*|| !checkdnsrr($email,"MX")*/) { 
			return 2; 
		}
		
		if (is_array($checks)) {
			
			$c = self::checks($checks, 3);
			
			if ($c > 0) {
				return $c;
			}
			
		} elseif ($checks == true) {
			return 3;
		}
		
		return 0;
	}

	
	
	
}



