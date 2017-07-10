<?php
	require_once 'config/database.php';

	$sql = file_get_contents('camagram.sql');

	$db = new PDO("mysql:host=" . HOST_NAME , DB_USER, DB_PASSWORD);


	try {
	    $db->exec($sql);
	}
	catch (PDOException $e)
	{
	    echo $e->getMessage();
	    die();
	}

	header('Location: ' . ROOT_PATH . 'home/index');
?>