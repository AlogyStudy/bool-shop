<meta charset="UTF-8"/>

<?php

	define('ACC', true);
	
	require('include/init.php');
	
	require(ROOT . 'tools/UpTool.class.php');
	
	$upTool = new UpTool();
	
	if ( $res = $upTool->up('pic') ) {
		echo $upTool->getErr();
		echo $res;
	} else {
		echo $upTool->getErr();
	}
	

?>