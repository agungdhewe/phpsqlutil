<?php namespace AgungDhewe\PhpSqlUtil;

final class SqlSelect extends SqlCommand {

	public function __construct(string $tablename, object $objkeys) {
		$this->setTableName($tablename);
		
		$keys = [];
		foreach ($objkeys as $key=>$value) {
			$keys[] = $key; 
		}
		$this->setKeys($keys);
	}

	#[Override]
	public function getSqlString(?array $fields = null): string {
		try {
			$tablename = $this->quoteName($this->_tablename);

			if ($fields===null) {
				$selectfields = "*";
			} else {
				$select = [];
				foreach ($fields as $field) {
					$select[] =  $this->quoteName($field);
				}
				$selectfields = implode(", ", $select);
			}

			$keys = [];
			foreach ($this->_keys as $key) {
				$keys[] = $this->quoteName($key) . " = :" . $key;
			}
			$where = implode(" AND ", $keys);

			$sql = "SELECT $selectfields FROM $tablename WHERE $where";
			return $sql;
		} catch (\Exception $ex) {
			throw $ex;
		}
	}


}