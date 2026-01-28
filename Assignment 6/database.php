<?php
	$db_host = "localhost";
	$db_user = "nhp892";  
	$db_pwd = "ATun0912*"; 
	$db_db = "nhp892";
	$chars = "utf8mb4";

	$attr = "mysql:host=$db_host;dbname=$db_db;charset=$chars";
	$opts = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   => false,
	];
?>