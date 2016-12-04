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
	
	defined('ACC') || exit('ACC Denied');
	
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
		 * @param {Int} $id 商品主键
		 * @param {String} $name 商品名称
		 * @param {Float} $price 单个商品价格
		 * @param {Int} $num 购买的个数
		 *   
		 */
		public function addItem( $id, $name, $price, $num=1 ) {
			
			if ( $this->hasItem($id) ) { // 如果该商品已经存在，则直接加其数量
				$this->incNum($id, $num);
				return ;
			}
			
			// 利用 `goods_id` 作为数组的下标
			$item = array();
			$item['name'] = $name;
			$item['price'] = $price;
			$item['num'] = $num;
			
			$this->items[$id] = $item; // 二维数组
			return $this->items;
		}
		
		/**
		 * 清空购物车
		 */
		public function clearItem() {
			$this->items = array();
		} 
		
		/**
		 * 判断某商品是否存在
		 * @param {Int} $id 商品主键
		 * @return {Boolean} 是否存在该商品
		 */
		public function hasItem( $id ) {
			return array_key_exists($id, $this->items);
		} 
		
		/**
		 * 修改购物车的商品数量 
		 * @param {Int} $id 商品主键
		 * @param {Int} $num 当前主键修改后的商品数量
		 * @return {Boolean} 修改是否成功
		 */
		public function modNum( $id, $num=1 ) {
			// 判断是否存在该商品
			if ( !$this->hasItem($id) ) {
				return false;
			}
			
			// 存在该商品，修改商品数量
			$this->items[$id]['num'] = $num;
			return true;
		}
		
		/**
		 * 商品数量增加加
		 * @param {Int} $id 商品主键
		 * @param {Int} $num 商品自增个数
		 * @return {Boolean} 是否增加成功 
		 */ 
		public function incNum( $id, $num ) {
			// 判断是否存在该商品
			if ( !$this->hasItem($id) ) {
				return false;
			}
			
			$this->items[$id]['num'] += 1;
			return true;
		}
		
		/**
		 * 商品数量减键
		 * @param {Int} $id 商品主键
		 * @param {Int} $num 商品自减个数
		 * @return {Boolean} 是否减少成功
		 */
		public function decNum( $id, $num=1 ) {
			
			// 判断是否存在该商品
			if ( !$this->hasItem($id) ) {
				return false;
			}
			
			$this->items[$id]['num'] -= $num;
			
			// 如果减少为  小于 0, 删除该商品
			if ( $this->items[$id]['num'] <= 0 ) {
				$this->delItem($id);
			}
			
			return true;
		}
		
		/**
		 * 删除某个商品
		 * @param {Int} $id 商品主键
		 * @return {Boolean} 是否删除成功
		 */
		public function delItem( $id ) {
			unset($this->items[$id]);
		} 
		
		/**
		 * 查询购物车商品的种类 
		 * @return {Int} 返回存储购物车的数组单元个数
		 */
		public function getCnt() {
			return count($this->items);
		} 
		
		/**
		 * 查询购物车中商品个数
		 * @return {Int} 返回商品个数
		 */
		public function getNum() {
			
			if ( $this->getCnt() == 0 ) {
				return 0;
			}
			
			$sum = 0;
			foreach( $this->items as $item ) {
				$sum += $item['num'];
			}
			return $sum;
		} 
		
		/**
		 * 查询购物车中商品的总金额
		 * @return {Int} 总金额
		 */
		public function getPrice() {
			
			// 购物车中是空的
			if ( $this->getCnt() == 0 ) {
				return 0;
			}
			
			$price = 0.0;
			foreach( $this->items as $item ) {
				$price += $item['price'] * $item['num'];
			}
			
			return $price;
		} 
		
		/**
		 * 返回购物车中的所有商品
		 * @return {Array} 所有购物车的商品信息
		 */
		public function all() {
			return $this->items;	
		}
		
	}



/**
 测试结果 
	$cart = CatrTool::getCar();
	
	$add = isset($_GET['test']) ? $_GET['test'] : '';
	
	if ( $add == 'add' ) {
		$cart->addItem(10, 'xixi', 10000, 1);
		echo 'ok xixi';
	} else if ( $add == 'clear' ) {
		$cart->clearItem();
		echo 'qingchu ok';
	} else if ( $add == 'show' ) {
		print_r($cart->all());
		echo '<hr />';
		echo '共' . $cart->getCnt() . '种商品<br />';
		echo '共' . $cart->getNum() . '个商品<br />';
		echo '共' . $cart->getPrice() . '多少钱<br />';
	} else if ( $add == 'addpink' ) {
		$cart->addItem(1, 'pink', 100.23, 2);
		echo 'ok pink';
	} else {
		print_r($cart);
	}
**/	
	
?>