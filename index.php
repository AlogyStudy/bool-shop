<meta charset="UTF-8" />

<?php

	/**
	 * 所有由用户直接访问到的这些页面，都得先加载init.php
	 */

	require('./include/init.php');
	
	Log::write('基础');
	
	class Mysql {
		public function query ( $sql ) {
			// 查询
			// 记录
			Log::write($sql);
		}
	}

	$mysql = new Mysql();
	
	for ( $i=0; $i<1000; $i++ ) {
		$sql = "select goods_id, goods_name, shop_price from goods, select goods_id, goods_name, shop_price from goods,select goods_id, goods_name, shop_price from goods,select goods_id, goods_name, shop_price from goods,select goods_id, goods_name, shop_price from goods,select goods_id, goods_name, shop_price from goods,select goods_id, goods_name, shop_price from goods,select goods_id, goods_name, shop_price from goods,select goods_id, goods_name, shop_price from goods,select goods_id, goods_name, shop_price from goods,select goods_id, goods_name, shop_price from goods,select goods_id, goods_name, shop_price from goods,select goods_id, goods_name, shop_price from goods where goods_id=" . mt_rand(1, 1000);
		$mysql->query($sql);
		usleep(10000);
	}
	
	echo '执行完成';

?>