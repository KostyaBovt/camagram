<?php
	class User_controller extends Controller{
		protected $_user_data;
		protected $_user_model;
		
		public function __construct($action, $params, $params_get) {
			parent::__construct($action, $params, $params_get);
			$this->_user_model = new User_model();
		}

		public function find_user($user = array()) {
			if (!$user) {
				$user['id'] = Session::get('loggued_user');
			}
			$this->_user_data = $this->_user_model->getUserData($user);
		}

		public function register() {
			$this->_user_model->register();
			$this->displayView(NULL, NULL, 'register.php');
		}

		public function confirm() {
			 if (isset($this->_params[0]) || isset($this->_params[1])) {
				$this->_user_model->confirm($this->_params);
			}
		}

		public function login() {
			$this->_user_model->login();
			$this->displayView(NULL, NULL, 'login.php');
		}

		public function account() {
			$gallery_model = new Gallery_model();
			$user = array();
			
			if(isset($this->_params[0]) && $this->_params[0]){
				$user['login'] = $this->_params[0];
			} else {
				if ($user_id = Session::get('loggued_user')) {
					$user['id'] = $user_id; 
				}
			}
			$this->_user_data = $this->_user_model->getUserData($user);

			$view_data['user_data'] = $this->_user_data;


			$page = 1;
			if (isset($this->_params_get['p'])) {
				$page = (int)$this->_params_get['p'];
				if ($page < 1) {
					$page = 1;
				}
			}

			$view_data['curr_page'] = $page;

			if ($this->_user_data) {
				$view_data['gallery_data'] = $gallery_model->getUserGallery($this->_user_data->id, $page);
			} 
			$this->displayView(NULL, $view_data, 'account.php');
		}

		public function forgot() {
			if (isset($_POST['submit']) && $_POST['email']) {
				$this->find_user(array('email' => $_POST['email']));
				if (!$this->exists()) {
					Message::put('User with such email doesn`t exist', 'forgot_fail');
					header('Location: ' . ROOT_PATH .'user/forgot');
					die();
				} else {
					var_dump($this->_user_data);
					$reset_hash = Hash::generate(32);
					$email_hash = Hash::make($this->_user_data->email);
					if ($this->_user_model->addResetHash($this->_user_data->id, $reset_hash)) {
						if (Mail::sendResetPassword($this->_user_data->login, $_POST['email'], $email_hash, $reset_hash)) {
							Message::put('We send you email to reset the password', 'forgot_success');
						}
					}					

					header('Location: ' . ROOT_PATH .'user/forgot');
					die();
				}
			} else {
				$this->displayView(NULL, NULL, 'forgot.php');
			}
		} 

		public function reset() {
			$view_data = array();

			$view_data['hashes'] = array(
				'email_hash' => NULL,
				'reset_hash' => NULL
			);

			if (isset($this->_params[0]) && isset($this->_params[1])) {
				$view_data['hashes'] = array(
					'email_hash' => $this->_params[0],
					'reset_hash' => $this->_params[1]
				);
			}

			if (isset($_POST['submit'])) {

				$user_id = $this->_user_model->ckeckResetHash($_POST['reset_hash']);
				if (!$user_id) {
					Message::put(array('Incorrect link for password reset!'), 'reset_fail');
					header('Location: ' . ROOT_PATH .'user/reset');
					die();
				}

				$this->find_user(array('id' => $user_id));
				if (!$this->exists()) {
					Message::put(array('Error occured!'), 'reset_fail');
					header('Location: ' . ROOT_PATH .'user/reset');
					die();
				}

				if (Hash::make($this->_user_data->email) != $_POST['email_hash']) {
					Message::put(array('Incorrect link for password reset!'), 'reset_fail');
					header('Location: ' . ROOT_PATH .'user/reset');					
					die();
				}

				$validator = new Validator();
				$validator->check($_POST, array(
					'password' => array(
						'required' => TRUE,
						'min' => 8,
						'max' => 20
					),
					'repeat_password' => array(
						'required' => TRUE,
						'matches' => 'password'
					)
				));
				if (!$validator->passed()) {
					Message::put($validator->errors(), 'reset_fail');
					header('Location: ' . ROOT_PATH .'user/reset/' . $this->_params[0] . '/' . $this->_params[1]);
					die();					
				}

				if ($this->_user_model->updatePassword($this->_user_data->id, Hash::make($_POST['password']))) {
					Message::put('Password successfully updated', 'reset_success');
					header('Location: ' . ROOT_PATH .'user/reset');
					die();										
				}

				Message::put(array('Error occured updating pasword'), 'reset_fail');
				header('Location: ' . ROOT_PATH .'user/reset');
				die();
			}

			$this->displayView(NULL, $view_data, 'reset.php');
		}

		public function logout () {
			Session::del('loggued_user');
			header('Location: ' . ROOT_PATH .'home/index');
			die();
		}

		public function getUserData() {
			return $this->_user_data;
		}

		public function exists() {
			return ($this->_user_data) ? TRUE : FALSE;
		}
	}
?>