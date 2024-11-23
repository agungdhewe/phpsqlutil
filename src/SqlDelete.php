<?php namespace AgungDhewe\PhpSqlUtil;

final class SqlDelete extends SqlCommand {

	public function __construct(string $tablename, object $obj, array $keys) {
		$fields = [];
		$defaultvalues = [];
		foreach ($obj as $key => $value) {
			$fields[] = $key;
			$defaultvalues[$key] = $value;
		}
		$this->setTableName($tablename);
		$this->setFields($fields);
		$this->setKeys($keys);
		$this->setDefaultValues($defaultvalues);
	}

	// #[Override]
	public function getSqlString(): string {
		try {
			$tablename = $this->quoteName($this->_tablename);

			$keys = [];
			foreach ($this->_keys as $key) {
				$keys[] = $this->quoteName($key) . " = :" . $key;
			}
			$where = implode(" AND ", $keys);

			$sql = "DELETE FROM $tablename WHERE $where";
			return $sql;
		} catch (\Exception $ex) {
			throw $ex;
		}
	}


}