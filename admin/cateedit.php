<meta charset="UTF-8"/>

<?php

	/**
	 * file cateedit.php
	 * 编辑栏目
	 * 
	 * 接收cat_id
	 * 	实例化Mdoel
	 * 取出栏目信息
	 * 展示栏目信息
	 */
	
	define('ACC', true);
	require('../include/init.php');


	$cat_id = $_GET['cat_id'] + 0;
	
	$cat = new CateModel();
	
	$cat_info = $cat->find($cat_id);
	
	// 查询无限级分类
	$catlist = $cat->select();
	$catlist = $cat->getCateTree($catlist, 0);

	include(ROOT . 'view/admin/templates/catedit.html');
	
?>