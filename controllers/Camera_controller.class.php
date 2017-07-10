<?php
	class Camera_controller extends Controller {
		public function Index() {
			$this->displayView(NULL, NULL, 'views/camera.php');
		}

		public function Shot() {
			$data = explode(',', $_POST['image']);
			$data = str_replace(' ', '+', $data);
			$content = base64_decode($data[1]);

			$file_name = Hash::generate(10) . '.png';
			if ($file = fopen('assets/photos/' . $file_name, "wb")) {
				fwrite($file, $content);
				fclose($file);
				$gallery_model = new Gallery_model();
				$gallery_model->addNewPhoto($file_name);
			}
			

		}
	}
?>