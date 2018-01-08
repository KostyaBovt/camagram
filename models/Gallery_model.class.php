<?php
	class Gallery_model extends Model {

		public function getHomeGallery($page) {
			$offset = ($page - 1) * 12;
			$this->query('SELECT * FROM photos ORDER BY photos.photo_date DESC LIMIT 12 OFFSET ' . $offset);
			if ($this->_error) {
				return FALSE;
			} else {
				return $this->_results;
			}
		}

		public function getUserGallery($user_id, $page) {
			if (!$user_id) {
				return FALSE;
			}
			$offset = ($page - 1) * 12;
			$params = array($user_id, $offset);
			$this->query('SELECT users.id AS user_id, photos.id AS photo_id, photos.*, users.* FROM photos INNER JOIN users	ON photos.user_id = users.id WHERE user_id = ? ORDER BY photos.photo_date DESC LIMIT 12 OFFSET ?', $params);

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