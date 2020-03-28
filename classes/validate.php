<?php

class validate {

	private $_passed = false,
		$_errors = array(),
		$_db = null;

	public function __construct() {
		$this->_db = DB::getInstance();
	}

	public function check($sorce, $items) {
		foreach($items as $item => $rules) {
			foreach($rules as $rule => $rule_value) {
				$item = escape($item);
				//echo "{$item} {$rule} must be {$rule_value}<br>";
				$value = $sorce[$item];

				if($rule === 'required' && empty($value)) {
					$this->addError("{$item} is required");
				} else if(!empty($value)){
					switch($rule){
					case 'min':
						if(strlen($value) < $rule_value) {
							$this->addError("{$item}  must be a minimum of {$rule_value}");
						}
					break;
					case 'max':
						if(strlen($value) > $rule_value) {
							$this->addError("{$item}  must be a maximum of {$rule_value}");
							}
					break;
					case 'matches':
						if($value != $sorce[$rule_value]) {
							$this->addError("{$rule_value} must match {$item}");
						}
					break;
					case 'unique':
						$check = $this->_db->get($rule_value, array($item, '=', $value));
						if($check->count()) {
						$this->addError("{$value} as {$item} is allready registered please us a different {$item}");
						}
					break;
					}
				}
			}
		}
		if(empty($this->_errors)) {
			$this->_passed = true; 
		}
	return $this;
	}

	private function addError($error) {
		$this->_errors[] = $error;
	}

	public function errors() {
		return $this->_errors;
	}

	public function passed() {
		return $this->_passed;
	}

}
