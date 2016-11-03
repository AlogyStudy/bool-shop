<meta charset="UTF-8" />

<?php

	require('./include/init.php');
	
	// 接收数据
	
	$data['catename'] = $_POST['catename'];
	$data['intro'] = $_POST['intro'];
	
	// 检测数据
	
	
	// 调用Model
	 
	$cateModel = new CateModel();
	
	if ( $cateModel->add($data) ) {
		$res = true;			
	} else {
		$res = false;
	}
	
	// 把结果展示View中.
	echo $res ? '成功' : '失败';
	
?>