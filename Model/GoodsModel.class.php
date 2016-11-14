<?php

	defined('ACC') || exit('ACC Denied');
	
	/**
	 * GoodsModel
	 */
	
	class GoodsModel extends Model {
		
		protected $table = 'goods'; // 表名
		
		protected $pk = 'goods_id'; // 主键
		
		protected $fields = array(
			'goods_id',
			'goods_sn',
			'cat_id',
			'brand_id',
			'goods_name',
			'shop_price',
			'market_price',
			'goods_number',
			'click_count',
			'goods_weight',
			'goods_brief',
			'goods_desc',
			'thumb_img',
			'goods_img',
			'ori_img',
			'is_on_sale',
			'is_delete',
			'is_best',
			'is_new',
			'is_hot',
			'add_time',
			'last_update',
			'keywords'
		); 
		
		protected $_auto = array(
			array('is_hot', 'value', 0),
			array('is_new', 'value', 0),
			array('is_best', 'value', 0),
			array('add_time', 'function', 'time')
		);
		
		protected $_valid = array( // 1 必须验证 , 0 有字段即检查    
			array('goods_name', 1, '必须有商品名', 'require'), 
			array('cat_id', 1, '栏目id必须是整型值', 'number'),
//			array('is_new', 0, 'is_new只能是0或1','in', '0,1'),
			array('goods_brief', 2, '商品简介应在10到100字符','length', '10,100')   			
		);
			
		/**
		 * 把商品放入回收站 , 即 `is_delete` 字段置为 1 
		 * @param {Int} $id 
		 * @return {Boolean}  
		 */
		public function transh( $id ) {
			
			return $this->update(array('is_delete' => 1), $id);
			
		}
		
		/**
		 * 获取正常上架商品
		 * @return {Array} 
		 */
		public function getGoods() {
			
			$sql = "select * from goods where is_delete=0";
			
			return $this->db->getAll($sql);
			
		}
		
		/**
		 * 获取回收站数据
		 * @return {Array}
		 */
		public function getTransh() {
			
			$sql = "select * from goods where is_delete=1";
			
			return $this->db->getAll($sql);
			
		}
		
		/**
		 * 彻底删除回收站数据
		 * @return {Boolean}
		 */
		public function delGoods() {
			
			$sql = "delete from goods where select * from goods where isdelete=1";
			
			return $this->db->query($sql);
			
		}
		
		/**
		 * 恢复回收站的功能
		 * @param {Int} $id 需要恢复的id
		 * @return {Boolean} 是否成功
		 */
		public function recovery( $id ) {
		 	
			return $this->update(array('is_delete' => 0), $id);			
			
		}
		 
	}
	 
?>