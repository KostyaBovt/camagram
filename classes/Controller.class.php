<?php
	class Controller {
		protected $_action;	
		protected $_params;
		protected $_params_get;

		
		public function __construct($action, $params, $params_get) {
			$this->_action = $action;
			$this->_params = $params;
			$this->_params_get = $params_get;
		}

		public function executeAction() {
			return $this->{$this->_action}();
		}

		public function displayView($user_view, $view_data, $view_file) {
			require_once 'views/main.php';
		}
	}
?>