<?php

	defined('ACC') || exit('ACC Denied');
	
	/**
	 * GoodsModel
	 */
	
	class GoodsModel extends Model {
		
		protected $table = 'goods'; // 表名
		
		protected $pk = 'goods_id'; // 主键
		
		/**
		 * 把商品放入回收站 , 即 `is_delete` 字段置为 1 
		 * @param {Int} $id 
		 * @return {Boolean}  
		 */
		public function transh( $id ) {
			
			$this->update(array('is_delete' => 1), $id);
			
		}
		
	}
	 
	 
?>