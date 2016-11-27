<meta charset="UTF-8" />
<?php

	define('ACC', true);
	require('../include/init.php');
	
//	$data['goods_name'] = trim($_POST['goods_name']);
//		
//	if ( $data['goods_name'] == '' ) {
//		echo '商品名不能为空';
//		exit;
//	}	
//	$data['goods_sn'] = trim($_POST['goods_sn']); 
//	$data['cat_id'] = $_POST['cat_id'] + 0;
//	$data['shop_price'] = $_POST['shop_price'] + 0;
//	$data['market_price'] = $_POST['market_price'] + 0;
//	$data['goods_desc'] = isset($_POST['goods_desc']) ? trim($_POST['goods_desc']) : '';
//	$data['goods_weight'] = $_POST['goods_weight'] * $_POST['weight_unit'];
//	$data['goods_number'] = $_POST['goods_number'] + 0;
//	$data['is_best'] = isset($_POST['is_best']) ? 1 : 0;
//	$data['is_new'] = isset($_POST['is_new']) ? 1 : 0;
//	$data['is_hot'] = isset($_POST['is_hot']) ? 1 : 0;
//	$data['is_on_sale'] = isset($_POST['is_on_sale']) ? 1 : 0;
//	$data['keywords'] = isset($_POST['keywords']) ? trim($_POST['keywords']) : '';
//	$data['goods_brief'] = isset($_POST['goods_brief']) ? trim($_POST['goods_brief']) : '';  
//	
//	$data['add_time'] = time();

	$goods = new GoodsModel();
	
	$_POST['goods_weight'] *= $_POST['weight_unit'];
	
	$data = array();
	$data = $goods->_facade($_POST); // 自动过滤
	$data = $goods->_autoFill($data); // 自动填充
			
	if ( !$goods->_validate($data) ) {
		echo '数据不合法<br />';
		echo implode(',', $goods->getError()),'<br />';	
	}
	
	// 添加自动商品货号
	// 规则：BL + 时间戳 + 随机数
	if ( empty($data['goods_sn']) ) { 
		$data['goods_sn'] = $goods->createSn(); 
	}
	
	
	// 上传图片
	$upTool = new UpTool();
	$ori_img = $upTool->up('ori_img');
	
	// 写入数据库
	if ( $ori_img ) {
		$data['ori_img'] = $ori_img; 
	}
	
	// 生成 中等的缩略图 300 * 400
	// 需要根据定义的规则，规定 缩略地址
	// exp: aa.jpeg -> goods_aa.jpeg;
	if ( $ori_img ) { // 原始图存在的情况下，生成缩略图和中等图片
	
		$ori_img = ROOT . $ori_img; // 加上绝对路径
		$goods_img = dirname($ori_img) . '/goods_' . basename($ori_img);
		
		if ( ImageTool::thumb($ori_img, $goods_img, 300, 400) ) {
			$data['goods_img'] = str_replace(ROOT, '', $goods_img);
		} 
				
		// 生成浏览时使用的缩略图  160 * 220
		// exp: aa.jpeg -> thumb_aa.jpeg;
		$thumb_img = dirname($ori_img) . '/thumb_' . basename($ori_img);
		if ( ImageTool::thumb($ori_img, $thumb_img, 160, 220) ) {
			$data['thumb_img'] = str_replace(ROOT, '', $thumb_img);		
		}
	
	}
	

	// 商品是否发布成功
	if ( $goods->add($data) ) {
		echo '商品发布成功';
	}	else {
		echo '商品发布失败';
	}
	
?>