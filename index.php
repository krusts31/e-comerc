<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'core/init.php';
if(session::exists('home')){
	echo session::flash('home');
}

$user = new User();
if($user->isLoggedIn()){
?>
	<p> Hello <a href='profile.php?user=<?php echo escape($user->data()->username);?>'><?php echo escape($user->data()->username);?></a>!</p>

	<ul>
		<li><a href="logout.php">Log out</a></li>
		<li><a href="update.php">Update info</a></li>
		<li><a href="changePassword.php">Cheange password</a></li>
	</ul>
<?php
	if($user->hasPremisson('moderator ')) {
		echo "<p>your Admin</p>";
	}

} else {
	echo '<p>You need to <a href="login.php">log in</a> or <a href="register.php">register</a></p>';
}


//var_dump(config::get('config/mysql'));

//$user = DB::getInstance()->update('info','3' , array('username' => 'Mitch', 'password' => 'I am sdasdapassword', 'name' => 'Bid', 'joined' =>date("Y/m/d/H/h/s"), 'breed' => NULL));

//var_dump($user);

//DB::getInstance()->insert('info', array('username' => 'Tim', 'password' => 'I am password', 'name' => 'Bid', 'joined' =>date("Y/m/d/H/h/s"), 'breed' => NULL));
//if(!$user->error()) {
//	echo 'No user';
//} else {
//	echo 'OK';
//}
