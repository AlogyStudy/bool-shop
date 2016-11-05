<?php

	define('ACC', true);
	
	require('../include/init.php');
		
	/**
	 * file cateAction 
	 * 接收cateadd.php 表单页面发送过来的数据,并调用Model，把数据写入数据库 
	 */
	
	// 收集数据
	// print_r($_POST);
	
	// 检验数据
	$data = array();
	
	$data['cat_name'] = $_POST['cat_name'];
	$data['intro'] = $_POST['intro'];
	$data['parent_id'] = $_POST['parent_id'];

	// 实例化Model
	// 并调用Model相关方法
	$cateModel = new CateModel();
	
	if ( $cateModel->add($data) ) {
		echo '栏目添加成功';
	} else {
		echo '栏目添加失败';
	}
	
?>