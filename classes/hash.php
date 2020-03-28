<?php

class hash {

	public static function make($string, $options = array('cost' => 12)) {
		return password_hash($string, PASSWORD_BCRYPT, $options);
	}

	public static function unique() {
		return self::make(uniqid(), array( 'cost' => 12));
	}
}
