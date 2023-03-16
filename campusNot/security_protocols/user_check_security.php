<?php
	session_start();
 	if ($_SESSION['userID'] == NULL || $_SESSION['userStatus'] != 1) {
		 header("Location: ../index.html");
 	}
 	ini_set('display_errors', 'On');
 	error_reporting(E_ALL | E_STRICT);

 	include("../db.php");

 	$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
 	$options = [
	 	PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	 	PDO::ATTR_EMULATE_PREPARES   => false,
 	];
 	try {
	  $pdo = new PDO($dsn, $user, $pass, $options);
 	} catch (\PDOException $e) {
	  	throw new \PDOException($e->getMessage(), (int)$e->getCode());
	}
?>