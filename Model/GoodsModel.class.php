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
			array('is_new', 0, 'is_new只能是0或1','in', '0,1'),
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
		
		/**
		 * 创建商品的货号
		 * 商品货号规则: BL + 时间戳 + 随机数
		 */
		public function createSn() {
			
			// 2 + 8 + 5;
			$sn = 'BL' . date('Ymd') . rand(10000, 99999);
			
			$sql = "select count(*) from " . $this->table . " where goods_sn='" .$sn . "'";
			
			// 如果存在再次调用该函数
			return $this->db->getOne($sql) ? $this->createSn() : $sn; 
			
		}
		
		/**
		 * 取出指定条数的新品
		 * @param {Int} $n 条数
		 * @param {String} $where 查询条件
		 * @return {Array}  取出的结果集
		 */ 
		public function getNew( $n=5, $where="is_new=1" ) {
			
			$sql = "select goods_id, goods_name, shop_price, market_price, thumb_img, ori_img from " . $this->table . " where " . $where . " order by add_time limit " . $n;
			
			return $this->db->getAll($sql);
		}
		
		/**
		 * 取出指定栏目的商品
		 * @param {Int} $cat_id 指定栏目id
		 * @return {Array} 
		 * 
		 * 顶级分类没有商品
		 * $cat_id = $_GET['cat_id'];
		 * $sql = "..... cat_id=$cat_id"; 不正确
		 * $cat_id 有可能对应的栏目是大栏目(顶级分类),大栏目下没有商品. 商品放在大栏目下的小栏目中.
		 * 正确的做法是， 找出cat_id所有的子孙栏目,然后再去查询 $cat_id 及其子孙栏目下的商品. 
		 */
		public function catGoods( $cat_id, $offset=0, $limit=5 ) {
			
			$cate = new CateModel(); 
			$cats = $cate->select(); // 取出所有的栏目
			
			$sons = $cate->getCateTree($cats, $cat_id); // 取出给定栏目的子孙树栏目
			
			$cat_sub = array($cat_id);			
			if ( !empty($sons) ) { // 不存在子孙栏目
				foreach ( $sons as $v ) {
					$cat_sub[] = $v['cat_id'];						
				}
			}
			
			$in = implode(',', $cat_sub);
						
			$sql = "select goods_id, goods_name, shop_price, market_price, thumb_img from " . $this->table . " where cat_id in(" . $in . ") order by add_time limit " . $offset . ',' . $limit;
			
			return $this->db->getAll($sql);
			
		}
		
		/**
		 * 获取购物车中的详细信息
		 * @param {Array} $items 购物车中的商品数组 
		 * @return {Array} 商品数组的详细信息   
		 */	
		public function getCarGoods( $items ) {
			
			// 判断是否为空
			if ( empty($items) ) {
				return $items;
			}
			
			// 循环中的商品
			foreach( $items as $k=>$v ) {
				$sql = "select goods_id, goods_name, thumb_img, market_price, cat_id from " . $this->table . " where goods_id=" . $k;
				
				$row = $this->db->getRow($sql);
				
				$items[$k]['thumb_img'] = $row['thumb_img'];
				$items[$k]['market_price'] = $row['market_price'];
				$items[$k]['goods_id'] = $row['goods_id'];
			}
			
			return $items;
		} 
		
		/**
		 * 取出 所有栏目
		 * @param {Int} $cat_id  指定栏目id
		 * @return 
		 */
		public function catGoodsCount( $cat_id ) {
			$category = new CateModel();
			$cats = $category->select(); // 所有栏目
			$sons = $category->getCateTree($cats, $cat_id);
			
			$sub = array($cat_id);
			
			// 是否存在子栏目
			if ( !empty($sons) ) { 
				foreach ( $sons as $v ) {
					$sub[] = $v['cat_id'];
				}
			}
			
			$in = implode(',', $sub);
			
			$sql = "select count(*) from goods where cat_id in (" . $in . ")";
			return $this->db->getOne($sql);
			
		} 	
		
	}
	 
?>