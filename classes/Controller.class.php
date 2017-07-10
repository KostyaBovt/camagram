<?php
	class Controller {
		protected $request;
		protected $action;	
		
		public function __construct($action, $request) {
			$this->action = $action;
			$this->request = $request;
		}

		public function executeAction() {
			return $this->{$this->action}();
		}

		public function displayView($user_view, $gallery_view, $view_file) {
			require_once 'views/main.php';
		}
	}
?>