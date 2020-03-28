<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

require_once('core/init.php');

if(input::exists()){
	if(token::check(input::get('token'))) {
		$validate = new validate();
                $validation = $validate->check($_POST, array(
                        'email' => array(
				'required' => true,
				'isreal' => true
                        	)
			));

	if($validation->passed()) {
		$user = new User();
		$emailAddress = input::get('email');
		echo $emailAddress;
//////////////////////////////////////////////////////////////////////
$mail = new PHPMailer(true);

try {
    //Server settings
	$mail->SMTPDebug = SMTP::DEBUG_SERVER; 
	// Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'dabbing15must@gmail.com';                     // SMTP username
    $mail->Password   = 'Kartupelu1245@';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 568;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('krusts31@gmail.com', 'Sasutis');
    $mail->addAddress("$emailAddress", 'Alex Krasts');     // Add a recipient
    $mail->addReplyTo('krusts31@gmail.com', 'Customer support');

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
////////////////////////////////////////////////////////////////////
}
}
}
?>

<form action="" method="post">
	<div class="field">
		<label for="email">In order to rest your password you need to provide email address associated with you account</label>
<br>
<input type="email" placeholder="Enter email adress" id="email" value="<?php echo escape(input::get('email'));?>" name ="email" autocomplete="off">
	</div>
<br>
        <input type="hidden" name="token" value="<?php echo escape(token::generate());?>">
	<input type="submit" value="submit">
</form>
<ul>
        <li><a href="index.php">Go back</a></li>
</ul>

