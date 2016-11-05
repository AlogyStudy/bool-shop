<?php

	define('ACC', true);
	
	require('../include/init.php');
	
	$cat = new CateModel();
	$catlist = $cat->select();
	
	$catlist = $cat->getCateTree($catlist, 0);
	
	include(ROOT . '/view/admin/templates/cateadd.html');

?>