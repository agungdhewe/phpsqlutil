<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/dbconnection.php';


use AgungDhewe\PhpSqlUtil\SqlSelect;
use AgungDhewe\PhpSqlUtil\SqlUpdate;

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
	
	
	// update data dari row
	if ($row) {
		$obj = (object)$row;
		$cmd = new SqlUpdate("mst_bank", $obj, ['bank_id']);
		$sql = $cmd->getSqlString();
		$stmt = $db->prepare($sql);

		$newdata = new stdClass();
		$newdata->bank_name = 'Ini ganti nama bank';
		
		$params = $cmd->getParameter($newdata);
		$stmt->execute($params);
	}


} catch (PDOException $e) {
	echo "\nERROR\n";
	echo $e->getMessage();
} finally {
	echo "\n\n";	
}