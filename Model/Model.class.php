<?php

	// 所有类的基类

	class Model {
		
		protected $table = NULL; // model所控制的表
		protected $db = NULL; // 引入的MySql对象
		
		public function __cosntrcut() {
			$this->db = Mysql::getIns();
		}
		
		
		public function table( $table ) {
			$this->table = $table;
		}
		
	}

?>