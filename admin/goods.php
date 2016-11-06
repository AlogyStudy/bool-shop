<meta charset="UTF-8"/>
<?php

	define('ACC', true);
	
	require('../include/init.php');
	
	/**
	 * 
	 * 接收goods_id
	 * 实例化goodsModel
	 * 调用find方法
	 * 展示商品信息
	 * 
	 */
	
	$goods_id = $_GET['goods_id'] + 0;
	
	$goods = new GoodsModel();
	
	$goodsInfo = $goods->find($goods_id);
	
	if ( empty($goodsInfo) ) {
		echo '商品不存在';
	}
	
	var_dump($goodsInfo);
	

?>