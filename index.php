<meta charset="UTF-8" />

<?php

	/**
	 * 所有由用户直接访问到的这些页面，都得先加载init.php
	 */

	require('./include/init.php');

	
	$mysql = Mysql::getIns();
	
	$t1 = $_GET['t1'];
	$t2 = $_GET['t2'];
	
//	$sql = "insert into test(t1, t2) values('$t1', '$t2')";

//	var_dump($mysql->autoExecute('test', $_GET, 'insert'));
	
	
	