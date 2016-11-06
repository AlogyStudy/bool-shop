<meta charset="UTF-8"/>
<?php

	define('ACC', true);
	
	require('../include/init.php');
	
	$data = array();
	
	$data['cat_name'] = isset($_POST['cat_name']) ? $_POST['cat_name'] : ''; 
	$data['parent_id'] = isset($_POST['parent_id']) ? $_POST['parent_id'] : ''; 
	$data['intro'] = isset($_POST['intro']) ? $_POST['intro'] : ''; 
	
	$cat_id = $_POST['cat_id'] + 0;
	
	/**
	 * 
	 * 一个栏目A, 不能修改成为A的子孙栏目的子栏目
	 * 
	 * 如果B是A 的子孙后代，则A不能成为B的子栏目
	 * B是A 的后台，则A是B的祖先 
	 * 因此，为A设定一个新的父栏目时，设为N。
	 * 可以先查N 的家谱树. N的家谱树，如果有A，则会形成闭环
	 * 
	 */	
	
	
	// 调用Model	
	$cat = new CateModel();
	
	$tree = $cat->getTree($data['parent_id']);
	
	$flag = true;
	foreach( $tree as $v ) {
		
		if ( $v['cat_id'] == $cat_id ) {
			$flag = false;
			break;
		}
		
	}
	
	if ( !$flag ) {
		echo $cat_id, '是', $data['parent_id'], '的祖先';
	}
	
	
	if ( $cat->update($data, $cat_id) ) {
		echo '修改成功';	
	}	else {
		echo '修改失败';
	}	
	
?>