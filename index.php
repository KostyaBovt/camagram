<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	session_start();

	require('config/database.php');

	function vdf($var, $var_name) {
	    $myfile = fopen("var_dump_"  . microtime(true) . "_" . $var_name . ".txt", "w") or die("Unable to open file!");
	    ob_start();
	    var_dump($var);
	    $txt = ob_get_clean();
	    fwrite($myfile, $txt);
        fclose($myfile);
	}

	$rootPath = dirname($_SERVER['DOCUMENT_ROOT']);
	$url = current(array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))));
	$url2 = $_SERVER['REQUEST_URI'];

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


	$bootstrap = new Bootstrap();

	$controller = $bootstrap->createController();
	if($controller){
	 	$controller->executeAction();
	}

?>