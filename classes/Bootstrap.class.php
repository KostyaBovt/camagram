<?php
	class Bootstrap {
		public $request;
		public $action;
		public $controller;

		public function __toString() {
			return	'request: ' . print_r($this->request) . '<br/>' .
					'action: ' . $this->action . '<br/>' .
					'controller: ' . $this->controller . '<br/>';
		}

		public function __construct($request) {
			$this->request = $request;
			if (!isset($this->request['controller']) || $this->request['controller'] == '') {
				$this->controller = 'Home_controller';
			} else {
				$this->controller = ucfirst($request['controller'] . '_controller');
			}
			if (!isset($this->request['action']) || $this->request['action'] == '') {
				$this->action = 'index';
			} else {
				$this->action = $request['action'];
			}
		}

		public function createController() {
			if (class_exists($this->controller)) {
				$parents = class_parents($this->controller);
				if (in_array("Controller", $parents)) {
						if (method_exists($this->controller, $this->action)) {
							return new $this->controller($this->action, $this->request);
						} else {
							echo '<h1>Method does not exist<h1>';
							//echo 'controller: ' . $this->controller . ' action : ' . $this->action;
						}
					} else {
					echo '<h1>Base controller not found</h1>';
					return;
				}
			} else {
				echo '<h1>Controller does not exist</h1>';
				return;
			}
		}

	}
?>