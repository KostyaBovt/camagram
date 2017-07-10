
<div class="container-gallery">
<!-- 	<div class="account-container">
		<div class="account-avatar">
			<img src="assets/img/avatar.jpg">
		</div>	
		<div class="account-info">
			<div class="account-login">
				<h1>Darwin_dog</h1>
				<a href="">Settings</a>
			</div>
			<div class="account-name"><h1>Richard Dawkins</h1></div>
			<div class="account-years"><h2>56 years</h2></div>
			<p class="account-bio">Scientist, popolarizator of science and antropology</p>
		</div>
	</div> -->

		<?php 
			foreach ($gallery_view as $photo) {
				$photo_src = PHOTO_PATH . $photo->file_name;
				$photo_id = (explode('.', $photo->file_name));
				$photo_id = $photo_id[0];
				echo '<div class="photo-gallery"><a href="' . ROOT_PATH . 'photo/index/' . $photo_id . '"><img src="' . $photo_src . '"></a></div>'; 
			}
		?>

</div>