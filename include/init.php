<?php

/*
file init.php
作用：框架初始化
 */

  
// 初始化当前的绝对路径

// echo substr(str_replace('\\', '/', __FILE__), 0, -8);
// 换成`/`正斜线，因为：win和linux都支持正斜线，而linux不支持反斜线.
define('ROOT',dirname(dirname(str_replace('\\', '/', __FILE__))) . '/');
define('DEBUG', true);

// 引入配置文件
require(ROOT . 'include/db.class.php'); // 数据库类
require(ROOT . 'include/conf.class.php'); // 配置文件类
require(ROOT . 'include/log.class.php'); // 日志类
require(ROOT . 'include/lib_base.php'); // 基础函数


// 过滤参数，用递归的方式 过滤 $_GET,$_POST, $_COOKIE 
$_GET = _addslashes($_GET);
$_POST = _addslashes($_POST);
$_COOKIE = _addslashes($_COOKIE);



// 设置报错级别
if ( defined('DEBUG') ) {
	error_reporting(E_ALL);
} else {
	error_reporting(0);
}

?>
