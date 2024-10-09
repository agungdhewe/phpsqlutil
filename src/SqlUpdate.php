<?php namespace AgungDhewe\PhpSqlUtil;

final class SqlUpdate extends SqlCommand {

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

	#[Override]
	public function getSqlString(): string {
		try {
			$tablename = $this->quoteName($this->_tablename);

			$update = [];
			foreach ($this->_defaultvalues as $field => $value) {
				if (in_array($field, $this->_keys)) {
					continue;
				}
				$update[] =  $this->quoteName($field) . " = :" . $field;
			}
			$updatefields = implode(",\n\t", $update);

			$keys = [];
			foreach ($this->_keys as $key) {
				$keys[] = $this->quoteName($key) . " = :" . $key;
			}
			$where = implode(" AND ", $keys);

			$sql = "UPDATE $tablename\nSET\n\t$updatefields\nWHERE\n$where";
			return $sql;
		} catch (\Exception $ex) {
			throw $ex;
		}
	}


}