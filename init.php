<?php

/*
file init.php
作用：框架初始化
 */
 
// 过滤参数，用递归的方式 过滤 $_GET,$_POST, $_COOKIE 


// 设置报错级别
define('DEBUG', true);

if ( define('DEBUG') ) {
	error_reporting(E_ALL);
} else {
	error_reporting(0);
}

?>
