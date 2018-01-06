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

			$B = strlen($data[1]) / 1.37;
			$MB = $B / (1024 * 1024);

			if ($MB > 5) {
				echo "2";
				return;
			}

			$content = base64_decode($data[1]);
			
			$mime_type = explode(":", explode(";", $data[0])[0])[1];

			switch ($mime_type) {
				case 'image/jpeg':
					$ext = 'jpg';
					break;
				case 'image/png':
					$ext = 'png';
					break;
				default:
					$ext = null;
					break;
			}

			if (!$ext) {
				echo "0";
				return;				
			}

			$tmp_file_name = Hash::generate(10) . '.' . $ext;
			$source = imagecreatefromstring($content);

			// png
			if ($ext == 'png') {
				if (!$imageSave = imagepng($source, 'assets/tmp/' . $tmp_file_name, 0)) {
					echo "0";
					return;
				}
				$tmp_img_source = imagecreatefrompng('assets/tmp/' . $tmp_file_name);
				// process...
			} else {
				if (!$imageSave = imagejpeg($source, 'assets/tmp/' . $tmp_file_name, 100)) {
					echo "0";
					return;
				}
				$tmp_img_source = imagecreatefromjpeg('assets/tmp/' . $tmp_file_name);
				// process...				
			}
			imagedestroy($source);
			

			list($width, $height) = getimagesize('assets/tmp/' . $tmp_file_name);
			$tmp_img_dst = imagecreatetruecolor(500, 375);
			imagecopyresized($tmp_img_dst, $tmp_img_source, 0, 0, 0, 0, 500, 375, $width , $height);


			// jpg

			// merge png
			$sticker_id = $_POST['sticker_id'];
			$sticker_img = imagecreatefrompng('assets/img/' . $sticker_id . '.png');

			imagecopymerge($tmp_img_dst, $sticker_img, 150, 90, 0, 0, 175, 175, 100);
			// unlink('assets/tmp/' . $tmp_file_name);

			// png
			// $file_name = Hash::generate(10) . '.png';
			
			//jpg
			$file_name = Hash::generate(10) . '.jpg';
			
			//jpg
			// imagepng($tmp_img, 'assets/photos/' . $file_name, 0);
			
			//jpg
			imagejpeg($tmp_img_dst, 'assets/photos/' . $file_name, 100);
			

			$gallery_model = new Gallery_model();
			$gallery_model->addNewPhoto($file_name);
			
			echo "1";

		}
	}
?>