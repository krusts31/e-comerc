<?php
class token {
	public static function generate() {
		return session::put(config::get('session/token_name'), md5(uniqid()));
	}

	public static function check($token) {
		$tokeName = config::get('session/token_name');

		if(session::exists($tokeName) && $token === session::get($tokeName)) {
			session::delete($tokeName);
			return true;
		}
		return false;
	}
}
