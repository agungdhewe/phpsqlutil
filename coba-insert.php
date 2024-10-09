<?php

require_once __DIR__ . '/vendor/autoload.php';

use Agungdhewe\Phpsqlutil\SqlInsert;

try {

	// coba konek ke DB
	$db = new PDO("mysql:host=127.0.0.1;dbname=fgtadbdev;", "root", "rahasia123!", [
		\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
		\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
		\PDO::ATTR_PERSISTENT=>true
	]);
		
	$obj = new stdClass();
	$obj->area_id = 'AAA';
	$obj->area_name = 'Test AAA';
	$obj->_createby = 'admin';

	$cmd = new SqlInsert("mst_area", $obj);
	$cmd->setQuote('[', ']');

	$sql = $cmd->getSqlString();

	echo $sql;
	echo "\r\n";
	// $stmt = $db->prepare($sql);

	
	$params = $cmd->getParameter();
	print_r($params);


	$newdata = new stdClass();
	$newdata -> area_id = 'BBB';
	$newdata -> area_name = 'Test BBB';
	$params = $cmd->getParameter($newdata);
	print_r($params);


	

} catch (PDOException $e) {
	echo "\nERROR\n";
	echo $e->getMessage();
} finally {
	echo "\n\n";	
}