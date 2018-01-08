<?php
	class Home_controller extends Controller {
		public function Index() {

			$page = 1;
			if (isset($this->_params_get['p'])) {
				$page = (int)$this->_params_get['p'];
				if ($page < 1) {
					$page = 1;
				}
			}

			$gallery_model = new Gallery_model();
			$gallery_view['photos'] = $gallery_model->getHomeGallery($page);
			$gallery_view['curr_page'] = $page;
			$this->displayView(NULL, $gallery_view, 'views/gallery.php');
		}

		public function install() {
			
			$sql = file_get_contents('camagram.sql');
			
			try {
				$db_dsn = 'mysql:host=localhost;charset=utf8';
				$pdo = new PDO($db_dsn, DB_USER, DB_PASSWORD);
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
			} catch (PDOException $e) {
				echo 'Coonection failed: ' . $e->getMessage();
			}

			try {
			    $pdo->exec($sql);
			}
			catch (PDOException $e)
			{
			    echo $e->getMessage();
			    die();
			}
			header('Location: ' . ROOT_PATH . 'home/index');

		}
	}
?>