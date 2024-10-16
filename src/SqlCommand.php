<?php namespace AgungDhewe\PhpSqlUtil;

abstract class SqlCommand {
	protected string $BeginQuote = "";
	protected string $EndQuote = "";
	
	protected readonly string $_tablename;
	protected readonly array $_fields;
	protected readonly array $_keys;
	protected readonly array $_defaultvalues;

	protected readonly object $_stmt;
	protected readonly object $_db;

	public function setTableName(string $tablename): void {
		$this->_tablename = $tablename;
	}

	public function setFields(array $fields): void {
		$this->_fields = $fields;
	}

	public function setKeys(array $keys): void {
		$this->_keys = $keys;
	}

	public function setDefaultValues(array $defaultvalues): void {
		$this->_defaultvalues = $defaultvalues;
	}

	public function setQuote(string $begin, string $end) : void {
		$this->BeginQuote = $begin;
		$this->EndQuote = $end;
	}


	protected function quoteName(string $name): string {
		return $this->BeginQuote . $name . $this->EndQuote;
	}


	public function getSqlString(): string {
		return "";
	}


	public function getParameter(object $obj = null): array{
		if (!isset($this->_defaultvalues)) {
			$this->_defaultvalues = (array)$obj;
		}

		$params = [];
		if ($obj === null) {
			foreach ($this->_defaultvalues as $key => $value) {
				$name = ":$key";
				$params[$name] = $value; 
			}
		} else {
			foreach ($this->_defaultvalues as $key => $value) {
				$name = ":$key";
				if (property_exists($obj, $key)) {
					$value = $obj->$key;
				}
				$params[$name] = $value; 
			}
		}
		return $params;
	}

	public function getKeyParameter(object $obj = null): array{
		if (!isset($this->_defaultvalues)) {
			$this->_defaultvalues = (array)$obj;
		}
		
		$params = [];
		if ($obj === null) {
			foreach ($this->_defaultvalues as $key => $value) {
				if (!in_array($key, $this->_keys)) {
					continue;
				}

				$name = ":$key";
				$params[$name] = $value; 
			}
		} else {
			foreach ($this->_defaultvalues as $key => $value) {
				if (!in_array($key, $this->_keys)) {
					continue;
				}

				$name = ":$key";
				if (property_exists($obj, $key)) {
					$value = $obj->$key;
				}
				$params[$name] = $value; 
			}
		}
		return $params;

	}

	public function bind(object $db) : void {
		$this->_db = $db;
		$this->_stmt = $db->prepare($this->getSqlString());
	}

	public function getPreparedStatement() : object {
		return $this->_stmt;
	}

	public function execute(?object $obj = null) : bool {
		if ($obj !== null) {
			$params = $this->getParameter($obj);
		} else {
			$params = [];
		}
		return $this->_stmt->execute($params);
	}

	public function fetch(int $mode = \PDO::FETCH_DEFAULT, int $cursorOrientation = \PDO::FETCH_ORI_NEXT, int $cursorOffset = 0) : mixed {
		return $this->_stmt->fetch($mode, $cursorOrientation, $cursorOffset);
	}

	public function fetchAll(int $mode = \PDO::FETCH_DEFAULT) : array {
		return $this->_stmt->fetchAll($mode);
	}

}