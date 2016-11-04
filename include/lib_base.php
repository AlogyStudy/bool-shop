<?php
	
	/**
	 * 系统基础函数
	 */

  defined('ACC') || exit('ACC Denied');	
	 
	/**
	 * 递归转义数组
	 * @params {Array} $arr 转义的数组
	 * @return {Array} $arr 转义之后的数组
	 */
	function _addslashes( $arr ) {
		
		foreach( $arr as $k => $v ) {
			
			// 判断是否数组
			if ( is_array($v) ) {
				$arr[$k] = _addslashes($v);
			}
			
			// 判断是否是字符串
			if ( is_string($v) ) {
				$arr[$k] = addslashes($v);
			}
			
		}
		
		return $arr;
		
	} 

?>