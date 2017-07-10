<div class="container-gallery">
	<?php 
		foreach ($gallery_view as $photo) {
			$photo_src = PHOTO_PATH . $photo->file_name;
			$photo_id = (explode('.', $photo->file_name));
			$photo_id = $photo_id[0];
			echo '<div class="photo-gallery"><a href="' . ROOT_PATH . 'photo/index/' . $photo_id . '"><img src="' . $photo_src . '"></a></div>'; 
		}
	?>
</div>