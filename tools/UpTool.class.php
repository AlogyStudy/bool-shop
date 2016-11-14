<?php
		
	/**
	 * 单文件上传类
	 * 
	 * 上传文件
	 * 配置允许的后缀
	 * 配置允许的大小
	 * 随机生成目录
	 * 随机生成文件名
	 * 
	 * 
	 * 获取文件后缀(方法)
	 * 获取文件的大小(方法)
	 * 判断文件的大小
	 * 
	 * 良好的报错的支持
	 */
	 
	defined('ACC') || exit('ACC Denied');	
	
	class UpTool {
		
		// 配置允许的后缀
		protected $allow_ext = 'jpg,jpeg,gif,bmp,png';
		
		// 配置文件属性大小
		protected $max_size = 1; // 1M, M为单位
		
		protected $file = NULL; // 文件信息 , 存储上传文件的信息
		
		protected $errno = 0; // 错误代码
		protected $error = array(
			0 => '无错误',
			1 => '上传文件超出系统限制',
			2 => '上传文件大小超出网页表单页面',
			3 => '文件只有部分被上传',
			4 => '没有文件被上传',
			6 => '找不到临时文件夹',
			7 => '文件写入失败',
			8 => '不允许的文件后缀',
			9 => '文件大小超出类的允许范围',
			10 => '创建目录失败',
			11 => '移动文件失败'
		); // 错误信息
		
		/**
		 * 上传文件
		 * @param {String} $key 文件上传的 `key`
		 * @return {Boolean} 是否上传成功
		 */
		public function up( $key ) {
			
			if ( !isset($_FILES[$key]) ) {
				return false;
			}
			
			$f = $this->getFile($key);
			// $f['name'], $f['tmp_name'] $f['error'] $f['size']
			
			// 检验上传是否成功
			if ( $f['error'] ) {
				$this->errno = $f['error'];
				return false;
			}
			
			// 检查后缀
			$ext = $this->getExt($f['name']);
			if ( !$this->isAllowExt($ext) ) {
				$this->errno = 8;
				return false;
			}
			
			// 检查大小
			if ( !$this->isAllowSize($f['size']) ) {
				$this->errno = 9;
				return false;
			}
			
			// 创建目录
			if ( !($dir = $this->mkDir()) ) {
				$this->errno = 10;
				return false;
			}
			
			// 生成随机文件名
			$newname = $this->randName() . '.' . $ext;
			
			$dir .= '/' . $newname; 
			
			// 移动
			if ( !move_uploaded_file($f['tmp_name'], $dir) ) {
				$this->errno = 11;
				return false;
			}
			
			return str_replace(ROOT, '', $dir);
			
		} 
		
		/**
		 * 获取文件后缀
		 * @param {String} 文件名
		 * @return {String} 返回该文件的后缀名
		 */
		protected function getExt( $file ) {
			
			$tmp = explode('.', $file);
			return end($tmp);
			
		}
		
		/**
		 * 获取文件信息
		 * @param {String} $key 上传文件的 `key` 
		 */
		protected function getFile( $key ) {
			
			return $_FILES[$key];
			
		}
		 
		/**
		 * 获取 错误信息
		 * @return {String} 错误信息
		 */
		public function getErr() {
			
			return $this->error[$this->errno];
			
		} 
		  
		
		
		/**
		 * 判断后缀是否合法
		 * @param {String} $ext 文件后缀
		 * @return {Boolean}
		 * 
		 * 防止大小写
		 */
		protected function isAllowExt( $ext ) {
			
			$ext = strtolower($this->getExt($ext));
			$allExt = strtolower($this->allow_ext);
			
			return in_array($ext, explode(',', $allExt));
			
		}
		
		/**
		 * 判断文件的大小
		 * @param {Int} $size 允许文件大小
		 * @return {Boolean} 
		 */
		protected function isAllowSize( $size ) {
			
			return $size <= $this->max_size * 1024 * 1024;
			  
		}
		
		/**
		 * 按照日期创建目录
		 * @return {Mixin} $dir 返回 路径
		 */
		protected function mkDir() {
			
			$dir = ROOT . 'data/images/' . date('Ym/d');
			
			if ( is_dir($dir) || mkdir($dir, 0777, true) ) {
				return $dir;
			} else {
				return false;
			}
			
		}
		
		/**
		 * 生成随机文件名
		 * @param {Int} $length 指定需要多长的文件名
		 * @return {String} 随机的文件名
		 */
		protected function randName( $length = 6 ) {
			
			$str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTVUWXYZ12345567890_';
			
			return substr(str_shuffle($str), 0, $length);	
				
		}
		
	}
	 
?>