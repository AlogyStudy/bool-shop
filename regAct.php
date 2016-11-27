<?php

	/**
	 * regAct.php
	 * 作用：接收用户注册的表单信息，完成注册
	 */
	
//	print_r($_POST);

	define('ACC', true);
	
	require('./include/init.php');
	
	$user = new UserModel();
	
	
	/**
	 * 调用自动检验功能
	 * 检验用户名 4-16字符之内
	 * emial检验
	 * passwd 不能为空
	 */
	if ( !$user->_validate($_POST) ) {
		$msg = implode('<br />', $user->getError());
		include(ROOT. 'view/front/msg.html');
		exit;
	}
	
	
	// 检验用户名是否存在已经存在
	if ( $user->checkuser($_POST['username']) ) {
		$msg = '用户名已经被注册';
		include(ROOT. 'view/front/msg.html');
		exit;		
	}
	
	// 自动填充
	$data = $user->_autoFill($_POST);
	
	// 过滤不必要的字段(自动过滤)
	$data = $user->_facade($data); 
	
	if ( $user->reg($data) ) {
		$msg = '用户注册成功';
	} else {
		$msg = '用户注册失败';
	}
	
	// 引入view
	include(ROOT . 'view/front/msg.html');
			
?>