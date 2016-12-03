<?php

	/**
	 * 购物车类
	 */
	
	// 购物车特性：
	// 1. 无论在当前网站刷新了多少次页面，或者新增了多少个商品，都要求查看购物车时，看到的都是一样的结果. 即：打开A商品所在的页面刷新，B商品所在的页面刷新. 还是首页，看到的购物车应该是一样的. 
	// 或者说：整站范围内，购物车 -- 是全局有效的.
	
	// 解决：把购物车放在数据库中或者放入session中.
	
	// 2. 既然是全局有效， 暗示，购物车的实例只能有一个.
	// 不能说在3个页面，买了3个商品，就形成了3个购物车的实例，这是不合理的.
	
	// 解决：单例模式
	
	// session + 单例模式  实现购物车.
	
	
	/**
	 * 功能分析：
	 * 
	 * 判断商品是否存在
	 * 添加商品
	 * 删除商品
	 * 修改商品的数量
	 *
	 * 某商品数量加1
	 * 某商品数量减1
	 *  
	 * 查询购物车的商品种类
	 * 查询购物车的商品数量
	 * 查询购物车里的商品总金额
	 * 返回购物车的所有商品
	 * 清空购物车
	 */
	
//	defined('ACC') || exit('ACC Denied');	
	
	session_start();
	
	class CatrTool {
		
		private static $ins = null; 
		
		private $items = array(); // 存储商品数量
		
		// 构造函数私有化
		protected function __construct() {
		}
		
		final protected function __clone() {
		}
		
		// 获取实例
		protected static function getIns() {
			
			if ( !(self::$ins instanceof self) ) { // 是否是自身的实例
				self::$ins = new self();
			}
			
			return self::$ins;
		}
		
		/**
		 * 获取 购物车
		 * @return {Array} 购物车信息
		 */
		public static function getCar() {
			// 把购物车的单例对象放到session中
			
			// 判断session中是否存在购物车的实例
			// 购物车不存在 或者 存储的cart类不是 当前类的实例
			if ( !isset($_SESSION['cart']) || !($_SESSION['cart'] instanceof self) ) {
				$_SESSION['cart'] = self::getIns(); 
			}  
			
			return $_SESSION['cart'];
		}
		
		/**
		 * 添加商品
		 * @param {Int} $goods_id 商品id
		 * @param {String} $goods_name 商品名称
		 * @param {Float} $shop_price 单个商品价格
		 * @param {Int} $shop_num 购买的个数  
		 */
		public function addItem( $goods_id, $goods_name, $shop_price, $shop_num ) {
			
		}
	}

	
//	var_dump(CatrTool::getCar());
	
?>