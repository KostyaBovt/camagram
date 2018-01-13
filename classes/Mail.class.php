<?php
	class Mail {

		static function send($from_name, $from_email, $to_email, $subject, $message) {

		$encoding = "utf-8";

		$subject_preferences = array(
			"input-charset" => $encoding,
			"output-charset" => $encoding,
			"line-length" => 76,
			"line-break-chars" => "\r\n"
		);

		$header = "Content-type: text/html; charset=".$encoding." \r\n";
		$header .= "From: ".$from_name." <".$from_email."> \r\n";
		$header .= "MIME-Version: 1.0 \r\n";
		$header .= "Content-Transfer-Encoding: 8bit \r\n";
		$header .= "Date: ".date("r (T)")." \r\n";
		$header .= iconv_mime_encode("Subject", $subject, $subject_preferences);


		if (mail($to_email, $subject, $message, $header)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}


		static function sendRegisterConfirmation($name, $to_email, $email_hash, $confirm_hash) {
			$subject = "Camagram - Confirm the Registration";
			$message = "Hello, " . $name . "!<br/><br/>";
			$message .= "You have registered on Camagram!<br/>";
			$message .= "Please, confirm the Registration following the link below:";
			$message .= ROOT_URL . "user/confirm/" . $email_hash . "/" . $confirm_hash;

			$from_name = 'Camagram';
			$from_email = 'no-reply@camagram.net';

			return self::send($from_name, $from_email, $to_email, $subject, $message);
		}

		static function sendResetPassword($name, $to_email, $email_hash, $reset_hash) {
			$subject = "Camagram - Reset the password";
			$message = "Hello, " . $name . "!<br/><br/>";
			$message .= "Forgot your password on Camagram?<br/>";
			$message .= "Please, following the link below to reset the password:";
			$message .= ROOT_URL . "user/reset/" . $email_hash . "/" . $reset_hash;

			$from_name = 'Camagram';
			$from_email = 'no-reply@camagram.net';

			return self::send($from_name, $from_email, $to_email, $subject, $message);
		}

		static function sendCommentNotification($name, $name_commented, $comment, $photo_index, $to_email) {
			$subject = "Camagram - Someone commented your photo";
			$message = "Hello, " . $name . "!<br/><br/>";
			$message .= "Your photo was commented by " . $name_commented . ":<br/>";
			$message .= "\"" . $comment . "\"<br/>";
			$message .= "You can following the link below to answer the comment:";
			$message .= ROOT_URL . "photo/index/" . $photo_index;

			$from_name = 'Camagram';
			$from_email = 'no-reply@camagram.net';

			return self::send($from_name, $from_email, $to_email, $subject, $message);	
		}
	}
?>