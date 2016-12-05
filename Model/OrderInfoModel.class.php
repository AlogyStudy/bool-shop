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
		
		public function orderSn() {
			
		}
		
	}

?>