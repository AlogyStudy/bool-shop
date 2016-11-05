
# SQL语句

# 栏目表

create table category (
	cat_id int auto_increment primary key,
	cat_name varchar(20) not null default '',
	intro varchar(100) not null default '',
	parent_id int not null default 0 
) engine myisam charset utf8;



