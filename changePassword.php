<?php:

require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()){
	redirect::to('index.php');
}

if(input::exists()){
	if(token::check(input::get('token'))) {

		$validate = new validate();
                $validation = $validate->check($_POST, array(
                        'password_current' => array(
                                'required' => true,
				'min' => 25
				
			),
			'password_new' => array(
				'required' => true,
				'min' => 25
			),
			'password_new_again' => array(
				'required' => true,
				'min' => 25,
				'matches' => 'password_new'
			)
                ));
		
		if($validation->passed()) {

			if(!password_verify(input::get('password_current'), $user->data()->password)){
				echo "your curent password in incorect";
			} else {
				$user->update(array(
					'password' => hash::make(input::get('password_new'), array('cost' => 12))
				));
				session::flash('home', 'your passord has been changed');
				redirect::to('index.php');
			}				
		}else {
			foreach($validation->errors() as $error){
				echo $error, '<br>';
			}
		}

	}
}

?>

<form action="" method="post">
	<div class="field">
		<label for="password_current">Current password</label>
		<input type="password" name="password_current" id="password_current">
	</div>

	<div class="field">
		<label for="password_new">New password</label>
		<input type="password" name="password_new" id="password_new">
	</div>
        <div class="field">
                <label for="password_new_again">New password repeted</label>
                <input type="password" name="password_new_again" id="password_new_again">
        </div>

	<input  type="hidden" name="token" value="<?php echo escape(token::generate());?>">
	<input type="submit" value="change">
</form>

<ul>
	<li><a href="index.php">Go back</a></li>
</ul>


~
