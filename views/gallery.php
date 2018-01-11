<div class="container-gallery">
	<?php 
		foreach ($view_data['photos'] as $photo) {
			$photo_src = PHOTO_PATH . $photo->file_name;
			$photo_id = (explode('.', $photo->file_name))[0];
			echo '<div class="photo-gallery"><a href="' . ROOT_PATH . 'photo/index/' . $photo_id . '"><img src="' . $photo_src . '"></a></div>'; 
		}
		if ($view_data['curr_page'] == 1) {
			$disabled = ' disabled';
		} else {
			$disabled = '';
		}

		echo '<div style="clear:both;" ><a href="' . ROOT_PATH . 'home/index?p=' . ($view_data['curr_page'] - 1) . '"><button' . $disabled .'>previous</button></a>';
		echo '<a href="' . ROOT_PATH . 'home/index?p=' . ($view_data['curr_page'] + 1) . '"><button>next</button></a></div>';
	?>
</div>