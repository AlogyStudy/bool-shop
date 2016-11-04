<?php
	
	defined('ACC') || exit('ACC Denied');
	
	/**
	 * file conf.class.php
	 * 配置文件读写类
	 */
	// 单例模式
	// 1. 同一性，每次读取都一样
	// 2. 只需读取一次.
	
	class Conf {
		
		protected static $ins = null;
		protected $data = array(); 
		
		final protected function __construct() {
			
			// 读取配置文件
			include(ROOT . 'include/config.inc.php');
			$this->data = $_CFG;			
			
		}
		
		final protected function __clone() {
			
		}
		
		public static function getIns() {
			
			if ( self::$ins instanceof self ) {
				return self::$ins;
			}
			
			return self::$ins = new self();
			
		}
		
		// 用魔术方法，读取data内的信息
		public function __get( $key ) { 
			if ( array_key_exists($key, $this->data) ) { // 判断键是否存在在
				return $this->data[$key];
			} else {
				return null;
			}
		}
		
		// 用魔术方法，在运行期，动态增加或改变配置选项
		public function __set( $key, $val ) {
			$this->data[$key] = $val;
		}
		
	}
	
?>