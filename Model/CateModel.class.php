<?php

	/**
	 * CateModel
	 */
	 
	class CateModel extends Model {
		
		protected $table = 'cate';
		
		/**
		 * 添加数据
		 * @params {Array} 添加数据的数组
		 */
		public function add ( $data ) {
			return $this->db->autoExecute($this->table, $data, 'insert');
		}
	} 

?>