<?php

	define('ACC', true);
	
	require('./include/init.php');
	
	
	$cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] + 0 : 0;
	
	$cat = new CateModel();
	$category = $cat->find($cat_id);
	
	// 不存在cat_id , 返回首页
	if ( empty($category) ) { 
		header('location: index.php');
		exit;
	}
	
	// 取出树状导航
	$cats = $cat->select(); // 获取所有子孙树
	$sortCats = $cat->getCateTree($cats, 0, 1); // 获取家谱树
		
		
	// 取出面包屑导航  [需要cate_id] (指定栏目下的家谱树)
	$nav = $cat->getTree($cat_id);
	
	// 栏目下的商品  [需要cate_id]
	$goods = new GoodsModel();
	$goodsList = $goods->catGoods($cat_id);
	
	
	include(ROOT . 'view/front/lanmu.html');

?>