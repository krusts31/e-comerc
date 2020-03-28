<?php

public function mail($to, $subject, $message, $headers) {

	$to;
	$subject;
	$message;
	$headers;
	mail($to, $subject, $message, $headers);
	if (!$success) {
    	$errorMessage = error_get_last()['message'];
	}
}

