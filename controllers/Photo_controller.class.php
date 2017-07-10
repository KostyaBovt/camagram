<?php
	class Photo_controller extends Controller {


		public function index() {
			$get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
			$gallery_model = new Gallery_model();
			$photo_data = $gallery_model->getPhotoData($get['id1']);
			$gallery_view['photo_data'] = $photo_data;
			if ($photo_data) {
				$this->displayView(NULL, $gallery_view, 'views/photo.php');
			}
		}
	}
?>