<?php
class config {
	
	public $config;

	public static function get($path = null) {
		
                if($path) {
			$config = $GLOBALS['config'];
			$path = explode('/', $path);
			/*
			if(isset($config[$path[0]])) {
				$x = $config[$path[0]];
			}
			if(isset($x[$path[1]])){
				$config = $x[$path[1]];
			}
			/*
			if(isset($y)){
				echo $y;
			}
			 */
			
			foreach($path as $bit){
				if(isset($config[$bit])){
					$config = $config[$bit];
				}
			}
			
			return $config;
		}
		return false;
        }
}
