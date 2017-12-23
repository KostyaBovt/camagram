<?php
	class User_model extends Model {

		public function register() {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			

			if (isset($post['submit'])) {

				$validator = new Validator();
				$validator->check($post, array(
					'login' => array(
						'required' => TRUE,
						'max' => 20, 
						'unique' => 'users'
					),
					'password' => array(
						'required' => TRUE,
						'min' => 8,
						'max' => 20
					),
					'repeat_password' => array(
						'required' => TRUE,
						'matches' => 'password'
					),					
					'name' => array(
						'required' => TRUE
					),
					'email' => array(
						'required' => TRUE, 
						'unique' => 'users',
						'filter' => 'FILTER_VALIDATE_EMAIL'
					),
				));

				if (!$validator->passed()) {
					$error_messages = $validator->errors();
					Message::put($error_messages, 'register_errors');
					header('Location: ' . ROOT_PATH .'user/register');
					die();
				}		

				$login = $post['login'];
				$password = Hash::make($post['password']);
				$name = $post['name'];
				$email = $post['email'];

				$this->insert('users', array(
					'id' => NULL,
					'login' => $login,
					'password' => $password,
					'name' => $name,
					'email' => $email,
					'confirmed' => 0
				));
				
				$new_user_id = $this->_pdo->lastInsertId(); 
				if ($new_user_id) {

					$confirm_hash = Hash::generate(32);
					$email_hash = Hash::make($email);
					$this->insert('confirm', array(
						'id' => NULL,
						'user_id' => $new_user_id, 
						'hash' => $confirm_hash

					));

					if ($this->_pdo->lastInsertId()) {

						if (Mail::sendRegisterConfirmation($name, $email, $email_hash, $confirm_hash)) {
							Message::put('User was registered. Plese confirm the registration via e-mail', 'register_success');
							header('Location: ' . ROOT_PATH .'user/register');
							die();
						}
					}
				}
			}
		}


		public function confirm($params) {
			
			$get_email_hash = $params[0];
			$get_confirm_hash = $params[1];
			
			$this->query('SELECT * FROM confirm WHERE hash = "' . $get_confirm_hash . '"');

			if ($this->count()) {
				$user_id = $this->results()[0]->user_id;
				$this->query('SELECT * FROM users WHERE id = "' . $user_id . '"');
				
				if ($this->count()) {
					$user_email = $this->results()[0]->email;

					if (Hash::make($user_email) === $get_email_hash) {
						$this->update('users', array('confirmed' => 1), array('id', '=', $user_id));
						if ($this->count()) {
							Message::put('You account was activated. Now you can log in!', 'confirm_success');
							header('Location: ' . ROOT_PATH .'user/login');
							die();
						}
					}
				}
			}
		}

		public function login() {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			if (isset($post['submit'])) {

				$post_login = $post['login'];
				$post_password = $post['password'];

				if ($post_login != '' && $post_password != '') {

					$this->query('SELECT * FROM users WHERE login = "' . $post_login . '"');
					if ($this->count()) {
						$user_data = $this->results()[0];
						if ($user_data->password == Hash::make($post_password) && $user_data->confirmed == 1) {
							Session::put('loggued_user', $user_data->id);
							header('Location: ' . ROOT_PATH .'home/index');
							die();
						}
					}
					
				}
				Message::put('Login failed', 'login_failed');
				header('Location: ' . ROOT_PATH .'user/login');
				die();
			}

		}

		public function getUserData($user) {
			if (isset($user['email'])) {
				$this->query("SELECT * FROM users WHERE `email` = ?", array($user['email']));
				if ($this->count() && !$this->error()) {
					return $this->results()[0];
				}
				return FALSE;
			}
						
			if (isset($user['id'])) {
				$this->query("SELECT * FROM users WHERE `id` = ?", array($user['id']));
				if ($this->count() && !$this->error()) {
					return $this->results()[0];
				}
				return FALSE;
			}

			if (isset($user['login'])) {
				$this->query("SELECT * FROM users WHERE `login` = ?", array($user['login']));
				if ($this->count() && !$this->error()) {
					return $this->results()[0];
				}
				return FALSE;
			}

			return FALSE;

		}


		public function addResetHash($user_id, $reset_hash) {
			$this->query('DELETE FROM reset WHERE user_id = ?', array($user_id));
			if ($this->error()) {
				return FALSE;
			}

			$this->insert('reset', array(
				'id' => NULL,
				'user_id' => $user_id,
				'hash' => $reset_hash
			));
			if ($this->error()) {
				return FALSE;
			}
			return TRUE;
		}

		public function ckeckResetHash($reset_hash) {
			$this->query('SELECT * FROM reset WHERE hash = ?', array($reset_hash));
			if ($this->error() || !$this->count()) {
				return FALSE;
			}
			return $this->results()[0]->user_id;
		}

		public function updatePassword($user_id, $password) {
			$this->update('users', array('password' => $password), array('id', '=', $user_id));
			if ($this->error() || !$this->count()) {
				return FALSE;
			}
			return TRUE;
		}

	}
?>