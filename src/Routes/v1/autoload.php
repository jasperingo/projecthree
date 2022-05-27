<?php

include_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'config.php';

function autoload($classname) {
	
    $filename = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR, $classname).'.php';
    //echo $filename;
    if (is_readable($filename)) {
        include_once $filename;
    }
}

spl_autoload_register('autoload');
