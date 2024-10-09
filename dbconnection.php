<?php

$GLOBALS['dbconfig'] = [
	'DSN' => "mysql:host=127.0.0.1;dbname=fgta4db;", 
	'user' => 'root', 
	'pass' => 'rahasia123!',
	'params' => [
		\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
		\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
		\PDO::ATTR_PERSISTENT=>true		
	]

];