<?php
	class Validator {
		protected $_passed;
		protected $_errors;
		protected $_db;

		public function __construct() {
			$this->_passed = FALSE;
			$this->_errors = array();
			$this->_db = new Model();
		}

		public function check($source, $keys) {

			foreach ($keys as $key => $rules) {
				foreach ($rules as $rule => $rule_value) {

					$value = $source[$key];

					switch ($rule) {
						case 'required' :
							if (empty($value)) {
								$this->addError(ucfirst($key) . ' must be filled');
							}
							break;
						case 'min' :
							if (strlen($value) < $rule_value) {
								$this->addError(ucfirst($key) . ' must be at least ' . $rule_value . ' symbols');
							}
							break;
						case 'max' :
							if (strlen($value) > $rule_value) {
								$this->addError(ucfirst($key) . ' must be not more than ' . $rule_value . ' symbols');
							}
							break;
						case 'filter' :
							if (!filter_var($value, constant($rule_value))) {
								$this->addError(ucfirst($key) . ' is wrong format');
							}
							break;
						case 'matches' :
							if ($value != $source[$rule_value]) {
								$this->addError(ucfirst($key) . ' must match ' . ucfirst($rule_value));
							}
							break;
						case 'unique' :
							$sql = 'SELECT * FROM `' . $rule_value . '` WHERE `' . $key. '` = ?';
							$params = array($value);
							$this->_db->query($sql, $params);
							if ($this->_db->error() || $this->_db->count()) {
								$this->addError(ucfirst($key) . ' "' . $value . '" already exists');
							}
							break;
					}
				}
			}

			if (!count($this->_errors)) {
				$this->_passed = TRUE;
			}
		}

		public function passed() {
			return $this->_passed;
		}

		public function addError($error) {
			$this->_errors[] = $error;
			$this->_passed = FALSE;
		}

		public function errors() {
			return $this->_errors;
		}

	}
?>