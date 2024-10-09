<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/dbconnection.php';


use AgungDhewe\PhpSqlUtil\SqlUpdate;

try {

	// coba konek ke DB
	$dbconf = $GLOBALS['dbconfig'];
	$db = new PDO($dbconf['DSN'], $dbconf['user'], $dbconf['pass'], $dbconf['params']);
	
		
	$obj = new stdClass();
	$obj->bank_id = 'AAA';
	$obj->bank_name = 'Bank AAA';
	$obj->bank_code = 'BBB-01'; 
	$obj->_createby = 'admin';

	$cmd = new SqlUpdate("mst_bank", $obj, ['bank_id']);
	// $cmd->setQuote('[', ']');

	$sql = $cmd->getSqlString();
	$stmt = $db->prepare($sql);

	echo "updating data 1...\n";	
	$params = $cmd->getParameter();
	$stmt->execute($params);

	echo "updating data 1...\n";	
	$newdata = new stdClass();
	$newdata->bank_id = 'BBB';
	$newdata->bank_name = 'Bank BBB';
	$newdata->bank_code = null;
	$params = $cmd->getParameter($newdata);
	$stmt->execute($params);


} catch (PDOException $e) {
	echo "\nERROR\n";
	echo $e->getMessage();
} finally {
	echo "\n\n";	
}