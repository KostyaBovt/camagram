<?php
	class Camera_controller extends Controller {
		public function Index() {
			$user = new User_controller($this->_action, $this->_params, $this->_params_get);
			$user->find_user();
			if (!$user->exists()) {
				header('Location: ' . ROOT_PATH .'home/index');
				die();
			}
			$camera_model = new Camera_model();
			$view_data['stickers'] = $camera_model->getStickersData();
			$this->displayView(NULL, $view_data, 'views/camera.php');
		}

		private function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct) {
	        // creating a cut resource
	        $cut = imagecreatetruecolor($src_w, $src_h);

	        // copying relevant section from background to the cut resource
	        imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
	       
	        // copying relevant section from watermark to the cut resource
	        imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
	       
	        // insert cut resource to destination image
	        imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
	    }

		public function Shot() {
			if (!isset($_POST['image']) ||
				!isset($_POST['sticker_id'])) {
				return;
			}


			$data = explode(',', $_POST['image']);
			$data = str_replace(' ', '+', $data);

			$B = strlen($data[1]) / 1.37;
			$MB = $B / (1024 * 1024);

			if ($MB > 5) {
				echo json_encode(['code' => '2']);
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
				echo json_encode(['code' => '0']);
				return;				
			}

			$tmp_file_name = Hash::generate(10) . '.' . $ext;
			$source = imagecreatefromstring($content);

			// png
			if ($ext == 'png') {
				if (!$imageSave = imagepng($source, 'assets/tmp/' . $tmp_file_name, 0)) {
					echo json_encode(['code' => '0']);
					return;
				}
				$tmp_img_source = imagecreatefrompng('assets/tmp/' . $tmp_file_name);
			} else {
				if (!$imageSave = imagejpeg($source, 'assets/tmp/' . $tmp_file_name, 100)) {
					echo json_encode(['code' => '0']);
					return;
				}
				$tmp_img_source = imagecreatefromjpeg('assets/tmp/' . $tmp_file_name);
			}
			imagedestroy($source);

			list($width, $height) = getimagesize('assets/tmp/' . $tmp_file_name);
			$tmp_img_dst = imagecreatetruecolor(500, 375);
			imagecopyresized($tmp_img_dst, $tmp_img_source, 0, 0, 0, 0, 500, 375, $width , $height);

			// merge png
			$sticker_id = $_POST['sticker_id'];
			$sticker_img = imagecreatefrompng('assets/img/' . $sticker_id . '.png');

			// $black = imagecolorallocate($sticker_img, 0, 0, 0);
			// imagecolortransparent($sticker_img, $black);

			$this->imagecopymerge_alpha($tmp_img_dst, $sticker_img, 150, 90, 0, 0, 170, 170, 100);
			unlink('assets/tmp/' . $tmp_file_name);

			$file_name = Hash::generate(10) . '.jpg';

			imagejpeg($tmp_img_dst, 'assets/photos/' . $file_name, 100);

			$gallery_model = new Gallery_model();
			$gallery_model->addNewPhoto($file_name);

			ob_start();
			imagejpeg($tmp_img_dst);
			$response_img_string =  ob_get_contents();
			ob_end_clean();

			$response =  [
				"code" => '1',
				"img" => base64_encode($response_img_string)
			];

			echo json_encode($response);
		}
	}
?>