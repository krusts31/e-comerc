<?php
use Facebook\FacebookSession;

FacebookSession:setDefaultApplication('812326412586213', '');

session_start();
//https://developers.facebook.com/docs/php/FacebookSession/5.0.0
$GLOBALS['config'] = array(
	'mysql' => array(
		'host' => '127.0.0.1',
		'username' => 'root',
		'password' => 'LOT100079!zfg',
		'db' => 'login'
	),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 604800
	),
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token'
	)
);

spl_autoload_register(function($class) {
	require_once 'classes/'. $class . '.php';
});

require_once 'functions/sanitize.php';


if(cookie::exists(config::get('remember/cookie_name')) && !session::exists(config::get('session/session_name'))) {
	$pass = config::get('*');
	$pass = ($pass['remember']['cookie_name']);

        $hash = cookie::get($pass);
            
        $hashCheck = DB::getInstance()->get('users_sessions', array('hash', '=', $hash));
        if($hashCheck === false) {
                echo "error";
        } else if($hashCheck->count()) {
		$user = new User($hashCheck->first()->user_id);
                $user->login();
        } else {
        }
} else {
}

