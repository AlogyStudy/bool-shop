# 用户注册功能

## 页面分析

文件： `reg.php`
作用：展示注册表单

```
Model： N/A 
View：  zhuce.html
Controller： reg.php
```
-----


文件：`regAct.php`
作用：
* 接收注册表单的信息
* 判断数据
* 调用UserModel
* 把信息写入数据库

```
Model：UserModel
Controller： regAct.php
View：regres.html
```

# 理解Cookie


场景1：
需要看自己的注册资料，即用户表的自己的信息。但是别人不允许看我的资料，我也不能看别人的信息。
单单取出自己的信息.

场景2：
当前页面不是本站用户不能看.

-----

需要把信息存储在cookie中，共享。


从 客户端设置cookie，告知浏览器要设置cookie了。 (token) 
在客户端需要cookie的时候，从浏览器处获取 。


> 登陆时，是谁给谁信息

登陆时，从客户端设置信息到浏览器中存储。

> 验证登录时，是谁给谁信息

验证登录时，浏览器需要拿着信息到客户端验证，是浏览器端给客户端信息。

# cookie设置读取与销毁

cookie参数

`setcookie($name, $value, $expire, $path, $domain, $secure, $httponly)`


`setcookie()`常用参数

1: cookie key
2: cookie val
3: cookie 有效期
4: cookie 有效路径 

```
<?php
	
//	setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);

	setcookie('pink', 'p'); // cookie 随着浏览器的关闭，就失效

	setcookie('age', 23, time() + 15); // 第三个参数， cookie的生命周期，以时间戳为单位    (time()+15) 以当前时间加十五秒
	setcookie('school', 'MBA', time() + 3600); // 一个小时之后无效
	
	
	/**
	 * cookie 的作用域
	 * 一个页面设置cookie，
	 * 默认在其同级目录下，及其子目录下可以读取。
	 * 
	 * 如果想让cookie整个站有效果，可以在根目录下setcookie()
	 * 也可以使用第四个参数，来指定cookie生效路径
	 */
	
	setcookie('global', 'any where!', time() + 3600, '/');
	
	/**
	 * cookie 是不能够跨域名(否则存在安全问题)
	 * 
	 * 例如： sohu.com 的cookie，不能被发送到sina.com下使用。
	 * 但是可以在一个域名的子域名下使用.
	 * 可以使用第五个参数
	 */
	setcookie('key', 'val', time() + 3600, '/', '.linxingzhang.com'); // 这个cookie在 m.linxingzhang.com , wap.linxingzhang.com 中都可以使用.
	
?>
```

## cookie失效

加上一个负数的时间戳

```
setcookie('school', '', 0); // cookie设置成负数或者0
```
 
## cookie计数器

```
if ( !isset($_COOKIE['num']) ) {
	$num = 1;
	setcookie('num', $num);
} else {
	$num = $_COOKIE['num'];
	setcookie('num', $num+1);
}

echo '这是你的第' . $num . '次访问';

```


## 浏览历史

```
<?php


	/**
	 * 浏览历史
	 */
	
	$id = isset($_GET['id']) ? $_GET['id'] : 0;

	$uri = $_SERVER['REQUEST_URI'];
	
	// cookie只能存放字符串，数字，不能存储数组，资源这样的多维数据.
	// 把uri放入cookie里
//	setcookie('history', array($uri));

	if ( !isset($_COOKIE['history']) ) { // 第一次访问
		$his[] = $uri;
	} else { // 第n次访问
		$his = explode(',', $_COOKIE['history']);		 
		array_unshift($his, $uri);
		$his = array_unique($his);
		// 最多十条
		if ( count($his) >= 10 ) {
			array_pop($his);
		}
		
	}
	setcookie('history', implode(',', $his));
?>

<p>
	<a href="lookHis.php?id=<?php echo $id-1; ?>">上一页</a>
</p>

<p>	
	<a href="lookHis.php?id=<?php echo $id+1; ?>">下一页</a>
</p>

<ul>
	<li>浏览历史</li>
	<?php foreach( $his as $v ) {?>
		<li><?php echo $v;?></li>
	<?php };?>
</ul>
```


# Session

场景：
cookie 由浏览器带着，如果被篡改了， 如何做.
cookie 往往用来记住用户名，浏览历史，等安全性要求不高的地方.

使用session. 给浏览器端一个凭证，数据存储客户端.

## 基本使用 

设置session

```
session_start(); // 开启session
	
$_SESSION['user'] = 'pink';

```

读取session

```
echo $_SESSION['user'];
```

session 中设置的值存储的位置配置的地方在`php.ini`中的`session.save_path`.
其中的`session_id` 是无规律的`token`给浏览器的凭证.

## session详细

1. 无论是`创建`，`修改`,`销毁`.都需要`session_start()`
2. 一旦`session_start()`之后，`$_SESSION`就可以自由的设置，删除，修改。（即：当成`普通数组来操作`,而cookie只能通过`setcookie()`来进行）

> 创建

```
<?php

session_start();
$_SESSION['user'] = 'pink';

?>
```

> 修改

```
<?php

session_start();
$_SESSION['user'] = 'tan';

?>
```

> 销毁

```
<?php
session_start();
unset($_SESSION['user']);
?>
```

1. 可以单独销毁某个单元 ，即把$_SESSION数组某一个单元`unset()`
	unset($_SESSION['user']);
	
2. 可以把整个$_SESSION销毁
	$_SESSION = array(); // 临时存储的文件中的内容不存在 
	
3. 利用函数把箱子整体清空
	session_unset($_SESSION); // 临时存储的文件中的内容不存在

4. 把文件销毁.
	session_destroy();


## session 的生命周期

一个session，有2方面的数据共同发挥作用
1. 客户端的cookie
2. 服务器端的session文件

删除也是要从这两个方面去删除	

在php.ini 中， `session.cookie_lifetime = 15`; // 控制sessionid的cookie的声明周期，以秒为单位

	
注意: 如果用户修改cookie，让cookie的生命周期为1年.也无法判断。
1. $_SESSION['time'] = 登陆时的时间戳
2. 检验session的开启时间


## session路径

session的有效，取决于cookie，cookie在哪儿有效，session自然就能读到.

在 php.ini中， 指定了session的cookie的有效路径是`/` 路径：`session.cookie_path = '/'`
无论session在多深的目录下设置，而session在整站有效果.


## session存储类型

cookie 只能存储字符串，数字这样的标量数据.
session可以存储数组/对象（除了资源型，其它7中类型都可以）

注意：如果把对象存储到session里，那么另一个读取session的页面，也必须有此对象的`类声明` 否则从session分析出一个对象，却没有与之对应的类，则会提示`__PHP_Incomplete_Class`



# 记住用户名

```
<?php
	// 记住用户名
	if ( isset($_POST['remember']) ) {
		setcookie('remuser', $u, time() + 14 * 24 * 3600);
	} else {
		setcookie('remuser', '', 0);
	}
?>
```

