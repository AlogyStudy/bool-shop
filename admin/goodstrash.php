<meta charset="UTF-8"/>
<?php

	define('ACC', true);
	
	require('../include/init.php');


	if ( isset($_GET['act']) && $_GET['act'] == 'show' ) {
		// 打印所有的回收商品
		$goods = new GoodsModel();
		$goodslist = $goods->getTransh();
		
		include(ROOT . 'view/admin/templates/goodslist.html');
	} else {
		$goods_id = $_GET['goods_id'] + 0;
		
		$goods = new GoodsModel();
		
		if ( $goods->transh($goods_id) ) {
			echo '加入回收站成功';
		} else {
			echo '加入回收站移除失败';
		}
	}
	
	
	
?>