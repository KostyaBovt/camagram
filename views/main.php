<!DOCTYPE html>
<html>
<head>
	<title>Camagram</title>
	<link rel="stylesheet" href="/assets/css/index.css">
	<link rel="icon" sizes="192x192" href="/assets/img/icon.png">
	<?php 
		 if (isset($view_data['js_file'])) {
		 	echo '<script type="text/javascript" src="' . JS_PATH;
		 	echo $view_data['js_file'];
		 	echo '"></script>';
		 }
	?>
</head>
<body>
	<div class="all">
		<div class="header">
			<div class="logo">
				<a href="<?php echo ROOT_PATH; ?>"><img src="/assets/img/Logo.png"></a>
				<a href="<?php echo ROOT_PATH; ?>"><span id="logo-text">Camagram</span></a>
			</div>
			<div class="auth-user">
				<?php 
					if (Session::exists('loggued_user')) {
						require_once 'views/auth_buttons.php';
					} else {
						require_once 'views/nauth_buttons.php';
					}
				?>
			</div>
		</div>
		<div class="line"></div>
		<div class="center">
			<?php
				require_once ($view_file);
			?>
		</div>
		<div class="line"></div>
		<div class="footer"></div>
		<div class="line"></div>
	</div>
</body>
</html>