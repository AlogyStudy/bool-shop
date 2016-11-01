<?php

	require('./include/init.php');
	
	$test = new TestModel();
	$list = $test->select();
	
	var_dump($test);
	
//	include(ROOT . 'view/userlist.html');	
	
	
?>