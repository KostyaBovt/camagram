<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	session_start();

	require('config/database.php');

	spl_autoload_register(function($class) {
		$sources = array(
			'classes/' . $class . '.class.php',
			'controllers/' . $class . '.class.php',
			'models/' . $class . '.class.php',
		);
		foreach ($sources as $source) {
			if (file_exists($source)) {
				require_once $source;
			}
		}
	});


	$bootstrap = new Bootstrap($_GET);

	$controller = $bootstrap->createController();
	if($controller){
	 	$controller->executeAction();
	}

?>