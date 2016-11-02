<?php

	require('./include/init.php');
	
	$test = new TestModel();
	$list = $test->select();
	
	include(ROOT . 'view/userlist.html');	
	
	
?>