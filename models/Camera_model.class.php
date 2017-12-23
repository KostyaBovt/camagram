<?php
	class Camera_model extends Model {
		public function getStickersData() {
			$this->query('SELECT * FROM stickers');
			if ($this->count()) {
				return $this->results();
			} else {
				return FALSE;
			}
		}

		public function getStickersDataById($id) {
			$this->query('SELECT * FROM stickers where id=?', array($id));
			if ($this->count()) {
				return $this->results();
			} else {
				return FALSE;
			}
		}
	}
?>