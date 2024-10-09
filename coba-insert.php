<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/dbconnection.php';

use Agungdhewe\Phpsqlutil\SqlInsert;

try {

	

	// coba konek ke DB
	$dbconf = $GLOBALS['dbconfig'];
	$db = new PDO($dbconf['DSN'], $dbconf['user'], $dbconf['pass'], $dbconf['params']);
		
	$obj = new stdClass();
	$obj->bank_id = 'AAA';
	$obj->bank_name = 'Test AAA';
	$obj->country_id = 'ID';
	$obj->_createby = 'admin';

	$cmd = new SqlInsert("mst_bank", $obj);
	// $cmd->setQuote('[', ']');

	$sql = $cmd->getSqlString();
	$stmt = $db->prepare($sql);

	
	echo "inserting data 1...\n";
	$params = $cmd->getParameter();
	$stmt->execute($params);	


	echo "inserting data 2...\n";
	$newdata = new stdClass();
	$newdata -> bank_id = 'BBB';
	$newdata -> bank_name = 'Test BBB';
	$params = $cmd->getParameter($newdata);
	$stmt->execute($params);


	

} catch (PDOException $e) {
	echo "\nERROR\n";
	echo $e->getMessage();
} finally {
	echo "\n\n";	
}