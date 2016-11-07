<?php

	define('ACC', true);
	require('../include/init.php');
	
	/**
	 * 实例化GoodsModel
	 * 调用select
	 * 循环显示在view上
	 */	
	
	$goods = new GoodsModel();
	$goodslist = $goods->getGoods();
	
	
	
	include(ROOT . 'view/admin/templates/goodslist.html');

?>