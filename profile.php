<?php

require_once 'core/init.php';

if(!$username = input::get('user')) {
	redirect::to('index.php');

}else {
	$user = new User($username);
	echo $username;
	if(!$user->exists()){
		redirect::to(404);
	}else {
		$data = $user->data();
	}
	?>

		<h3><?php echo escape($data->username); ?></h3>
		<p><?php echo escape($data->email); ?></p>
<?php
}


