<?php
	class Bootstrap {
		private $_action;
		private $_controller;
		private $_params;
		private $_params_get;

		private static function getRouteIndexes() {
			$root_path = explode('/', ROOT_PATH);

			$counter = 0;
			foreach ($root_path as $path_elem) {
				if ($path_elem != '') {
					$counter++;
				}
			}
			$indexes_array = array(
				'controller' => $counter + 1,
				'action' => $counter + 2,
				'params' => $counter + 3
			);
			return $indexes_array;
		} 

		public function __toString() {
			return	'request: ' . print_r($this->_request) . '<br/>' .
					'action: ' . $this->_action . '<br/>' .
					'controller: ' . $this->_controller . '<br/>';
		}

		public function __construct() {
			$this->_controller = 'Home_controller';
			$this->_action = 'index';
			$this->_params = array();
			$this->_params_get = array();

			$parsed_uri = parse_url($_SERVER['REQUEST_URI']);

			if (isset($parsed_uri['query'])) {
				parse_str($parsed_uri['query'], $this->_params_get);
			}

			$route = explode('/', $parsed_uri['path']);
			$indexes = self::getRouteIndexes();

			if (!empty($route[$indexes['controller']])) {
				$this->_controller = ucfirst($route[$indexes['controller']]) . '_controller';
			}

			if (!empty($route[$indexes['action']])) {
				$this->_action = $route[$indexes['action']];
			}

			$i = $indexes['params'];
			while (!empty($route[$i])) {
				$this->_params[] = $route[$i];
				$i++;
			}

		}

		public function createController() {
			if (class_exists($this->_controller)) {
				$parents = class_parents($this->_controller);
				if (in_array("Controller", $parents)) {
						if (method_exists($this->_controller, $this->_action)) {
							return new $this->_controller($this->_action, $this->_params, $this->_params_get);
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

		public function getControllerName() {
			return $this->_controller;
		}

		public function getActionName() {
			return $this->_action;
		}

	}
?>