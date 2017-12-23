
<div class="container-gallery">
	<div class="account-container">
		<div class="account-avatar">
			<img src="/assets/avatars/avatar.png">
		</div>	
		<div class="account-info">
			<div class="account-login">
				<!-- <?php var_dump($view_data); ?> -->
				<h1><?php 
						if ($view_data['user_data']) {
							echo $view_data['user_data']->login. ' account'; 
						} else {
							echo 'No such user';
						}	
					?> 
					</h1>
				<!-- <a href="">Settings</a> -->
			</div>
			<!-- <div class="account-name"><h1>Richard Dawkins</h1></div>
			<div class="account-years"><h2>56 years</h2></div>
			<p class="account-bio">Scientist, popolarizator of science and antropology</p> -->
		</div>
	</div>

		<?php 
			if (isset($view_data['gallery_data'])) {
				foreach ($view_data['gallery_data'] as $photo) {
					$photo_src = PHOTO_PATH . $photo->file_name;
					$photo_id = (explode('.', $photo->file_name))[0];
					echo '<div class="photo-gallery"><a href="/photo/index/' . $photo_id . '"><img src="' . $photo_src . '"></a></div>'; 
				}
			}
		?>

</div>