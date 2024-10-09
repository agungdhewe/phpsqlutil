<?php namespace AgungDhewe\PhpSqlUtil;

abstract class SqlCommand {
	protected string $BeginQuote = "";
	protected string $EndQuote = "";
	
	protected readonly array $_defaultvalues;



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


}