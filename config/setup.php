<?php
	require_once "database.php";

	$sql = file_get_contents('../dump.sql');

	try {
		$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
	} catch (PDOException $e) {
		echo 'Coonection failed: ' . $e->getMessage();
	}

	try {
	    $pdo->exec($sql);
	}
	catch (PDOException $e)
	{
	    echo $e->getMessage();
	    $pdo = NULL;
	    die();
	}

	$pdo = NULL;
	echo "Environment for Camagru application created!" . "\n";
?>