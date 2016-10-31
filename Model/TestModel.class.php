<?php

	class TestModel {
		
		protected $table = 'test';
		protected $db = NULL;
		
		public function __construct() {
			
			$this->db = Mysql::getIns();
			
		}
		
		/**
		 * 用户注册
		 * @param {Array} $data 写入的数据
		 */
		public function reg( $data ) {
			
			return $this->db->autoExecute($this->table, $data);
			
		}	 
		
		
	}

?>