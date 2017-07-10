<?php
	class Message {
		
		static function put($message, $type) {
			Session::putMessage($message, $type);
		}

		static function get($type) {
			return Session::getMessage($type);
		}

		static function exists($type) {
			return Session::existsMessage($type);
		}
	}
?>