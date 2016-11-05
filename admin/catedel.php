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
	
	$cat = new CateModel();
	
	if ( $cat->delete($cat_id) ) {
		echo '删除成功'; 
	} else {
		echo '删除失败';
	}
	
	 

?>