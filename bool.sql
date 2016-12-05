
# SQL语句

# 栏目表

create table category (
	cat_id int auto_increment primary key,
	cat_name varchar(20) not null default '',
	intro varchar(100) not null default '',
	parent_id int not null default 0 
) engine myisam charset utf8;



# goods
 
create table goods (
	`goods_id` int(10) unsigned not null auto_increment,
	`cat_id` smallint(6) not null default '0',
	`goods_sn` char(15) not null default '',
	`brand_id` smallint(6) not null default '0',
	`goods_name` varchar(30) not null default '',
	`shop_price` decimal(9, 2) not null default '0.00',
	`market_price` decimal(9, 2) not null default '0.00',
	`goods_number` smallint(6) not null default '1',
	`click_count` mediumint(9) not null default '0',
	`goods_weight` decimal(6, 3) not null default '0.000',
	`goods_brief` varchar(100) not null default '',
	`goods_desc` text not null,
	`thumb_img` varchar(30) not null default '',
	`goods_img` varchar(30) not null default '',
	`ori_img` varchar(30) not null default '',
	`is_on_sale` tinyint(4) not null default '1',
	`is_delete` tinyint(4) not null default '0',		
	`is_best` tinyint(4) not null default '0',
	`is_new` tinyint(4) not null default '0',
	`is_hot` tinyint(4) not null default '0',
	`add_time` int(10) unsigned not null default '0',
	`last_time` int(10) unsigned not null default '0',
	`keywords` varchar(20) not null default '',
	PRIMARY KEY (`goods_id`),
  UNIQUE KEY `goods_sn` (`goods_sn`)
) engine myisam charset utf8; 




CREATE TABLE IF NOT EXISTS `goods` (
  `goods_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_sn` char(15) NOT NULL DEFAULT '',
  `cat_id` smallint(6) NOT NULL DEFAULT '0',
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
  `last_update` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`goods_id`),
  UNIQUE KEY `goods_sn` (`goods_sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# 用户表
CREATE TABLE USER(
	user_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	user_name VARCHAR(6) NOT NULL DEFAULT '',
	emial VARCHAR(30) NOT NULL DEFAULT '',
	passwd CHAR(32) NOT NULL DEFAULT '',
	regtime INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '当前的时间戳',
	lastlogin INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '上次登陆时间'
) ENGINE MYISAM CHARSET utf8;




# 创建订单表
# 配送区域, 收货人姓名, 电子邮件地址, 详细地址, 邮政编码, 电话, 手机, 标志建筑, 最佳送货时间.
create table orderinfo (
	order_id int unsigned not null auto_increment primary key,
	order_sn char(15) not null default '',
	user_id int unsigned not null default 0 comment "用户id",
	username varchar(20) not null default '' comment "用户名称",
	zone varchar(30) not null default '' comment "配送区域",
	address varchar(30) not null default '' comment "地址",
	zipcode char(6) not null default '' comment "邮编",
	reciver varchar(30) not null default '' comment "收货人姓名", 
	email varchar(40) not null default '',
	tel varchar(20) not null default '',
	mobile char(11) not null default '',
	building varchar(30) not null default '' comment "标志性建筑",
	best_time varchar(10) not null default '' comment "最佳时间",
	add_time int unsigned not null default 0 comment "增加时间",
	order_amount decimal(10, 2) not null default 0.0 comment "总金额",
	pay tinyint(1) not null default 0 comment "支付方式" 
) engine myisam charset utf8;


# 订单与商品对应表
# 通过`order_id`与`order_sn`与订单表关联起来.
create table ordergoods (
	og_id int auto_increment unsigned primary key comment "流水id",
	order_id int unsigned not null default 0 comment "订单id",
	order_sn char(15) not null default '' comment "订单编号",
	goods_id int unsigned not null default 0 comment "商品id",
	goods_name varchar(60) not null default '',
	goods_number smallint not null default 0 comment "商品数量",
	shop_price decimal(10, 2) not null default 0.0 comment "商品价格",
	subtotal decimal(10, 2) not null default 0.0 comment "小计价格"
) engine myisam charset utf8;

