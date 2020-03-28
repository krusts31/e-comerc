<?php
require_once 'core/init.php';

if(input::exists()) {
	if(token::check(input::get('token'))) {
		$validate = new validate();
		$validation = $validate->check($_POST, array(
			'username' => array(
				'required' => true
			),
			'password' => array(
				'required' => true
			)
		));

		if($validation->passed()) {
			$user = new User();

			$remember = (input::get('remember') === 'on') ? true : false;
			$login = $user->login(input::get('username'), input::get('password'), $remember);
			echo "<br>";
			echo "<br>";
			var_dump($login);
			if($login) {
				redirect::to('index.php');
				echo "succsess";
			} else {
				echo "NOPE";
			}
		}else {
			foreach($validation->errors() as $error) {
				echo $error, '<br>';
			}
		}
	}
}

?>



<form action="" method="post">
	<div class="field">
		<label for="username">Username or email</label>
		<input type="text" name="username" id="username" autocomplete="off">
	</div>
        <div class="field">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
	</div>
	<div class="field">
		<label for="remember">
			<input type="checkbox" name="remember" id="rember"> Remember me
		</label>
	</div>
<br>
	<input type="hidden" name="token" value="<?php echo escape(token::generate());?>">
	<input type="submit" value="Log in">
</form>

<ul>
	<li><a href="forgotPassword.php">Forgot your password?</a></li>
</ul>
