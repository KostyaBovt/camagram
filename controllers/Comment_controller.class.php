<?php
	class Comment_controller extends Controller {
		protected $_current_user;
		protected $_comment_user;
		protected $_comment_model;
		protected $_comment_data;
		protected $_photo_data;
		protected $_photo_model;

		public function __construct($action, $params, $params_get, $params_post) {
			parent::__construct($action, $params, $params_get, $params_post);
		
			if (!isset($this->_params[0]) || !$this->_params[0]) {
				header('Location: ' . ROOT_PATH .'home/index/');
				die();
			}
			$this->_current_user = new User_controller($action, $params, $params_get, $params_post);
			$this->_current_user->find_user();
			$this->_comment_model = new Comment_model();
			$this->_comment_data = $this->_comment_model->getCommentData($this->_params[0]);
			if (!$this->_comment_data) {
				header('Location: ' . ROOT_PATH .'home/index/');
				die();
			}
			
			$this->_comment_user = new User_controller($action, $params, $params_get, $params_post);
			$this->_comment_user->find_user(array('id' => $this->_comment_data->user_id));

			$this->_photo_model = new Photo_model();
			$this->_photo_data = $this->_photo_model->getPhotoDataById($this->_comment_data->photo_id);
		}

		public function delete() {
			$comment_id = $this->_params[0];
			if ($comment_id &&
				$this->_current_user->exists() &&
				($this->_comment_data->user_id == $this->_current_user->getUserData()->id ||
				$this->_photo_data->user_id == $this->_current_user->getUserData()->id)
				) {
					$this->_comment_model->deleteComment($this->_comment_data->comment_id);
			}
			header('Location: ' . ROOT_PATH .'photo/index/' . (explode('.', $this->_photo_data->file_name))[0]);
			die();
		}
	}
?>