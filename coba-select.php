<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/dbconnection.php';


use AgungDhewe\PhpSqlUtil\SqlSelect;

try {

	// coba konek ke DB
	$dbconf = $GLOBALS['dbconfig'];
	$db = new PDO($dbconf['DSN'], $dbconf['user'], $dbconf['pass'], $dbconf['params']);
	
		
	$cmd = new SqlSelect("mst_bank", ['bank_id']);

	$sql = $cmd->getSqlString();
	$stmt = $db->prepare($sql);
	
	$key = new stdClass();
	$key->bank_id = 'AAA';
	$params = $cmd->getKeyParameter($key);

	$stmt->execute($params);
	$row = $stmt->fetch();
	
	
	print_r($row);




} catch (PDOException $e) {
	echo "\nERROR\n";
	echo $e->getMessage();
} finally {
	echo "\n\n";	
}