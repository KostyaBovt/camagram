<?php
	class Photo_model extends Model {
		public function getPhotoData($hash) {
			$params = array($hash . '.jpg');
			$this->query('SELECT * FROM photos WHERE photos.file_name = ?', $params);
			if ($this->count()) {
				return $this->results()[0];
			} else {
				return FALSE;
			}
		}

		public function getPhotoDataById($id) {
			$this->query('SELECT * FROM photos WHERE photos.id = ?', array($id));
			if ($this->count()) {
				return $this->results()[0];
			} else {
				return FALSE;
			}
		}

		public function getPhotoLikes($photo_id) {
			$this->query('SELECT likes.id AS like_id, likes.*, users.* FROM likes INNER JOIN users on likes.user_id = users.id WHERE likes.photo_id = ?', array($photo_id));
			if ($this->count()) {
				return $this->results();
			} else {
				return FALSE;
			}
		}

		public function getPhotoComments($photo_id) {
			$this->query('SELECT comments.id AS comment_id, comments.*, users.* FROM comments INNER JOIN users on comments.user_id = users.id WHERE comments.photo_id = ? ORDER BY comments.comment_date', array($photo_id));
			if ($this->count()) {
				return $this->results();
			} else {
				return FALSE;
			}
		}

		public function addPhotoLike($photo_id, $user_id) {
			$this->query('SELECT * from likes WHERE (photo_id = ? AND user_id = ?)', array($photo_id, $user_id));
			if ($this->count()) {
				$this->query('DELETE from likes WHERE ((photo_id = ? AND user_id = ?))', array($photo_id, $user_id));
			} else {
				$this->insert('likes', array(
					'id' => NULL,
					'photo_id' => $photo_id,
					'user_id' => $user_id
				));
			}
		}

		public function addPhotoComment($photo_id, $user_id, $comment) {
			$this->insert('comments', array(
				'id' => NULL,
				'photo_id' => $photo_id,
				'user_id' => $user_id,
				'comment' => $comment
			));
		}

		public function deletePhoto($photo_id) {
			$this->delete('photos', array(
					'id',
					'=',
					$photo_id,
				)
			);
		}

	}
?>