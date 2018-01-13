<?php
	class Photo_controller extends Controller {
		protected $_current_user;
		protected $_photo_user;
		protected $_photo_model;
		protected $_photo_data;
		protected $_photo_likes;
		protected $_photo_likes_n;
		protected $_photo_is_liked;
		protected $_photo_comments;


		private function photoIsLiked($user, $likes) {
			if (!$user || !$likes) {
				return FALSE;
			}
			$user_data = $user->getUserData();
			if (!$user_data) {
				return FALSE;
			}
			$user_id = $user_data->id;
			foreach ($likes as $like) {
				if ($like->user_id == $user_id) {
					return TRUE;
				}
			}
			return FALSE;
		}

		public function __construct($action, $params, $params_get) {
			parent::__construct($action, $params, $params_get);

			$this->_current_user = new User_controller($action, $params, $params_get);
			$this->_current_user->find_user();
			
			$this->_photo_model = new Photo_model();
			
			if (isset($this->_params[0]) && $this->_params[0]) {
				$this->_photo_data = $this->_photo_model->getPhotoData($this->_params[0]);

				$this->_photo_user = new User_controller($action, $params, $params_get);
				$this->_photo_user->find_user(array('id' => $this->_photo_data->user_id));

				$this->_photo_likes = $this->_photo_model->getPhotoLikes($this->_photo_data->id);
				$this->_photo_likes_n = $this->_photo_likes ? count($this->_photo_likes) : 0;
				$this->_photo_comments = $this->_photo_model->getPhotoComments($this->_photo_data->id);

				$this->_photo_is_liked = $this->photoIsLiked($this->_current_user, $this->_photo_likes);
			} else {
				header('Location: ' . ROOT_PATH .'home/index/');
				die();
			}
		}


		public function index() {
			$view_data['photo_data'] = $this->_photo_data;
			$view_data['photo_likes'] = $this->_photo_likes;
			$view_data['photo_likes_n'] = $this->_photo_likes_n;
			$view_data['photo_is_liked'] = $this->_photo_is_liked;
			$view_data['photo_comments'] = $this->_photo_comments;
			$view_data['photo_user'] = $this->_photo_user;
			$view_data['current_user'] = $this->_current_user;
			$view_data['js_file'] = 'photo.js';

			$this->displayView(NULL, $view_data, 'views/photo.php');
		}

		public function like() {
			if ($this->_current_user->exists()) {
				$this->_photo_model->addPhotoLike($this->_photo_data->id, $this->_current_user->getUserData()->id);
			}
			header('Location: ' . ROOT_PATH .'photo/index/' . (explode('.', $this->_photo_data->file_name))[0]);
			die();
		}

		public function comment() {
			if ($this->_current_user->exists() && $this->_params[0] && $_POST['comment'] != '' && $_POST['submit']) {
				$this->_photo_model->addPhotoComment($this->_photo_data->id, $this->_current_user->getUserData()->id, $_POST['comment']);
				if ($this->_current_user->getUserData()->id != $this->_photo_user->getUserData()->id) {
					$current_user = $this->_current_user->getUserData();
					$photo_user = $this->_photo_user->getUserData();
					$photo_index = explode('.', $this->_photo_data->file_name)[0];

					Mail::sendCommentNotification($photo_user->name, $current_user->name, $_POST['comment'], $photo_index, $this->_photo_user->getUserData()->email);
				}
			}
			header('Location: ' . ROOT_PATH .'photo/index/' . (explode('.', $this->_photo_data->file_name))[0]);
			die();
		}

		public function delete() {
			if ($this->_current_user->exists() && $this->_params[0]) {
				if ($this->_current_user->getUserData()->id == $this->_photo_user->getUserData()->id) {
					$this->_photo_model->deletePhoto($this->_photo_data->id);
					unlink(substr(PHOTO_PATH  . $this->_photo_data->file_name, 1));
					header('Location: ' . ROOT_PATH .'home/index/');
					die();
				}
			}
			header('Location: ' . ROOT_PATH .'photo/index/' . (explode('.', $this->_photo_data->file_name))[0]);
			die();
		}

	}
?>