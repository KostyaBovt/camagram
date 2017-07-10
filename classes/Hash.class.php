<?php
	class Hash {
		static function make($string) {
			return md5($string);
		}
	
		static function generateRandomString($length = 10) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
		}

		static function generate($length) {
			return self::make(self::generateRandomString($length));
		}

	}

?>