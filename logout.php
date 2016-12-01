<?php

	define('ACC', true);
	
	require('./include/init.php');
	
	// 退出登陆， 删除session
	session_start();
	session_destroy();
	
	$msg = '退出成功';
	include(ROOT . 'view/front/msg.html');
	
?>
