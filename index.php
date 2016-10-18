<?php

	/**
	 * 所有由用户直接访问到的这些页面，都得先加载init.php
	 */

	require('./include/init.php');
	
	$conf = conf::getIns();
	
	// 读取选项
	echo $conf->host; 
	echo $conf->user;
	
	var_dump($conf->template_dir);
	
	// 动态追加选项
	$conf->template_dir = 'D:/www/smarty';
	
	echo $conf->template_dir; 
	

?>