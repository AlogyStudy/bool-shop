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
	} 

?>