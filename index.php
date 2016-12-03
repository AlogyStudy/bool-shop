<?php

	define('ACC', true);
	
	require('./include/init.php');
	
	// 取出5条新品
	$goods = new GoodsModel();
	
	$newList = $goods->getNew(5); // 新品
	$ladies = $goods->getNew(6, "cat_id=5 or cat_id=6"); // 获取女装
	$man = $goods->getNew(6, "cat_id=2 or cat_id=3"); // 获取男装
	
	// 取出指定栏目的商品
	$female_id = 4; // 女式
	$feList = $goods->catGoods($female_id);
	
	$man_id = 1; // 男士
	$manList = $goods->catGoods($man_id);
	
	include(ROOT . 'view/front/index.html');
?>