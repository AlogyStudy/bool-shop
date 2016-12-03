<?php

	/**
	 * 用户登录
	 */
	 
	define('ACC', true);
	
	require('./include/init.php');

	// 区分情况
	if ( isset($_POST['act']) == 'act_login') { // 点击登陆 按钮
		// 存储用户名，验证..
		$u = $_POST['username'];
		$p = $_POST['passwd'];
		
		// 检测,验证,核对用户名与密码
		$user = new UserModel();
		/**
		 * 调用自动检验功能
		 * 用户名是否为空
		 * 检验用户名 4-16字符之内
		 * 密码是否为空 
		 */
		if ( !$user->_validate($_POST) ) {
			$msg = implode('<br />', $user->getError());
			include(ROOT. 'view/front/msg.html');
			exit;
		}
		
		// 核对用户名，密码
		$row = $user->checkuser($u, $p);
		if (empty($row)) {
			$msg = '用户名密码不匹配';
		} else {
			$msg = '登陆成功';
			// 设置session
			
			$_SESSION = $row;
			
			// 记住用户名
			if ( isset($_POST['remember']) ) {
				setcookie('remuser', $u, time() + 14 * 24 * 3600);
			} else {
				setcookie('remuser', '', 0);
			}
		}
		
		include(ROOT . 'view/front/msg.html');
		exit;
	} else {
		// 准备登录
		$remuser = isset($_COOKIE['remuser']) ? $_COOKIE['remuser'] : '';
		include(ROOT . 'view/front/denglu.html'); 
	}

?>