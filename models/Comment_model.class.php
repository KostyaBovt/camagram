<?php
	class Comment_model extends Model {
		public function getCommentData($comment_id) {
			$this->query(	'SELECT comments.id AS comment_id, users.id as user_id, comments.*, users.* 
							FROM comments 
							INNER JOIN users 
							ON comments.user_id = users.id 
							WHERE comments.id = ?', 
							array($comment_id));
			if (empty($this->results())) {
				return NULL;
			}
			return $this->results()[0];
		}

		public function deleteComment($id) {
			$this->query('DELETE FROM comments WHERE id = ?', array($id));
		}
	}
?>