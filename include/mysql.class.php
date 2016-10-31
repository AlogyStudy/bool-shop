<?php

	/**
	 * Mysql Class
	 */
	 
	class Mysql extends Db {
		
		private static $ins = NULL;
		private $conn = NULL;
		private $conf = array();
		
		protected function __construct() {
			
			$this->conf = Conf::getIns();
			
			$this->connect($this->conf->host, $this->conf->user, $this->conf->pwd);
			$this->select_db($this->conf->db);
			$this->setChar($this->conf->char);
			
		} 
		
		public function __destruct() {
		}
		
		public static function getIns() {
			
			if ( !(self::$ins instanceof self) ) {
				self::$ins = new self();
			}
			
			return self::$ins;
			
		}
		
		/**
		 * 连接服务器
		 * @params {String} $h 服务器地址 
		 * @params {String} $u 用户名 
		 * @params {String} $p 密码
		 * @return {Boolean}  
		 */
		public function connect( $h, $u, $p ) {
			
			$this->conn = mysql_connect($h, $u, $p);
			
			if ( !$this->conn ) {
				$err = new Exception('连接失败');
				throw $err;
			}
			
		}
		
		public function select_db( $db ) {
			
			$sql = 'use ' . $db;
			$this->query($sql);
			
		}
		
		/**
		 * 发送查询
		 * @params {String} $sql 查询的SQL语句
		 * @reutrn {mixed} --> Boolean/Resource  
		 */
		
		public function query( $sql ) {
			
			$rs = mysql_query($sql, $this->conn);
			
			Log::write($sql);
			
			return $rs;
			
		}
		
		
		public function setChar( $char ) {
			
			$sql = 'set names ' . $char;
			return $this->query($sql);
			
		}
		
		/**
		 * 自动拼接SQL语句 insert/update
		 * @params {String} $table 表名
		 * @params {Array} $data 插入的数据
		 * @params {String} $act 执行的方法
		 * @params {String} $where 执行条件
		 * @return {Boolean}
		 * 
		 * insert: 
		 * autoExecute('user', array('username' => 'zf', 'emial' => 'zf@qq.com'), 'insert');
		 * 形成: insert into user (username,email) values('zf', 'zf@qq.com');
		 * 
		 * update:
		 * autoExecute('user', array('username'=>'zf'), 'update', 'id=1');
		 * update user set username = 'zf' where id = 1;
		 */		
		public function autoExecute( $table, $arr, $mode = 'insert', $where = ' where 1 limit 1' ) {
			
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
			$sql .= '\')';
			
			return $this->query($sql);
			
		}
		
		/**
		 * 查询多行数据
		 * @params {String} $sql 查询的SQL语句
		 * @return {mixed} --> Array/Boolean
		 */
		
		public function getAll( $sql ) {
			
			$rs = $this->query($sql);
			
			$list = array();
			while ( $row = mysql_fetch_array($rs) ) {
				$list[] = $row;
			}
			
			return $list;
			
		}

		/**
		 * 查询单行数据
		 * @params {String} $sql 查询的SQL语句
		 * @return {mixed} --> Array/Boolean
		 */
		public function getRow( $sql ) {
			
			$rs = $this->query($sql);
			
			return mysql_fetch_assoc($rs);
			
		}

		/**
		 * 查询单个数据
		 * @params {String} $sql 查询的SQL语句
		 * @return {mixed} --> Array/Boolean
		 */		
		public function getOne( $sql ) {
			
			$rs = $this->query($sql);
			
			$row = mysql_fetch_row($rs);
			
			return $row[0];
			
		}
		
		/**
		 * 返回影响行数的函数
		 */
		public function affected_rows() {
			
			return mysql_affected_rows($this->conn);
			
		}
		
		/**
		 * 返回最新的auto_increment列的自增长的值
		 */
		
		public function insert_id() {
			
			return mysql_insert_id($this->conn);
			
		}
				
	}

?>