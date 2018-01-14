<?php
	$DB_DSN = 'mysql:host=localhost;charset=utf8';
	$DB_USER ='root';
	$DB_PASSWORD = 'dobro27a';
	$DB_NAME = 'camagram';

	define('DB_DSN', $DB_DSN);
	define('DB_USER', $DB_USER);
	define('DB_PASSWORD', $DB_PASSWORD);
	define('DB_NAME', $DB_NAME);

	define('ROOT_PATH', '/');
	define('IMG_PATH', ROOT_PATH . 'assets/img/');
	define('AVA_PATH', ROOT_PATH . 'assets/avatars/');
	define('PHOTO_PATH', ROOT_PATH . 'assets/photos/');
	define('JS_PATH', ROOT_PATH . 'assets/js/');
	define('ROOT_URL', 'http://localhost:8080' . ROOT_PATH);
?>