<?php
	class Home_controller extends Controller {
		public function Index() {
			$gallery_model = new Gallery_model();
			$gallery_view = $gallery_model->getHomeGallery();
			$this->displayView(NULL, $gallery_view, 'views/gallery.php');
		}

		public function install() {
			require_once 'install.php';
		}
	}
?>