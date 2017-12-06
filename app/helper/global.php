<?php
if (!function_exists('alert')) {
	function alert($data, $die = false) {
		echo '<pre>';
		print_r($data);
		echo '</pre>';
		if ($die) die();
	}
}

if (!function_exists('array_get')) {
	function array_get($array, $key, $default = null) {
	    if (is_null($key)) return $array;

		if (isset($array[$key])) return $array[$key];

		foreach (explode('.', $key) as $segment) {
		    if (!is_array($array) || !array_key_exists($segment, $array)) {
		       return value($default);
		    }

		    $array = $array[$segment];
		}

		return $array;
	}
}

if (!function_exists('value')) {
	function value($value) {
	     return $value instanceof Closure ? $value() : $value;
	}
}

if (!function_exists('t')) {
    function t($string, $params = []) {
        $translation = \Phalcon\DI::getDefault()->get('translation');
        return $translation->_($string, $params);
    }
}

if (!function_exists('et')) {
    function et($string, $params = []) {
        $translation = \Phalcon\DI::getDefault()->get('translation');
        echo $translation->_($string, $params);
    }
}

if (!function_exists('t_mm')) {
	function t_mm($string, $params = []) {
		$trans_mm = \Phalcon\DI::getDefault()->get('trans_mm');
	    if (isset($trans_mm[$string])) {
	    	return $trans_mm[$string];
	    } else {
	    	
	  		// $fp = fopen('data.txt', 'a+');
			// fwrite($fp, $string."\n\r");
			// fclose($fp);

	    	return $string;
	    }
	}
}


if (!function_exists('dd')) {
	function dd($data) {
		echo '<pre>';
		print_r($data);
		echo '</pre>';
		exit();
	}
}

if (!function_exists('ddm')) {
	function ddm($data) {
		if(count($data)>1){
			foreach ($data as $r) {
				$response[] = $r->toArray();
			}
		}else{
			$response = $data->toArray();
		}
		echo '<pre>';
		print_r($response);
		echo '</pre>';
		exit();
	}
}
