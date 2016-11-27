<?php

	defined('ACC') || exit('Acc Deined');
	
	class UserModel extends Model {
		
		protected $table = 'user'; // 表名
		protected $pk = 'user_id'; // 主键
		protected $fields = array('user_id', 'username', 'email', 'passwd', 'regtime', 'lastlogin'); // 字段名
		
		protected $_valid = array( 
			array('username', 1, '用户名不能为空', 'require'),
			array('username', 0, '用户名必须在4-16个字符', 'length', '4,16'),
			array('email', 1, 'emial不能为空', 'require'),
			array('email', 1, 'emial格式不正确', 'emial'),
			array('passwd', 1, 'passwd不能为空', 'require'),
			array('passwd', 0, 'passwd必须在6-20个字符', 'length', '4,20')
		);
		
		protected $_auto = array(
			array('regtime', 'function', 'time')
		);
		
		
		/**
		 * 注册用户
		 * @param {Array} 注册收集数据
		 * @return {Boolean} 注册是否成功
		 */
		public function reg( $data ) {
			if ( $data['passwd'] ) {
				$data['passwd'] = $this->encPasswd($data['passwd']);
			}	
			
			return $this->add($data);
		}
		
		/**
		 * 加密密码
		 * @param {String} $pass  待加密的密码 
		 * @return {String} 加密的密码
		 */
		protected function encPasswd( $pass ) {
			return md5($pass);
		}
		
		/**
		 * 检查用户是否存在
		 * @param {String} $username 用户名
		 */
		public function checkuser( $username ) {
			
			$sql = "select count(*) from " . $this->table . " where username='" . $username ."'";
			
			return $this->db->getOne($sql); 
			
		} 
		
	} 

?>