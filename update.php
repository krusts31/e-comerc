<?php
require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()) {
	redirect::to('index.php');
}

if(input::exists()) {
	if(token::check(input::get('token'))) {

		$validate = new validate();	
		$validation = $validate->check($_POST, array( 
			'email' => array(
				'required' => true,
				'isreal' => true
			)
		));

		if($validation->passed()) {
			
			try {
				$user->update(array(
					'email' => input::get('email')
				));

				session::flash('home', 'Your details have been updated');
				redirect::to('index.php');
			} catch (Exception $e) {
				die($e->getMessage());
			}	
		}else {
			foreach($validation->errors() as $error)
				echo $error, '<br>';
		}
	}
}
?>

<form action="" method="POST">
	<div class="field">
	<label for="email">Email</label>
	<input type="email" name="email" value="<?php echo escape($user->data()->email);?>">

	<input type="hidden" name="token" value="<?php echo token::generate(); ?>">
	<input type="submit" value="update">
	</div>
</form>
        <ul>
		<li><a href="index.php">Go back</a></li>
        </ul>

