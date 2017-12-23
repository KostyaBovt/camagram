<?php
	class Model {
		protected $_pdo;
		protected $_results;
		protected $_stmt;
		protected $_error = FALSE;
		protected $_count = 0;


		public function __construct() {
			try {
				$this->_pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
				$this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
			} catch (PDOException $e) {
				echo 'Coonection failed: ' . $e->getMessage();
			}
		}

		public function query($sql, $params = array()) {
			$this->_error = FALSE;
			$this->_count = 0;

			$command = explode(' ', $sql)[0];
			
			try { 
				$this->_stmt = $this->_pdo->prepare($sql);
			} catch (PDOException $e) {
				echo $e->getMessage();
			}

			if (count($params)) {
				$i = 1;
				foreach ($params as $param) {
					switch (true) {
						case is_int($param):
							$type = PDO::PARAM_INT;
							break;
						case is_bool($param):
							$type = PDO::PARAM_BOOL;
							break;
						case is_null($param):
							$type = PDO::PARAM_NULL;
							break;
						default:
							$type = PDO::PARAM_STR;
					}
					$this->_stmt->bindValue($i, $param, $type);
					$i++;
				}
			}

			if ($this->_stmt->execute()) {
				$this->_count = $this->_stmt->rowCount();
				if (strtolower($command) == 'select') {
					$this->_results = $this->_stmt->fetchAll(PDO::FETCH_OBJ);
				}
			} else {
				$this->_error = TRUE;
			}
		}


		public function insert($table, $fields) {
			$keys = '(`' . implode('`, `', array_keys($fields)) . '`)';
			
			$values = '(';
			$i = 1;
			foreach ($fields as $key => $value) {
				$values .= '?';
				if ($i < count($fields)) {
					$values .= ', ';
				};
				$i++;			
			}
			$values .= ')';

			$sql = "INSERT INTO " . $table . " " . $keys . " VALUES " . $values;
			$this->query($sql, $fields);
		}

		public function update($table, $fields, $where) {
			$set = "";
			$i = 1;	
			foreach ($fields as $column => $value) {
				$set .= $column . " = ? ";
				if ($i < count($fields)) {
					$set .= ", ";
				}
				$i++;
			}
			$this->query("UPDATE " . $table . " SET " . $set . " WHERE " . $where[0] ." " . $where[1] . " " . $where[2], $fields);
		}

		public function delete($table, $where) {
			$this->query("delete from " . $table . " WHERE " . $where[0] . " " . $where[1] . " " . $where[2]);
		}

		public function error() {
			return $this->_error;
		}

		public function count() {
			return $this->_count;
		}

		public function results() {
			return $this->_results;
		}

		public function lastInsertId2() {
			return $this->_pdo->lastInsertId();
		}


	}
?>