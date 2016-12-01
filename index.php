<?php

	define('ACC', true);
	
	require('./include/init.php');
	
	session_start();
	include(ROOT . 'view/front/index.html');
	
?>