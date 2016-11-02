<?php

	class TestModel extends Model {
		
		protected $table = 'test';
		
		/**
		 * 用户注册
		 * @param {Array} $data 写入的数据
		 */
		public function reg( $data ) {
			
			return $this->db->autoExecute($this->table, $data);
			
		}	
		
		// 取所有的数据
		public function select() {
			
			return $this->db->getAll('select * from ' . $this->table);
			
		} 
		 
		
	}

?>