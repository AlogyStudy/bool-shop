<?php

	// file db.class.php
	// 数据库类
	
	abstract class Db {
		/**
		 * 连接服务器
		 * @params {String} $h 服务器地址 
		 * @params {String} $u 用户名 
		 * @params {String} $p 密码
		 * @return {Boolean}  
		 */
		public abstract function connect($h, $u, $p);
		
		/**
		 * 发送查询
		 * @params {String} $sql 查询的SQL语句
		 * @reutrn {mixed} --> Boolean/Resource  
		 */
		public abstract function query($sql);
		
		/**
		 * 查询多行数据
		 * @params {String} $sql 查询的SQL语句
		 * @return {mixed} --> Array/Boolean
		 */
		public abstract function getAll($sql);

		/**
		 * 查询单行数据
		 * @params {String} $sql 查询的SQL语句
		 * @return {mixed} --> Array/Boolean
		 */
		public abstract function getRow($sql);

		/**
		 * 查询单个数据
		 * @params {String} $sql 查询的SQL语句
		 * @return {mixed} --> Array/Boolean
		 */
		public abstract function getOne($sql);
		
		/**
		 * 自动拼接SQL语句 insert/update
		 * @params {String} $table 表名
		 * @params {Array} $data 插入的数据
		 * @params {String} $act 执行的方法
		 * @params {String} $where 执行条件
		 * @return {Boolean}
		 * 
		 * insert: 
		 * autoExecute('user', array('username' => 'zf', 'emial' => 'zf@qq.com'), 'insert');
		 * 形成: insert into user (username,email) values('zf', 'zf@qq.com');
		 * 
		 * update:
		 * autoExecute('user', array('username'=>'zf'), 'update', 'id=1');
		 * update user set username = 'zf' where id = 1;
		 */
		
		public abstract function autoExecute($table, $data, $act='insert', $where='');
		
	}

?>