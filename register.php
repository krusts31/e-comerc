<?php
require_once 'core/init.php';

if(input::exists()) {
	if(token::check(input::get('token'))) {
	$validate = new validate();
	$validation = $validate->check($_POST, array(
		"username" => array(
			"required" => true,
			"min" => 8,
			"max" => 20,
			"unique" => "info"
		),
		"password" => array(
			"required" => true,
			"min" => 25	
		),
		"password_again" => array(
			"required" => true,
			"matches" => "password"
		),
		"email" => array(
			"required" => true,
			"isreal" => true
		)
	));

	if($validation->passed()) {
		$user = new User();

		$options = ['cost' => 12,];
		try {
			$user->create('info', array(
				'id' => null,
				'username' => input::get('username'),
				'password' => hash::make(input::get('password'), $options),
				'email' => input::get('email'),
				'joined' => date('Y-m-d H:i:s'),
				'breed' => 1
			));
		}catch(exception $e) {
			die($e->getMessage());
		}
		session::flash('home', 'You register succsessfully');
		redirect::to('index.php');
		header("Location: index.php");
	}else {
		foreach($validation->errors() as $error) {
			echo $error, '<br>';
		}
	}
	//echo input::get("username");
	//echo input::get("password");
	//echo input::get("email");
	}
}
?>

<form action="" method="post">
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" placeholder="username" value="<?php echo escape(input::get('username'));?>" autocomplete="off">
	</div>
	<div class="field">
		<label for="password">Choose a Password</label> 
		<input type="password" name="password" id="password" placeholder="password">
	</div>
        <div class="field">
                <label for="password_again">Reenter a password</label>
                <input type="password" name="password_again" id="password_again" placeholder="password repeted">
	</div>
	<div class="field">
		<label for="email">Please provide a email</label>
		<input type="email" name="email" id="email" placeholder="email" value="<?php echo escape(input::get('email'));?>">
	</div>
	<div class ="field">
	<input type="hidden" name="token" value="<?php echo token::generate();?>">
	</div>
	<input type="submit" value="Register">

</form>
