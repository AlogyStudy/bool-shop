<?php
	
	define('ACC', true);
	
	require('../include/init.php');
	
		
	// 调用Model
	$cat = new CateModel();
	
	$catlist = $cat->select();
	
	$catlist = $cat->getCateTree($catlist, 0);
	
	include(ROOT . 'view/admin/templates/catelist.html');
	
?>