
# 用户注册功能

## 页面分析

文件： reg.php
作用：展示注册表单

Model： N/A 
View：  zhuce.html
Controller： reg.php

-----


文件：regAct.php
作用：
* 接收注册表单的信息
* 判断数据
* 调用UserModel
* 把信息写入数据库


Model：UserModel
Controller： regAct.php
View：regres.html


> 用户注册注意点

1. 各个字段不能为空
2. 用户名不能重复
3. 密码MD5加密
4. 自动填充
5. 自动过滤
 

# 理解cookie

场景：
需要看自己的注册资料，即用户表的自己的信息。但是别人不允许看我的资料，我也不能看别人的信息。




