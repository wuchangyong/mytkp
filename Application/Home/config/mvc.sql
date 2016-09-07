--userType用户类型  1表示嚣张 2表示班主任 3表示项目经理 4表示学员
--school毕业学校
--classid当userType为4时（学生），表示此学生是哪个班级的学生，其余可以留空
--education学历 1表示初中 2表示高中 3表示高职 4表示专科 5表示本科 6表示硕士及以上
--workYear工作年限
--regTime注册时间 默认为系统当前时间
--status用户状态 1表示正常 2表示休假 3表示离职 4表示结业
create table tb_user(
	uid int primary key auto_increment,
	userName varchar(30) unique not null,
	userPass varchar(20) not null,
	userType int,
	trueName varchar(20) not null,
	sex int,
	birthDay datetime,
	phone varchar(11) unique,
	school varchar(30),
	classid int default null,
	education int,
	workYear int,
	regTime datetime,
	status int default 1,
	pid int,
	cid int,
	address varchar(30)
)

create table province(
	pid int primary key auto_increment,
	name varchar(20) not null
)
create table city(
	cid int primary key auto_increment,
	pid int,
	name varchar(20) not null
)
--权限管理 每一个用户登录后能看见的菜单数量不同
create table menu(
	menuid int primary key auto_increment,
	name varchar(30) not null,
	url varchar(50),
	parentid int,
	isshow int
)
create table rolemenu(
	rmid int primary key auto_increment,
	rid int,
	menuid int
)
create table role(
	rid int primary key auto_increment,
	name varchar(20) unique not null
)
create table userrole(
	urid int primary key auto_increment,
	uid int,
	rid int
)
--classType班级类型 1表示常规班 2表示快速班 3表示flash班 4表示php班
--status班级状态 1表示正常 2表示被合并 3表示已结业 4表示已废除
--headerid班主任id 关联用户表班主任的uid
--managerid项目经理id  关联用户表项目经理的uid
create table class(
	cid int primary key auto_increment,
	name varchar(20) unique not null,
	classType int,
	status int,
	createTime datetime,
	beginTime datetime,
	endTime datetime,
	headerid int,
	managerid int,
	stucount int default 0,
	remark varchar(50)
)

create table course(
	cid int primary key auto_increment,
	cname varchar(30) unique not null
)
insert into course(cname) values('HTML'),('关系型数据库'),('PHP基础'),('PHP WEB'),('Smarty'),('ThinkPHP')

--考试信息表
--cid 科目编号
--minutes考试时长 单位为分钟
--beginTime开始考试时间
--invigilator监考人id（tb_user表的uid）
--classid考试班级id
--duecount应到人数
--actualcount实到人数
create table exam(
	eid int primary key auto_increment,
	cid int,
	minutes int,
	beginTime datetime,
	invigilator int,
	classid int,
	duecount int,
	actualcount int
)







select m.* from userrole ur,rolemenu rm,menu m 
where ur.rid=rm.rid and rm.menuid=m.menuid 
and m.isshow=1 and ur.uid=1 and parentid=-1




select m.menuid,m.name,(select 1 from rolemenu rm where rm.menuid=m.menuid and rm.rid=1) from menu m


select count(*) from class c,tb_user u1,tb_user u2 where c.headerid=u1.uid and c.managerid=u2.uid and u1.trueName like '%吴%'


SELECT count(*) as cc FROM class c,tb_user u1,tb_user u2 
WHERE c.headerid = u1.uid AND c.managerid = u2.uid LIMIT 1  

SELECT count(*) as cc FROM class c,tb_user u1,tb_user u2 
WHERE ( u1.trueName like '%张%' ) LIMIT 1  

select count(*) as cc from class c,tb_user u1,tb_user u2 where c.headerid=u1.uid and c.managerid=u2.uid

SELECT * FROM `exam` WHERE ( classid in(1,2,3) 
and beginTime between '2016-06-20 00:00:00' and '2016-06-20 23:59:59' ) 

INSERT INTO `province` VALUES ('1', '重庆市');

INSERT INTO `city` VALUES ('1', '1', '荣昌区');


INSERT INTO `class` VALUES ('1', 'u19', '2', '1', '2016-03-03 23:08:54', '2016-03-03 23:08:58', '2016-06-16 23:09:00', '1', '1', '0', 'aaa666');
INSERT INTO `class` VALUES ('2', 'u20', '3', '1', '2016-06-17 09:44:12', '2016-06-17 09:44:15', '2016-10-17 09:44:17', '1', '1', '0', 'bbb');
INSERT INTO `class` VALUES ('3', 'u21', '1', '3', '2016-06-18 14:38:40', '2016-06-18 14:38:42', '2016-06-18 14:38:45', '3', '4', '0', 'ttttt');
INSERT INTO `class` VALUES ('4', 'u22', '2', '2', '2016-03-03 23:08:54', '2016-03-03 23:08:58', '2016-06-16 23:09:00', '2', '1', '0', 'aaa555');
INSERT INTO `class` VALUES ('5', 'u23', '4', '3', '2016-03-03 23:08:54', '2016-03-03 23:08:58', '2016-06-16 23:09:00', '3', '4', '0', 'aaa444');
INSERT INTO `class` VALUES ('6', 'u24', '2', '2', '2016-03-03 23:08:54', '2016-03-03 23:08:58', '2016-06-16 23:09:00', '2', '1', '0', 'aaa333');
INSERT INTO `class` VALUES ('7', 'u25', '4', '1', '2016-03-03 23:08:54', '2016-03-03 23:08:58', '2016-06-16 23:09:00', '1', '4', '3', 'aaa222');
INSERT INTO `class` VALUES ('8', 'u26', '2', '1', '2016-03-03 23:08:54', '2016-03-03 23:08:58', '2016-06-16 23:09:00', '2', '1', '0', 'aaa111');
INSERT INTO `class` VALUES ('9', 'u27', '4', '2', '2016-03-03 23:08:54', '2016-03-03 23:08:58', '2016-06-16 23:09:00', '2', '1', '0', 'aaa2345');
INSERT INTO `class` VALUES ('10', 'u28', '2', '3', '2016-03-03 23:08:54', '2016-03-03 23:08:58', '2016-06-16 23:09:00', '2', '1', '0', 'aaa2324');
INSERT INTO `class` VALUES ('11', 'u29', '1', '1', '2016-03-03 23:08:54', '2016-03-03 23:08:58', '2016-06-16 23:09:00', '2', '1', '0', 'aaa2321');
INSERT INTO `class` VALUES ('12', 'u30', '3', '1', '2016-03-03 23:08:54', '2016-03-03 23:08:58', '2016-06-16 23:09:00', '1', '1', '0', 'aaa123');

