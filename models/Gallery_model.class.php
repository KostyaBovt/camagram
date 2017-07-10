<?php
	class Gallery_model extends Model {

		public function getHomeGallery() {
			$this->query('SELECT * FROM photos ORDER BY photos.photo_date DESC LIMIT 12');
			if ($this->_error) {
				return FALSE;
			} else {
				return $this->_results;
			}
		}

		public function getUserGallery($user_login) {
			if (!$user_login) {
				$user_id = Session::get('loggued_user');
				$params = array($user_id);
				$this->query('SELECT * FROM photos WHERE user_id = ? ORDER BY photos.photo_date DESC LIMIT 12', $params);
			} else {
				$params = array($user_login);
				$this->query('SELECT * FROM photos INNER JOIN users	ON photos.user_id = users.id WHERE users.login = ? ORDER BY photos.photo_date DESC LIMIT 12', $params);
			}
			return $this->results();
		}

		public function addNewPhoto($file_name) {
			$this->insert('photos', array(
				'id' => NULL,
				'user_id' => Session::get('loggued_user'),
				'file_name' => $file_name
			));
		}

		public function getPhotoData($hash) {
			$params = array($hash . '.png');
			$this->query('SELECT * FROM photos WHERE photos.file_name = ?', $params);
			if ($this->count()) {
				return $this->results()[0];
			} else {
				return FALSE;
			}
		}

	}
?>