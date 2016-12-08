<?php

	define('ACC', true);
	
	require('./include/init.php');
	
	
	$cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] + 0 : 0;
	$page = isset($_GET['page']) ? $_GET['page'] + 0 : 1; // 默认第一页
	
	// $page page 不可能小于 1 , 不可能为负数
	if ( $page < 1 ) {
		$page = 1;
	}
	
	$cat = new CateModel();
	$category = $cat->find($cat_id);

	/********** 计算分页 **********/ 
	$perpage = 2; // 每页取 2 条
	$offset = ($page - 1) * $perpage; // 计算偏移
	/********** 计算分页 **********/ 
	
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
	$goodsList = $goods->catGoods($cat_id, $offset, $perpage);
	
	
	include(ROOT . 'view/front/lanmu.html');
?>