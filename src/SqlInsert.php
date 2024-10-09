<?php namespace AgungDhewe\PhpSqlUtil;



final class SqlInsert extends SqlCommand
{


	public function __construct(string $tablename, object $obj) {
		$fields = [];
		$defaultvalues = [];
		foreach ($obj as $key => $value) {
			$fields[] = $key;
			$defaultvalues[$key] = $value;
		}
		$this->setTableName($tablename);
		$this->setFields($fields);
		$this->setDefaultValues($defaultvalues);
	}

	#[Override]
	public function getSqlString(): string {
		try {
			$tablename = $this->quoteName($this->_tablename);
			$fields = $this->quoteName(implode($this->EndQuote . ", " . $this->BeginQuote  , $this->_fields));
			$params = ":" . implode(", :", $this->_fields);
			$sql = "INSERT INTO $tablename ($fields) VALUES ($params)";
			return $sql;
		} catch (\Exception $ex) {
			throw $ex;
		}
	}


}