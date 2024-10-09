<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/dbconnection.php';


use Agungdhewe\Phpsqlutil\SqlDelete;

try {

	// coba konek ke DB
	$dbconf = $GLOBALS['dbconfig'];
	$db = new PDO($dbconf['DSN'], $dbconf['user'], $dbconf['pass'], $dbconf['params']);
	
		
	$obj = new stdClass();
	$obj->bank_id = 'AAA';
	$obj->bank_name = 'Bank AAA';
	$cmd = new SqlDelete("mst_bank", $obj, ['bank_id']);
	// $cmd->setQuote('[', ']');

	$sql = $cmd->getSqlString();
	$stmt = $db->prepare($sql);

	echo "deleting data 1...\n";	
	$params = $cmd->getKeyParameter();
	$stmt->execute($params);

	echo "deleting data 1...\n";	
	$newdata = new stdClass();
	$newdata->bank_id = 'BBB';
	$params = $cmd->getKeyParameter($newdata);
	$stmt->execute($params);


} catch (PDOException $e) {
	echo "\nERROR\n";
	echo $e->getMessage();
} finally {
	echo "\n\n";	
}