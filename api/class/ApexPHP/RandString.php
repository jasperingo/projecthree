<?php

namespace ApexPHP;


class RandString {
	
	const TYPE_ALL = 0;
	
	const TYPE_NUM = 1;
	
	const TYPE_ALPHA = 2;
	
	const TYPE_SYMB = 3;
	
	const TYPE_ALPHANUM = 4;
	
	const TYPE_ALPHASYMB = 5;
	
	const TYPE_NUMSYMB = 6;
	
	const ALPHA_UP = 1;
	
	const ALPHA_LOW = 2;
	
	const ALPHA_BOTH = 0;
	
	const ALPHABETS = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
	
	const NUMBERS = array(0,1,2,3,4,5,6,7,8,9);
	
	const SYMBOLS = array("!","?","&","*","#","+","-","_","/","\\","=","(",")");
	
	
	
	public static function get (int $len=5, $type=0, int $case=0) : string {
		
		if (!is_array($type)) {
			return self::make($len, self::getArray($type, $case), $case);
		}
		
		$r = "";
		$tCount = count($type);
		$nLen = floor($len/$tCount);
		
		for ($i=0;$i<$tCount;$i++) {
			$dLen = $i==0 ? $nLen+($len%$tCount) : $nLen;
			$r .= self::make($dLen, self::getArray($type[$i], $case), $case);
		}
		
		return $r;
	}
	
	public static function make ($len, $data, $case=0) {
		$random = "";
		$last = count($data)-1;
		
		while (strlen($random)<$len) {
			$random .= $data[rand(0, $last)];
		}
		
		return $random;
	}
	
	public static function getCharType ($char, $case=0) {
		if (in_array($char, self::NUMBERS)) {
			return self::TYPE_NUM;
		} elseif (in_array($char, self::SYMBOLS)) {
			return self::TYPE_SYMB;
		} else {
			return self::TYPE_ALPHA;
		}
	}
	
	public static function getArray ($v, $case=0) {
		switch ($v) {
			case self::TYPE_NUM :
				return self::NUMBERS;
			case self::TYPE_ALPHA :
				return self::getAlphabets($case);
			case self::TYPE_SYMB :
				return self::SYMBOLS;
			case self::TYPE_ALPHANUM :
				return array_merge(self::getAlphabets($case), self::NUMBERS);
			case self::TYPE_ALPHASYMB :
				return array_merge(self::getAlphabets($case), self::SYMBOLS);
			case self::TYPE_NUMSYMB :
				return array_merge(self::NUMBERS, self::SYMBOLS);
			default :
				return array_merge(self::getAlphabets($case), self::NUMBERS, self::SYMBOLS);
		}
	}
	
	public static function getAlphabets ($case) {
		switch ($case) {
			case 1 :
				return self::alphabetsToUp();
			case 2 :
				return self::ALPHABETS;
			default :
				return array_merge(self::ALPHABETS, self::alphabetsToUp());
		}
	} 
	
	public static function alphabetsToUp () {
		return array_map(function ($l) { return strtoupper($l); }, self::ALPHABETS);
	}
	
	
	
	/* =======for the while loop above======
	$type = self::getRandCharType($char, $case);
	if (isset($limit[$type]) && self::randLimitReached($random, $type, $limit[$type], $case)) {
		continue;
	}
	public static function randLimitReached ($values, $type, $len, $case=0) : bool {
		$count=0;
		for ($i=0;$i<count($values);$i++) {
			if ($type == self::getRandCharType($values[$i], $case)) {
				$count++;
			}
		}
		
		return $count >= $len;
	}*/
	
	
}



