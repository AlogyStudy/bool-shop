<?php

	defined('ACC') || exit('ACC Denied');
	
	class OrderInfoModel extends Model {
		
		protected $table = 'orderinfo'; // 订单信息
		protected $pk = 'order_id'; // 订单信息 主键
		
		// 存储字段
		protected $fields = array(
			'order_id',
			'order_sn',
			'user_id',
			'username',
			'zone',
			'address',
			'zipcode',
			'reciver',
			'email',
			'tel',
			'mobile',
			'building',
			'best_time',
			'add_time',
			'order_amount',
			'pay'
		);		
		
		// 自动验证
		protected $_valid = array(
			array('reciver', 1, '收货人不能为空', 'require'),
			array('email', 1, 'email不能为空', 'require'),
			array('mobile', 1, '手机号不能为空', 'require'),
			array('email', 1, 'email非法', 'email'),
			array('pay', 1, '必须选择支付方式', 'in', '4,5') // 4 -- 在线支付 ， 5 -- 到付 		
		);
		
		// 自动填充
		protected $_auto = array(
			array('add_time', 'function', 'time')
		);
	
		/**
		 * 订单号
		 * 规则: OI + 时间戳  + 6位随机数
		 */	
		public function orderSn() {
			$sn = 'OI' . date('Ymd') . mt_rand(100000, 999999);
			
			$sql = "select count(*) from " . $this->table . " where order_sn='" . $sn . "'";
			
			// 是否存在$sn
			return $this->db->getOne($sql) ? $this->orderSn() : $sn;
				
		}
		
		/**
		 * 撤销订单
		 * @param {Int} $order_id 订单Id
		 * @return {Boolean} 
		 */
		public function invoke( $order_id ) {
			
			$this->delete($order_id); // 删除订单  `orderinfo`
 			
			$sql = "delete from ordergoods where order_id = " . $order_id; // 删除订单对应的商品 `ordergodos`
			
			return $this->db->query($sql);
			
		}
	}

?>