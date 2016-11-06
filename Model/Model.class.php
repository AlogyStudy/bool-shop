<?php

	// 所有类的基类

	class Model {
		
		protected $table = NULL; // model所控制的表
		protected $db = NULL; // 引入的MySql对象
		
		protected $pk = ''; // 主键
		
		public function __construct() {
			$this->db = Mysql::getIns();
		}
		
		public function table( $table ) {
			$this->table = $table;
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
			
			$res = $this->db->autoExecute($this->table, $data, 'update', 'where ' . $this->pk . '=' . $id);
			
			if ( $res ) {
				$this->db->affected_rows($sql);
			} else {
				false;
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