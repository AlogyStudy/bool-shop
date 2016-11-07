<?php

	// 所有类的基类

	class Model {
		
		protected $table = NULL; // model所控制的表
		protected $db = NULL; // 引入的MySql对象
		
		protected $pk = ''; // 主键
		
		protected $fields = array(); // 存储字段
		
		protected $_auto = array(); // 需要自动填充的字段
		
		public function __construct() {
			$this->db = Mysql::getIns();
		}
		
		public function table( $table ) {
			$this->table = $table;
		}
		
		/**
		 * 自动过滤 
		 * 格式化数组
		 * 清除掉不用的单元，留下与表中的字段对应的单元.
		 * @param {Array} $arr 格式化之前的数组
		 * 循环数组，分别判断其key是否是表的字段.
		 * 
		 * 表的字段可以desc表名来分析
		 * 也可以手动写好.
		 * 以TP为例，两者都行.
		 * @return {Array} 过滤之后的数组
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
		
		/**
		 * 添加数据
		 * @params {Array} $data 添加数据的数组
		 * 关联数组
		 * 键 --> 表中的列
		 * 值 --> 表中的值
		 * @return {Boolean} 返回添加是否成功	
		 */
		public function add( $data ) {
			
			return $this->db->autoExecute($this->table, $data);
			
		}
		
		/**
		 * 删除栏目
		 * @param {Int} $cat_id 删除的id; 根据 主键 删除
		 * @return {Mixin} 返回删除是否成功，影响的行数. 
		 */
		public function delete( $id ) {
			
			$sql = "delete from " . $this->table . " where " . $this->pk ."=" . $id;
			
			if ( $this->db->query($sql) ) {
				return $this->db->affected_rows($sql);
			} else {
				false;
			}
			 
		}
	
		/**
		 *  更改数据
		 * @param {Array} $data 更改的数据
		 * @param {Int} $id 主键
		 * @return {Int} 影响函数
		 */
		
		public function update( $data, $id ) {
			
			$res = $this->db->autoExecute($this->table, $data, 'update', ' where ' . $this->pk . '=' . $id);
			
			if ( $res ) {
				return $this->db->affected_rows();
			} else {
				return false;
			}
			
		}
		
		/**
		 * 获取表中的所有数据
		 * @return {Array} 返回查询的所有数据
		 */
		
		public function select() {
			
			$sql = "select * from " . $this->table;
			
			return $this->db->getAll($sql);
			
		}
		
		/**
		 * 根据主键 取出一行数据
		 * @param {Int} 主键
		 * @return {Array} 主键所在的数据   
		 */
		
		public function find( $id ) {
			
			$sql = "select * from " . $this->table . " where " . $this->pk . "=" . $id;
			
			return $this->db->getRow( $sql );
			
		}
		
	}

?>