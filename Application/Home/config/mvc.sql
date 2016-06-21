create table tb_user(
	uid int primary key auto_increment,
	userName varchar(20) unique not null,
	userPass varchar(20) not null
)


insert into tb_user(userName,userPass) values('admin','123321');



create table account(
	aid int primary key auto_increment,
	aname varchar(20) not null,
	money decimal(20,2)
)

insert into account(aname,money) values('张三',1000),('李四',208);


create table files(
	fid int primary key auto_increment,
	oldName varchar(100) not null,
	newName varchar(30) not null,
	path varchar(100) not null,
	size int,
	downloadTimes int default 0,
	uploadTime datetime
)


--videoKind  1表示  2表示  3表示 
create table videos(
	vid int primary key auto_increment,
	oldName varchar(100) not null,
	newName varchar(30) not null,
	showName varchar(200) not null,
	path varchar(100) not null,
	imagePath varchar(50) not null,
	size int,
	videoKind int,
	playTimes int default 0,
	uploadTime datetime
)

--url表示菜单被点击之后要发送的超链接地址 如果此菜单不是最低级则此列的值为null
--parentid表示此菜单父级菜单的主键id 如果此菜单已经是最顶级菜单，则此列的值为-1
--isshow表示是否在首页左边的树形菜单中展示 1表示要展示
create table menu(
	menuid int primary key auto_increment,
	name varchar(30) not null,
	url varchar(100),
	parentid int,
	isshow int default 1
)






update menu set name=?,url=?,parentid=?,isshow=? where menuid=?



select * from menu limit ?,?

select count(*) from menu where menuid>332








