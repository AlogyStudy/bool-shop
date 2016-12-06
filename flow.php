<?php

	/**
	 * 购物流程页面
	 * 商城的核心功能
	 */
	 
	define('ACC',true);
	require('./include/init.php');

	
	$cat = isset($_GET['cat']) ? $_GET['cat'] : 'buy'; // 默认动作， buy
	
	$cart = CatrTool::getCar(); // 购物车实例
	$goods = new GoodsModel(); // 商品实例
	
	if ( $cat == 'buy' ) { // 购买商品, 把商品加入购物车
		$goods_id = isset($_GET['goods_id']) ? $_GET['goods_id'] + 0 : 0;
		$num = isset($_GET['num']) ? $_GET['num'] + 0 : 1;
	
		if ( $goods_id ) { // $goods_id 为true，把商品放入购物车中
			$g = $goods->find($goods_id); // 获取商品信息
			// 存在商品
			if ( !empty($g) ) { // 是否查询到商品
				
				// 判断商品是否在回收站 // $g['is_delete']
				// 此商品是否已下架 // $g['is_on_sale']
				if ( $g['is_delete'] == 1 || $g['is_on_sale'] == 0 ) {
					$msg = '此商品不能购买, 在回收站或者已经下架';
					include(ROOT . 'view/front/msg.html');
					exit;					
				}
				
				// 把商品加入购物车
				$cart->addItem($goods_id, $g['goods_name'], $g['shop_price'], $num); // 商品添加到购物车
				
				// 此商品是否超出库存
				$items = $cart->all(); // 假设库存足够.
				if ( $items[$goods_id]['num'] > $g['goods_number'] ) {
					
					// 库存不够，加入购物车中的商品 取消
					$cart->decNum($goods_id, $num);
					
					$msg = '此商品库存不足';
					include(ROOT . 'view/front/msg.html');
					exit; 
				}
								
			}	
		}
		
		$items = $cart->all(); // 取出购物车
		
		if ( empty($items) ) { // 如果购物车为空，返回首页
			header('Location: index.php');
			exit;
		}
		
		// 取出购物车中的详细信息
		$items = $goods->getCarGoods($items);
		
		// 本店价格
		$total = $cart->getPrice(); // 获取购物车中的商品总价格
		
		// 市场价格
		$market_total = 0.0;
		foreach( $items as $v ) {
			$market_total += $v['market_price'] * $v['num'];
		}
		
		// 剩余价格
		$discount = $market_total - $total;
		// 剩余比例 ， 比例 .
		$rate = round(100 * ($discount / $market_total), 2);
		
		// 展示添加的商品
		include(ROOT . 'view/front/jiesuan.html');
		
	} else if ( $cat == 'clear' ) {
		
		$cart->clearItem();
		$msg = '购物车已经清空';
		include(ROOT . 'view/front/msg.html');
		
	} else if ( $cat == 'tijiao' ) {
		
		$items = $cart->all();
		
		// 取出商品信息 
		$items = $goods->getCarGoods($items);
		
		$total = $cart->getPrice(); // 总价格
		
		$market_total = 0.0;
		foreach( $items as $v ) {
			$market_total += $v['market_price'] * $v['num'];
		}
		
		$discount = $market_total - $total;
		$rate = round(100 * $discount / $total, 2); 
		
		include(ROOT . 'view/front/tijiao.html');
	} else if ( $cat == 'done' ) {
		// 订单入库
		
		/**
		 * 从 表单中 搜集 数据 , 从购物车 读取 总价格等信息 , 写入 `orderinfo` 表
		 */
		 
//Array ( 
//[zone] => 厦门 
//[reciver] => linx 
//[email] => 1129507496@qq.com 
//[address] => 福建厦门湖里区 
//[zipcode] => 365100 
//[tel] => 8795215 
//[mobile] => 13164889430 
//[building] => 建筑 
//[best_time] => 下午 
//[pay] => 4 
//[x] => 53 
//[y] => 6 
//[step] => done
//)
		 		 
		$orderInfo = new OrderInfoModel(); // 订单模型
		
		// 自动验证
		if ( !$orderInfo->_validate($_POST) ) {
			// 数据检验，不通过.
			$msg = implode($orderInfo->getError());
			include(ROOT . 'view/front/msg.html');
			exit;
		};
	
		// 自动过滤
		$data = $orderInfo->_facade($_POST);
				
		// 自动填充
		$data = $orderInfo->_autoFill($data);
		
		// 写入总金额
		$data['order_amount'] = $cart->getPrice();
		
		// 写入用户名,从session读取
		$data['user_id'] = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; // 没有读取到匿名
		$data['username'] = isset($_SESSION['username']) ? $_SESSION['username'] : '匿名'; // 没有读取到匿名
	
		// 写入订单号
		$order_sn = $data['order_sn'] = $orderInfo->orderSn();
		
		// 写入数据库		
		if (!$orderInfo->add($data)) {
			// 订单失败
			$msg = '下订单失败';
			include(ROOT . 'view/front/msg.html');
			exit;
		};		
		
		
		// 获取 order_id
		$order_id = $orderInfo->insert_id();
		
		// 把订单的商品写入数据库
		/**
		 * 1个订单中有N个商品，可以循环写入`ordergoods` 表
		 */
		$items = $cart->all(); // 返回购物车中所有商品
		
		
		// orderGoods 操作model
		$orderGoods = new OrderGoodsModel();
		
		// 循环订单中的商品，写入 `ordergoods`表	
		$cnt = 0;
		foreach ( $items as $k=>$v ) {
			
			$data = array();
			
			
			$data['order_id'] = $order_id;  
			$data['order_sn'] = $order_sn;
			$data['goods_id'] = $k;
			$data['godos_name'] = $v['name'];
			$data['goods_number'] = $v['num'];
			$data['shop_price'] = $v['price'];
			$data['subtotal'] = $v['price'] * $v['num']; 
			
			// 写入`ordergoods`表
			if ( $orderGoods->addOG($data) ) {
				$cnt += 1; // 写入一条 OG 成功，
				// 一个订单有N条商品, 必须N条商品，都插入成功，才算订单插入成功.
			}
			
		}
		
		// 判断是否全部写入成功
		if ( count($items) != $cnt ) { // 购物车中的商品数量没有全部入库成功
			// 撤销此订单
			
		}
				
		// 把商品的数量减少
		
		// 清空购物车
		
		
	} 

?>


