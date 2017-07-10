<?php
	class Mail {

		static function send($to, $subject, $message) {
			$headers = "From:no-reply@camagram.net \r\n";

			if (mail($to, $subject, $message, $headers)) {
				return TRUE;
			} else {
				return FALSE;
			}
		}


		static function sendRegisterConfirmation($name, $email, $email_hash, $confirm_hash) {
			$subject = "Camagram - Confirm the Registration";
			$message = "Hello, " . $name . "!\n";
			$message .= "You have registered on Camagram!\n";
			$message .= "Please, confirm the Registration following the link below:\n";
			$message .= ROOT_URL . "user/confirm/" . $email_hash . "/" . $confirm_hash;

			return self::send($email, $subject, $message); 
		}
	}
?>