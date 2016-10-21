<?php

	// file log.class.php
	// 记录信息到日志
	
	// 思路：
	// 给定文件，写入内容(fopen, fwrite...)
	// 如果文件大于 1M，重新写一份.
	
	// 传递一个内容
	// 判断当前日志的大小
			// 如果 大于 1M， --> 备份
			// 否则，写入
	
	class Log {
		
		const LOGFILE = 'log'; // 表示日志文件的名称 
		
		/**
		 * 写日志
		 */
		public static function write ( $log ) {
			// 判断日志大小
			self::isBak();
		}
		
		/**
		 * 备份日志
		 */
		public static function bak() {
			
		} 
		
		/**
		 * 读取并判断日志文件大小
		 * 返回M为单位
		 */
		public static function isBak() {
			
				$log = ROOT . 'data/log/curr.log';
				
				if ( file_exists($log) ) { // 文件不存在
					touch($log);
					return $log;
				}
			
		}
		
	}
	

?>