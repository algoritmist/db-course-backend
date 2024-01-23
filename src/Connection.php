<?php

require_once "config.php";

use PDO;


function connect(string $host, string $port, string $db, string $user, string $password): PDO
{
	try {
		$dsn = "pgsql:host=$host;port=$port;dbname=$db;";

		// make a database connection
		return new PDO(
			$dsn,
			$user,
			$password,
			[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
		);
	} catch (PDOException $e) {
		die($e->getMessage());
	}
}

$conn = connect($host, $port, $database, $user, $password);

?>
