<?php
	class Session {

		static function putMessage($message, $type) {
			$_SESSION['messages'][$type] = $message;
		}

		static function getMessage($type) {
			$to_return = $_SESSION['messages'][$type];
			unset($_SESSION['messages'][$type]);
			return $to_return;
		}

		static function existsMessage($type) {
			if (isset($_SESSION['messages'])) {
				return isset($_SESSION['messages'][$type]);
			}
			return false;
		}

		static function put($name, $value) {
			$_SESSION[$name] = $value;
		} 

		static function get($name) {
			if (Session::exists($name)) {
				return $_SESSION[$name];
			} else {
				return FALSE;
			}
		} 

		static function exists($name) {
			return isset($_SESSION[$name]);
		}

		static function del($name) {
			if (isset($_SESSION[$name])) {
				unset($_SESSION[$name]);
			}
		}

	}
?>