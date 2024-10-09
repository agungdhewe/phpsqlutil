# Php SQL Utility

This library is used to simplify Insert, Update and Delete using SQL Command.

Add this library to your project

	composer require agungdhewe/phpsqlutil

## Example

### Insert Data

	use AgungDhewe\PhpSqlUtil\SqlInsert;


	// initialize database connection
	$db = new PDO(...);

	$obj = new stdClass();
	$obj->bank_id = 'AAA';
	$obj->bank_name = 'Test AAA';
	$obj->country_id = 'ID';

	$tablename = "mst_bank";
	$cmd = new SqlInsert($tablename, $obj);

	$sql = $cmd->getSqlString();
	$stmt = $db->prepare($sql);
	$params = $cmd->getParameter();
	$stmt->execute($params);	

If we want to insert new row, using previous initiation, we need only providing object that will represent new row:

	$newdata = new stdClass();
	$newdata->bank_id = 'BBB';
	$newdata->bank_name = 'Test BBB';
	$params = $cmd->getParameter($newdata);
	$stmt->execute($params);


## Update Data

	use AgungDhewe\PhpSqlUtil\SqlInsert;

	// initialize database connection
	$db = new PDO(...);

	$obj = new stdClass();
	$obj->bank_id = 'AAA';
	$obj->bank_name = 'Bank AAA';
	$obj->bank_code = 'BBB-01'; 

	$tablename = "mst_bank";

	$cmd = new SqlUpdate($tablename, $obj, ['bank_id']);
	$sql = $cmd->getSqlString();
	$stmt = $db->prepare($sql);
	$params = $cmd->getParameter();
	$stmt->execute($params);


## Delete Data

	use AgungDhewe\PhpSqlUtil\SqlDelete;

	// initialize database connection
	$db = new PDO(...);

	$obj = new stdClass();
	$obj->bank_id = 'AAA';
	$cmd = new SqlDelete("mst_bank", $obj, ['bank_id']);
	$sql = $cmd->getSqlString();
	$stmt = $db->prepare($sql);	
	$params = $cmd->getKeyParameter();
	$stmt->execute($params);


## Check existing data and update

	use AgungDhewe\PhpSqlUtil\SqlDelete;

	// initialize database connection
	$db = new PDO(...);

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