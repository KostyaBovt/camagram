<?php
	class User_controller extends Controller{
		
		public function register() {
			$user_model = new User_model();
			$user_model->register();
			$this->displayView(NULL, NULL, 'register.php');
		}

		public function confirm() {
			$user_model = new User_model();
			$user_model->confirm();
		}

		public function login() {
			$user_model = new User_model();
			$user_model->login();
			$this->displayView(NULL, NULL, 'login.php');
		}

		public function account() {
			$gallery_model = new Gallery_model();
			
			if(isset($_GET['id1']) && $_GET['id1'] != ''){
				$user_login = $_GET['id1'];
			} else {
				$user_login = FALSE;
			}
			$gallery_view = $gallery_model->getUserGallery($user_login);
			$this->displayView(NULL, $gallery_view, 'account.php');
		}

		public function logout () {
			Session::del('loggued_user');
			header('Location: ' . ROOT_PATH .'home/index');
			die();
		}
	}
?>