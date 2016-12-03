<?php
	
	defined('ACC') || exit('ACC Denied');
	
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
		 * @return {Array} $id栏目一下的子孙树
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
		 * 查询子栏目
		 * @param {Int} $id 查询当前栏目的子栏目
		 * @return {Array} $id栏目下的子栏目
		 */
		public function getSon( $id ) {
			
			$sql = "select cat_id, cat_name, parent_id from " . $this->table ." where parent_id=" . $id;
			
			return $this->db->getAll($sql);
			
		}
		
		/**
		 * 家谱树
		 * @param {Int} $id 查询当前id的家谱
		 * @return {Array} $id 栏目的家谱树
		 */
		public function getTree( $id = 0 ) {
				
			$tree = array();
			$cats = $this->select(); 
			
			while ( $id > 0 ) {
				
				foreach ( $cats as $v ) {
					
					if ( $v['cat_id'] == $id ) {
						$tree[] = $v;
						$id = $v['parent_id'];
						break;
					}
					
				}	
				
			}
			
			return array_reverse($tree);
			
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
		 * 根据主键 取出一行数据
		 * @param {Int} 主键
		 * @return {Array} 主键所在的数据   
		 */
		public function find( $cat_id ) {
			
			$sql = "select * from " . $this->table . " where cat_id=" . $cat_id;
			
			return $this->db->getRow($sql);
			
		}	
		
		/**
		 *  更改数据
		 * @param {Array} 更改的数据
		 * @param {Int} 主键
		 * @return {Boolean} 更改是否数据成功
		 */
		public function update( $data, $cat_id = 0 ) {
			
			$this->db->autoExecute($this->table, $data, 'update', ' where cat_id='. $cat_id);
			
			return $this->db->affected_rows();
			
		}
		
	} 

?>