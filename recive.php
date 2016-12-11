<?php
	
	/**
	 * 在线支付的返回信息接收
	 */

	define('ACC', true);
	require('./include/init.php');
	
	print_r($_POST);
/*
	Array ( 
		[v_oid] => OI20161211743801 
		[v_pstatus] => 20 
		[v_pstring] => 支付完成 
		[v_pmode] => 工商银行 
		[v_md5str] => 658B07BD92E0F3D259C8EED69982856D 
		[v_amount] => 42 
		[v_moneytype] => CNY 
		[remark1] => 
		[remark2] => 
	)
*/

	// 返回过来的md5 加密的是通过
	// v_oid  v_pstatus v_amount v_moneytype key 组成
	
	$v_oid = $_POST['v_oid'];
	$v_pstatus = $_POST['v_pstatus'];
	$v_amount = $_POST['v_amount'];
	$v_moneytype = $_POST['v_moneytype'];
	$key = '#(%#WU)(UFGDKJGNDFG';
	$v_md5str = $_POST['v_md5str'];
	
	$md5info = strtoupper( md5($v_oid . $v_pstatus . $v_amount . $v_moneytype . $key) );
	
	// 对比 计算后的 md5info 和 表单中的 v_md5str
	if ( $md5info != $v_md5str ) { // 支付失败
		$msg = $_POST['v_pstring'] . '失败';
		include(ROOT . 'view/front/msg.html');
		exit; 
	} 
	
	
	// 支付成功
	// 执行SQL语句，把订单号 对应的订单改为 已支付
	echo $_POST['v_oid'];
	
?>