INSERT INTO `course` VALUES ('1', 'HTML');
INSERT INTO `course` VALUES ('4', 'PHP WEB');
INSERT INTO `course` VALUES ('3', 'PHP基础');
INSERT INTO `course` VALUES ('5', 'Smarty');
INSERT INTO `course` VALUES ('6', 'ThinkPHP');
INSERT INTO `course` VALUES ('2', '关系型数据库');

INSERT INTO `exam` VALUES ('1', '2', '120', '2016-06-20 14:00:00', '2', '1', '18', '18');
INSERT INTO `exam` VALUES ('2', '2', '120', '2016-06-20 14:00:00', '2', '2', '18', '18');

INSERT INTO `menu` VALUES ('1', '系统菜单', '', '-1', '1');
INSERT INTO `menu` VALUES ('2', '系统管理', '', '1', '1');
INSERT INTO `menu` VALUES ('3', '菜单管理', 'index.php/Home/Menu/menuManage', '2', '1');
INSERT INTO `menu` VALUES ('4', '角色管理', 'view/roleManage.php', '2', '1');
INSERT INTO `menu` VALUES ('5', '用户管理', '', '1', '1');
INSERT INTO `menu` VALUES ('6', '用户管理', 'view/userManage.php', '5', '1');
INSERT INTO `menu` VALUES ('7', '班级管理', '', '1', '1');
INSERT INTO `menu` VALUES ('8', '班级管理', 'index.php/Home/Class/classManage', '7', '1');
INSERT INTO `menu` VALUES ('10', '资料管理', '', '1', '1');
INSERT INTO `menu` VALUES ('11', '资料上传', 'view/upload.php', '10', '1');
INSERT INTO `menu` VALUES ('12', '资料下载', 'view/download.php', '10', '1');

INSERT INTO `role` VALUES ('4', '学生');
INSERT INTO `role` VALUES ('2', '班主任');
INSERT INTO `role` VALUES ('1', '管理员');
INSERT INTO `role` VALUES ('3', '项目经理');

INSERT INTO `rolemenu` VALUES ('96', '1', '1');
INSERT INTO `rolemenu` VALUES ('97', '1', '2');
INSERT INTO `rolemenu` VALUES ('98', '1', '3');
INSERT INTO `rolemenu` VALUES ('99', '1', '4');
INSERT INTO `rolemenu` VALUES ('100', '1', '5');
INSERT INTO `rolemenu` VALUES ('101', '1', '6');
INSERT INTO `rolemenu` VALUES ('102', '1', '7');
INSERT INTO `rolemenu` VALUES ('103', '1', '8');
INSERT INTO `rolemenu` VALUES ('104', '1', '10');
INSERT INTO `rolemenu` VALUES ('105', '1', '11');
INSERT INTO `rolemenu` VALUES ('106', '1', '12');

INSERT INTO `tb_user` VALUES ('1', 'admin', '123321', '2', '吴昌勇', '1', '1984-05-13 00:00:00', '18996157300', '重庆理工大学', null, '5', '10', '2016-05-31 14:17:43', '1', '1', '1', '仁义镇正华街道150号');
INSERT INTO `tb_user` VALUES ('2', 'aaa', '111', '3', '张三丰', '1', '1984-05-12 00:00:00', '13389660270', '重庆理工大学', null, '4', '5', '2016-06-19 11:14:39', '1', '1', '1', '仁义镇正华街道150号');
INSERT INTO `tb_user` VALUES ('3', 'bbb', '111', '2', '刘德华', '1', '1981-05-12 00:00:00', '13983795981', '重庆大学', null, '5', '6', '2016-06-20 13:56:27', '1', '1', '1', '仁义镇正华街道150号');
INSERT INTO `tb_user` VALUES ('4', 'ccc', '111', '3', '杨幂', '0', '1989-05-12 00:00:00', '18996157200', '重庆交通大学', null, '4', '3', '2016-06-20 13:57:52', '1', '1', '1', '仁义镇正华街道150号');
INSERT INTO `tb_user` VALUES ('5', 'ddd', '111', '4', '唐天鳌', '1', '1992-05-12 00:00:00', '18306057946', '重庆大学', '7', '4', '1', '2016-06-20 14:19:11', '1', '1', '1', null);
INSERT INTO `tb_user` VALUES ('6', 'eee', '111', '4', '娄阳', '1', '1992-05-11 00:00:00', '13696401521', '重庆大学', '7', '4', '1', '2016-06-20 14:21:30', '1', '1', '1', null);
INSERT INTO `tb_user` VALUES ('7', 'fff', '111', '4', '胡友林', '1', '1991-05-11 00:00:00', '15111910017', '背景大学', '7', '5', '1', '2016-06-20 15:04:58', '1', '1', '1', null);

INSERT INTO `userrole` VALUES ('2', '1', '1');