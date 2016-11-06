/*
SQLyog Ultimate v11.27 (32 bit)
MySQL - 5.5.20-log : Database - boolshop
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`boolshop` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `boolshop`;

/*Table structure for table `cate` */

DROP TABLE IF EXISTS `cate`;

CREATE TABLE `cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catename` varchar(20) NOT NULL DEFAULT '',
  `intro` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `cate` */

insert  into `cate`(`id`,`catename`,`intro`) values (1,'xx','xixihaha'),(2,'xx','xixihaha'),(3,'xx','xixihaha'),(4,'xx','xixihaha'),(5,'asdf','aiaiaiaiai'),(6,'pink','tantatan'),(7,'pink','tantatan');

/*Table structure for table `category` */

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(20) NOT NULL DEFAULT '',
  `intro` varchar(100) NOT NULL DEFAULT '',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `category` */

insert  into `category`(`cat_id`,`cat_name`,`intro`,`parent_id`) values (1,'男士正装','男士，男士正装，正装',0),(2,'女士正装','女士，女士正装，正装',0),(3,'男士商务','商务',1),(9,'休闲服装','休闲服装，休闲服装',0);

/*Table structure for table `goods` */

DROP TABLE IF EXISTS `goods`;

CREATE TABLE `goods` (
  `goods_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` smallint(6) NOT NULL DEFAULT '0',
  `goods_sn` char(15) NOT NULL DEFAULT '',
  `brand_id` smallint(6) NOT NULL DEFAULT '0',
  `goods_name` varchar(30) NOT NULL DEFAULT '',
  `shop_price` decimal(9,2) NOT NULL DEFAULT '0.00',
  `market_price` decimal(9,2) NOT NULL DEFAULT '0.00',
  `goods_number` smallint(6) NOT NULL DEFAULT '1',
  `click_count` mediumint(9) NOT NULL DEFAULT '0',
  `goods_weight` decimal(6,3) NOT NULL DEFAULT '0.000',
  `goods_brief` varchar(100) NOT NULL DEFAULT '',
  `goods_desc` text NOT NULL,
  `thumb_img` varchar(30) NOT NULL DEFAULT '',
  `goods_img` varchar(30) NOT NULL DEFAULT '',
  `ori_img` varchar(30) NOT NULL DEFAULT '',
  `is_on_sale` tinyint(4) NOT NULL DEFAULT '1',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0',
  `is_best` tinyint(4) NOT NULL DEFAULT '0',
  `is_new` tinyint(4) NOT NULL DEFAULT '0',
  `is_hot` tinyint(4) NOT NULL DEFAULT '0',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `last_time` int(10) unsigned NOT NULL DEFAULT '0',
  `keywords` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`goods_id`),
  UNIQUE KEY `goods_sn` (`goods_sn`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `goods` */

insert  into `goods`(`goods_id`,`cat_id`,`goods_sn`,`brand_id`,`goods_name`,`shop_price`,`market_price`,`goods_number`,`click_count`,`goods_weight`,`goods_brief`,`goods_desc`,`thumb_img`,`goods_img`,`ori_img`,`is_on_sale`,`is_delete`,`is_best`,`is_new`,`is_hot`,`add_time`,`last_time`,`keywords`) values (1,0,'aaa',0,'aaa','123.00','123.00',11,0,'12.000','','123123123','','','',1,0,1,0,0,1478412418,0,'123'),(2,0,'xii',0,'xii','0.00','0.00',1,0,'10.000','212qw','xixixihahh','','','',1,0,1,0,0,1478412896,0,'1312'),(3,0,'gongbao',0,'gongbao','10.00','10.00',1,0,'20.000','asdfsdf','1231230','','','',1,0,1,0,0,1478413311,0,'1231'),(4,0,'asdf',0,'asdf','0.00','0.00',1,0,'10.000','asdf','asdf','','','',1,0,1,0,0,1478413543,0,'asdf'),(5,0,'1',0,'被窝','10.00','10.00',1,0,'10.000','weasdfa','200200','','','',1,0,1,0,0,1478413700,0,'world'),(6,0,'11',0,'weibo','10.00','10.00',10,0,'10.000','1023423afds','asdfaf','','','',1,0,1,0,0,1478413917,0,'asd'),(7,0,'1100',0,'测试1','10.00','10.00',10,0,'10.000','测hi是。','测试测试','','','',1,0,1,0,0,1478413990,0,'测试，测试'),(8,0,'100',0,'测试','123.00','12.00',123,0,'10.000','测试，测试。测试，测试。','测试，测试。','','','',1,0,1,0,0,1478414089,0,'测试，测试。'),(9,0,'z',0,'asdf','10.00','10.00',32767,0,'10.000','12301203','asdf10','','','',1,0,1,0,1,1478414183,0,'1230123'),(10,0,'',0,'asdf','0.00','0.00',1,0,'0.000','','','','','',1,0,0,0,0,1478414233,0,''),(11,0,'qpp01',0,'APPLE','100.00','100.00',12,0,'10.000','apple,apple,apple','apple','','','',1,0,1,1,0,1478417293,0,'apple');

/*Table structure for table `test` */

DROP TABLE IF EXISTS `test`;

CREATE TABLE `test` (
  `t1` varchar(10) DEFAULT NULL,
  `t2` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `test` */

insert  into `test`(`t1`,`t2`) values ('',''),('zf','ryo'),('zf','ryo'),('zf','ryo'),('z\"\"f','r\'\'yo'),('z\"\"f','xixihaha'),('frontuser','frontuser'),('adminuser','adminuser'),('frontuser','frontuser'),('frontuser','frontuser'),('frontuser','frontuser'),('frontuser','frontuser');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
