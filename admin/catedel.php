<meta charset="UTF-8"/>
<?php

	/**
	 * 
	 * 接受cat_id 
	 * 调用model
	 * 删除cat_id
	 * 
	 */
	
	define('ACC', true);
	
	require('../include/init.php');
	
	$cat_id = $_GET['cat_id'] + 0;
	
	/**
	 * 
	 * 判断该栏目是否有子栏目
	 * 
	 * 无限级分类3个基本应用
	 * 1. 查子栏目
	 * 2. 查子孙栏目
	 * 3. 查家谱树
	 * 
	 */
	
	$cat = new CateModel();
	
	$sons = $cat->getSon($cat_id);
	
	if ( !empty($sons) ) {
		exit('有子栏目，不允许删除');
	}
	
	if ( $cat->delete($cat_id) ) {
		echo '删除成功'; 
	} else {
		echo '删除失败';
	}

?>