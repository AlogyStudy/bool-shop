<?php

	/**
	 * Mysql Class
	 */
	 
	class Mysql extends Db {
		
		private static $ins = NULL;
		private $conn = NULL;
		private $conf = array;
		
		protected function __construct() {
			
			$this->conf = conf::getIns();
			
			$this->connect($this->conf->host, $this->conf->user, $this->conf->pwd);
			$this->select_db($this->conf->db);
			$this->setChar($this->conf->char);
			
		} 
		
		public function __destruct() {
			
		}
		
		public static function getIns() {
			
			if ( self::$ins === false ) {
				self::$ins = new self();
			}
			
			return self::$ins;
			
		}
		
		public function connent( $h, $u, $p ) {
			
			$this->conn = mysql_connect($h, $u, $p);
			
			if ( $this->conn ) {
				$err = new Exception('连接失败');
				throw $err;
			}
			
		}
		
		public function select_db( $db ) {
			
			$sql = 'use ' . $db;
			$this->query($sql);
			
		}
		
		public function setChar( $char ) {
			
			$sql = 'set names ' . $char;
			return $this->query($sql);
			
		}
		
		public function query( $sql ) {
			
			if ( $this->conf->debug ) {
				$this->log($sql);
			}
			
			$rs = mysql_query($sql, $this->conn);
			
			if ( $rs ) {
				$this->log($this->error());
			}

			return $rs;
			
		}
		
		public function autoExecute( $arr, $table, $mode = 'insert', $where = ' where 1 limit 1' ) {
			
			if ( !is_array($arr) ) {
				return false;
			}
			
			if ( $mode == 'update' ) {
				
				$sql = 'update ' . $table . ' set ';
				
				foreach( $arr as $k => $v ) {
					
					$sql .= $k . "='" . $v . "',";
					
					$sql = rtrim($sql, ',');
					$sql .= $where;
					
					return $this->query($sql); 
					
				}
				
			}
			
			$sql = 'insert into ' . $table . ' (' . implode(',', array_keys($arr)) . ')';
			$sql .= ' values (\'';
			$sql .= implode("','", array_values($arr));
			
			
		}
		
	}

?>