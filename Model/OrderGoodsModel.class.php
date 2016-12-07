<?php

	defined('ACC') || exit('ACC Denied');

	class OrderGoodsModel extends Model {
		
		protected $table = 'ordergoods';
		protected $pk = 'og_id';
		
		/**
		 * 订单的商品写入 `ordergoods`表
		 * @param {Array} $data 订单数据
		 */
		public function addOG( $data ) {
			
			// 写入数据
			if ( $this->add($data) ) { // 添加成功，减少库存
				// 更新库存
				$sql = "update goods set goods_number = goods_number - " . $data['goods_number'] . " where goods_id = " . $data['goods_id'];
				
				return $this->db->query($sql); // 减少库存  
			} 
			return false;	
			
		}
		
	}

?>