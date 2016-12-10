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

	// 不存在cat_id , 返回首页
	if ( empty($category) ) { 
		header('location: index.php');
		exit;
	}
	
	/********** 计算分页   **********/ 
	$goodsModel = new GoodsModel();
	$total = $goodsModel->catGoodsCount($cat_id);
	
	$perpage = 2; // 每页取 2 条
	
	// 限制最大页数
	if ( $page > ceil($total / $perpage) ) {
		$page = 1;
	}
	
	$offset = ($page - 1) * $perpage; // 计算偏移
	$pageTool = new PageTool((int)$total, $page, $perpage);
	$pagecode = $pageTool->show(); 
	
	/********** 计算分页   **********/ 
	
	// 取出树状导航
	$cats = $cat->select(); // 获取所有子孙树
	$sortCats = $cat->getCateTree($cats, 0, 1); // 获取家谱树

	// 取出面包屑导航  [需要cate_id] (指定栏目下的家谱树)
	$nav = $cat->getTree($cat_id);
	
	// 栏目下的商品  [需要cate_id]
	$goodsList = $goodsModel->catGoods($cat_id, $offset, $perpage);

	include(ROOT . 'view/front/lanmu.html');
?>