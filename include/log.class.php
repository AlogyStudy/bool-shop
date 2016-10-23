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
		
		const LOGFILE = 'curr.log'; // 表示日志文件的名称 
		
		/**
		 * 写日志
		 * $cont 日志内容
		 */
		public static function write ( $cont ) {
			
			$cont .= "\r\n";
			
			// 判断日志是否备份
			$log = self::isBak(); // 计算出日志文件的地址
			
			$fh = fopen($log, 'a');
			
			// 写入文件
			fwrite($fh, $cont);
			
			fclose($fh);
			
		}
		
		/**
		 * 备份日志
		 * 原理： 把原来的日志文件，改个名字，存储起来。
		 */
		public static function bak() {
			// 改成 年-月-日.bak 这种文件格式
			$log = ROOT . 'data/log.curr.log';
			$bak = ROOT . 'data/log' . date('ymd') . mt_rand(10000, 999999) . '.bak';
			return rename($log, $bak);
			
		} 
		
		/**
		 * 读取并判断日志文件大小
		 * 返回M为单位
		 */
		public static function isBak() {
			
				$log = ROOT . 'data/log/curr.log';
				
				if ( file_exists($log) ) { // 文件不存在
					touch($log); // touch 快速建立文件
					return $log;
				}
				
				// 判断大小
				$size = filesize($log);
				if ( $size <= 1024 * 1024 ) { 
					return $log;
				};
				
				// 大于  1M
				if ( !self::bak() ) {
					return $log;
				} else {
					touch($log);
					return $log;
				}
			
		}
		
	}

?>