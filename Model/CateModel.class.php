<?php

	/**
	 * CateModel
	 */
	 
	class CateModel extends Model {
		
		protected $table = 'category';
		
		/**
		 * 添加数据
		 * @params {Array} 添加数据的数组
		 * 关联数组
		 * 键 --> 表中的列
		 * 值 --> 表中的值
		 * @return {Boolean} 返回添加是否成功	
		 */
		public function add( $data ) {
			
			return $this->db->autoExecute($this->table, $data, 'insert');
			
		}
		
		/**
		 * 获取表中的所有数据
		 * @return {Array} 返回查询的所有数据
		 */
		public function select() {
			
			$sql = "select cat_id, cat_name, parent_id from " . $this->table;
			
			return $this->db->getAll($sql);
			
		}
		
		/**
		 * 查询Cate子孙树 
		 * @param {Array} $arr 查询的所有数据 
		 * @param {Int} $id 
		 * @return $id栏目一下的子孙树
		 */
		public function getCateTree( $arr, $id = 0, $lev = 0 ) {
			
			$tree = array();
			
			foreach ( $arr as $v ) {
				
				if ( $v['parent_id'] == $id ) {
					$v['lev'] = $lev;
					$tree[] = $v;
					$tree = array_merge($tree, $this->getCateTree($arr, $v['cat_id'], $lev+1 ) );	
				}
				
			};			
				
			return $tree;
				
		}
		
		/**
		 * 删除栏目
		 * @param {Int} $cat_id 删除的id;
		 * @return {Boolean} 返回删除是否成功，影响的行数. 
		 */
		public function delete( $cat_id = 0 ) {
			
			$sql = "delete from " . $this->table . " where cat_id=" . $cat_id;
			
			$this->db->query($sql);
			
			return $this->db->affected_rows();
			
		}
		
		/**
		 * 
		 */
			
		
	} 

?>

