
# 框架搭建

* 路径信息的初始化
* 参数过滤：GET/POST
* 运行日志：运行中的错误信息，SQL信息记录下来
* 报错级别：开发状态一个级别，上下状态一个级别
* 数据库类
* 配置文件的读取 



# 知识点

数据库类 -- Y
报错级别 -- Y
参数过滤 -- N (递归)
运行日志 -- 要求把运行中的信息记录在文件上(文件操作) N
					日志按天形成目录存放 （目录创建）N
读取配置文件 -- 小项目，配置文件往往只放数据库信息，因此被数据库读取到，就行.
							现在配置文件信息，还要包括缓存信息，smarty的目录信息。
							要求：能被多个类的读取.


# 日志

后台栏目的增删改查								

QA:
一个栏目可以选择其子栏目做其父栏目.
		
QA:
一个栏目，有子栏目，就不允许删除.(父栏目删除，导致子栏目也一起删除)


# 商品增加

准备
1. 商品添加的表单模板 viwe + 商品添加表单页面的controller
2. 商品添加处理页面 goodsaddAct.php 
3. 负责添加商品到数据的goodsModel.php

流程
1. goodsadd.php 引入goodsadd.html 模板
2. goodsaddAct.php 分析数据
3. gact 页面引入 goodsmodel 的add方法
4. 判断结果


# 日志2

商品添加功能

1. 当字段多的时候，需要逐一从POST里接受字段，能否自动的把POST合理的字段自动取出.
合理的字段：表中的列名对应的POST字段.

例如：表中有字段为： 
goods_id, goods_name, goods_desc;
则会自动把$_POST 里 的几个字段拿出来.

2. catModel 里 和 goodsModel 里， 都有一个add方法，重复。
抽取到基类。 
CURD 操作放入基类中.


3. 字段的合法性，也能够自动判断.
自动验证


# 自动过滤

格式化POST数组，按表中的字段格式化数组.

```
/**
 * 格式化数组
 * 清除掉不用的单元，留下与表中的字段对应的单元.
 * @param {Array}
 * 循环数组，分别判断其key是否是表的字段.
 * 
 * 表的字段可以desc表名来分析
 * 也可以手动写好.
 * 以TP为例，两者都行.
 */
public function _facade( $arr = array() ) {
	
	$data = array();
	
	foreach( $arr as $key => $val ) {
		// $key 是否是表中的字段.
		if ( in_array($key, $this->fields) ) {
			$data[$key] = $val; 	
		}
		
	}
	
	return $data;
	
} 

```


# 自动完成

```
/**
 * 自动完成/自动填充
 * 把表中的需要值， 而 $_POST 中却没有 的值，赋值
 * 比如$_POST 中没有 `add_time`, 即商品时间.
 * @param {Array} $data POST提交的数组
 * @return {Array} 添加完成之后的数组
 */
public function _autoFill( $data ) {
	
	foreach ( $this->_auto as $k => $v ) {
		
		if ( !array_key_exists($v[0], $data) ) {
			switch ( $v[1] ) {
				
				case 'value' : 
					$data[$v[0]] = $v[2];
				break;
				
				case 'function' :
					$data[$v[0]] = call_user_func($v[2]);
				break;		
			}
		}
		
	}
	
	return $data;
	
}	
```

# 日志3

完善Model父类，实现非表中对应的字段自动删除，没有字段，自动赋值。(数据过滤，自动完成)



# 自动验证

TP中的自动验证(部分)

1. 必检字段
0. 有字段则检查，无此字段则不检查，如：性别
	 没有，不检，有必是男女之一
3. 如有且内容不为空，则检查，如：签名档，非空，则检查长度



# 文件上传

1. 表单项
2. $_FILES变量
3. PHP处理
4. 参数配置

-----

> 文件上传过程

1. 提交后，文件**自动**发到服务器上，形成一个**临时**文件(临时文件存在：$_FILES数据库的tmp目录下)
2. 在服务器上，只需要把临时文件移动到自己想要的位置就可以完成上传操作.
3. 使用`move_uploaded_file()` 移动文件.

文件名的文件信息.例如：文件名，文件大小。等，又在哪儿呢。

PHP形成临时文件后，还会形成`$_FILES`超级全局数组
数组中保存着文件的临时地址，临时名称，大小等信息。

临时文件什么时候消失：临时文件在接收的.php 文件结束后，就立即消失了。


注意点：

* 文件上传 必须是 `POST`
* from表单需要是声明：`enctype="multipart/form-data"`


计算机中的通信，离不开协议。你如何说，我怎么应。


> 文件上传参数

`php.ini` 中相关配置

`file_uploads` 是否允许HTTP文件上传
`upload_max_filesize` 所上传的文件的最大大小(字节)
`post_max_size` 设定POST数据所允许的最大大小(字节)
`upload_tmp_dir` 文件上传时存放文件的临时目录 
`max_execution_time` 脚本最大执行时间


## 多文件上传

`file` 控件不允许有默认值.

循环`$_FILES`数组.

多文件上传注意点：

```
array
  'pic' => 
    array
      'name' => 
        array
          0 => string '21鍏嬬殑鐏甸瓊--鎳夸竴.jpg' (length=26)
          1 => string '123.jpg' (length=7)
          2 => string '52680a04c932570a4eb90452ae286f11_b.jpg' (length=38)
      'type' => 
        array
          0 => string 'image/jpeg' (length=10)
          1 => string 'image/jpeg' (length=10)
          2 => string 'image/jpeg' (length=10)
      'tmp_name' => 
        array
          0 => string 'E:\wamp\tmp\php2668.tmp' (length=23)
          1 => string 'E:\wamp\tmp\php2679.tmp' (length=23)
          2 => string 'E:\wamp\tmp\php267A.tmp' (length=23)
      'error' => 
        array
          0 => int 0
          1 => int 0
          2 => int 0
      'size' => 
        array
          0 => int 75510
          1 => int 66912
          2 => int 351811
```

# 自动生成商品货号





# 订单表设计

1. 下订单，对应几条商品 (一对多的关系，需要2张表完成)
2.   
