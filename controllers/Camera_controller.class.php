<?php
	class Camera_controller extends Controller {
		public function Index() {
			$camera_model = new Camera_model();
			$view_data['stickers'] = $camera_model->getStickersData();
			$this->displayView(NULL, $view_data, 'views/camera.php');
		}

		public function Shot() {
			$data = explode(',', $_POST['image']);
			$data = str_replace(' ', '+', $data);
			$content = base64_decode($data[1]);

			$tmp_file_name = Hash::generate(10) . '.png';
			$tmp_file = fopen('assets/tmp/' . $tmp_file_name, "wb");
			if (!$tmp_file) {
				echo "0";
				return;
			}
			fwrite($tmp_file, $content);
			fclose($tmp_file);

			$tmp_img = imagecreatefrompng('assets/tmp/' . $tmp_file_name);

			$sticker_id = $_POST['sticker_id'];
			$sticker_img = imagecreatefrompng('assets/img/' . $sticker_id . '.png');

			imagecopymerge($tmp_img, $sticker_img, 150, 90, 0, 0, 350, 350, 100);
			unlink('assets/tmp/' . $tmp_file_name);

			$file_name = Hash::generate(10) . '.png';
			imagepng($tmp_img, 'assets/photos/' . $file_name, 0);
			$gallery_model = new Gallery_model();
			$gallery_model->addNewPhoto($file_name);
			
			echo "1";

		}
	}
?>