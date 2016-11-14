# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.16)
# Database: interaction_yzu
# Generation Time: 2016-11-14 07:42:37 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table auth_assignment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_assignment`;

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(12) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `user_id_ibfk_1` (`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_id_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_number`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`)
VALUES
	('student',141304120,1475332431),
	('student',141304121,1475480652),
	('student',141304122,1475569978),
	('student',141304123,1475570067),
	('student',141304128,1477835741),
	('student',1413041202,1478139238),
	('teacher',123456,1475370417),
	('teacher',123457,1475480530);

/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table auth_item
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_item`;

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`)
VALUES
	('admin',1,NULL,NULL,NULL,1475328607,1475328607),
	('nochecked_teacher',1,NULL,NULL,NULL,1475328913,1475328913),
	('student',1,NULL,NULL,NULL,1475328606,1475328606),
	('studentmonitor',1,NULL,NULL,NULL,1475328607,1475328607),
	('teacher',1,NULL,NULL,NULL,1475328607,1475328607);

/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table auth_item_child
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_item_child`;

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;

INSERT INTO `auth_item_child` (`parent`, `child`)
VALUES
	('studentmonitor','student');

/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table auth_rule
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_rule`;

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table course_file
# ------------------------------------------------------------

DROP TABLE IF EXISTS `course_file`;

CREATE TABLE `course_file` (
  `file_id` int(12) NOT NULL AUTO_INCREMENT,
  `course_id` int(12) unsigned NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_extension` varchar(255) DEFAULT NULL,
  `file_upload_time` int(11) NOT NULL,
  `file_hash` varchar(255) NOT NULL,
  `file_download_count` int(11) DEFAULT '0',
  PRIMARY KEY (`file_id`),
  KEY `fk_coursefile_course_id` (`course_id`),
  CONSTRAINT `fk_coursefile_course_id` FOREIGN KEY (`course_id`) REFERENCES `teacher_course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `course_file` WRITE;
/*!40000 ALTER TABLE `course_file` DISABLE KEYS */;

INSERT INTO `course_file` (`file_id`, `course_id`, `file_name`, `file_extension`, `file_upload_time`, `file_hash`, `file_download_count`)
VALUES
	(3,1,'新建文本文档','txt',1476704970,'8iqzC3Vh7l4xgdo4IBTRZAnn_0uSoWo_',11);

/*!40000 ALTER TABLE `course_file` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table course_message
# ------------------------------------------------------------

DROP TABLE IF EXISTS `course_message`;

CREATE TABLE `course_message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_title` varchar(50) NOT NULL COMMENT '留言标题',
  `message_content` varchar(1000) NOT NULL COMMENT '留言内容',
  `message_date` int(11) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table course_message_node
# ------------------------------------------------------------

DROP TABLE IF EXISTS `course_message_node`;

CREATE TABLE `course_message_node` (
  `node_id` int(11) NOT NULL AUTO_INCREMENT,
  `prior_id` int(11) NOT NULL,
  `messgae_title` varchar(50) DEFAULT NULL,
  `message_content` varchar(1000) NOT NULL,
  `messgae_date` int(11) NOT NULL,
  PRIMARY KEY (`node_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table course_message_student
# ------------------------------------------------------------

DROP TABLE IF EXISTS `course_message_student`;

CREATE TABLE `course_message_student` (
  `message_id` int(11) NOT NULL,
  `student_number` int(11) NOT NULL,
  `course_id` int(12) unsigned NOT NULL,
  PRIMARY KEY (`message_id`),
  KEY `student_number` (`student_number`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `course_message_student_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `course_message` (`message_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `course_message_student_ibfk_2` FOREIGN KEY (`student_number`) REFERENCES `user` (`user_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `course_message_student_ibfk_3` FOREIGN KEY (`course_id`) REFERENCES `teacher_course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=gbk;



# Dump of table course_notice
# ------------------------------------------------------------

DROP TABLE IF EXISTS `course_notice`;

CREATE TABLE `course_notice` (
  `notice_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `notice_title` varchar(255) CHARACTER SET gbk NOT NULL COMMENT '标题',
  `notice_content` text CHARACTER SET gbk NOT NULL COMMENT '内容',
  `notice_date` varchar(255) CHARACTER SET gbk NOT NULL COMMENT '时间',
  `course_id` int(12) unsigned NOT NULL,
  PRIMARY KEY (`notice_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `course_notice_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `teacher_course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `course_notice` WRITE;
/*!40000 ALTER TABLE `course_notice` DISABLE KEYS */;

INSERT INTO `course_notice` (`notice_id`, `notice_title`, `notice_content`, `notice_date`, `course_id`)
VALUES
	(3,'new notice','new notciedhashdlkasdhasdhfasekl;fhjkl;ashfk;ahsfkl;ashdfaKL;','1476971897',1),
	(4,'测试计算机导论的通知','测试计算机导论的通知测试计算机导论的通知','1477833679',2),
	(5,'Java通知测试','java通知测试发送','1477833922',4),
	(6,'明天晚上答疑','全体学生6点到31教室','1478150971',7);

/*!40000 ALTER TABLE `course_notice` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table course_notice_broadcast
# ------------------------------------------------------------

DROP TABLE IF EXISTS `course_notice_broadcast`;

CREATE TABLE `course_notice_broadcast` (
  `notice_id` int(11) unsigned NOT NULL,
  `student_number` int(12) NOT NULL,
  `is_read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`notice_id`,`student_number`,`is_read`),
  KEY `student_number` (`student_number`),
  CONSTRAINT `course_notice_broadcast_ibfk_2` FOREIGN KEY (`student_number`) REFERENCES `user` (`user_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `course_notice_broadcast_ibfk_3` FOREIGN KEY (`notice_id`) REFERENCES `course_notice` (`notice_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `course_notice_broadcast` WRITE;
/*!40000 ALTER TABLE `course_notice_broadcast` DISABLE KEYS */;

INSERT INTO `course_notice_broadcast` (`notice_id`, `student_number`, `is_read`)
VALUES
	(3,141304120,1),
	(4,141304120,1),
	(5,141304120,0),
	(3,141304121,0),
	(4,141304121,0);

/*!40000 ALTER TABLE `course_notice_broadcast` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migration
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migration`;

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;

INSERT INTO `migration` (`version`, `apply_time`)
VALUES
	('m000000_000000_base',1475323392),
	('m140506_102106_rbac_init',1475323523);

/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table student_course
# ------------------------------------------------------------

DROP TABLE IF EXISTS `student_course`;

CREATE TABLE `student_course` (
  `student_number` int(12) NOT NULL COMMENT '学生学号',
  `course_id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '课程号',
  `verified` tinyint(1) NOT NULL DEFAULT '0' COMMENT '确认与否',
  PRIMARY KEY (`student_number`,`course_id`),
  KEY `fk_coures` (`course_id`),
  CONSTRAINT `fk_coures` FOREIGN KEY (`course_id`) REFERENCES `teacher_course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_stu` FOREIGN KEY (`student_number`) REFERENCES `user` (`user_number`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `student_course` WRITE;
/*!40000 ALTER TABLE `student_course` DISABLE KEYS */;

INSERT INTO `student_course` (`student_number`, `course_id`, `verified`)
VALUES
	(141304120,1,1),
	(141304120,2,1),
	(141304120,3,1),
	(141304120,4,1),
	(141304120,5,1),
	(141304121,1,1),
	(141304121,2,1),
	(141304128,2,0),
	(141304128,4,0),
	(1413041202,4,1);

/*!40000 ALTER TABLE `student_course` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table student_information
# ------------------------------------------------------------

DROP TABLE IF EXISTS `student_information`;

CREATE TABLE `student_information` (
  `student_number` int(12) NOT NULL COMMENT '学号',
  `student_class` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '班级',
  PRIMARY KEY (`student_number`),
  CONSTRAINT `fk_stuinfo_student_number` FOREIGN KEY (`student_number`) REFERENCES `user` (`user_number`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=gbk;

LOCK TABLES `student_information` WRITE;
/*!40000 ALTER TABLE `student_information` DISABLE KEYS */;

INSERT INTO `student_information` (`student_number`, `student_class`)
VALUES
	(141304120,'计科1401'),
	(141304121,'计科1401'),
	(141304128,'计科1401'),
	(1413041202,'计科1401');

/*!40000 ALTER TABLE `student_information` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table student_work
# ------------------------------------------------------------

DROP TABLE IF EXISTS `student_work`;

CREATE TABLE `student_work` (
  `swork_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '作业ID',
  `swork_title` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '作业题目',
  `swork_content` text CHARACTER SET utf8 COMMENT '作业答案',
  `swork_date` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '提交时间',
  `user_number` int(11) NOT NULL COMMENT '提交者',
  PRIMARY KEY (`swork_id`),
  KEY `fk_user_number` (`user_number`),
  CONSTRAINT `fk_user_number` FOREIGN KEY (`user_number`) REFERENCES `user` (`user_number`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=gbk;

LOCK TABLES `student_work` WRITE;
/*!40000 ALTER TABLE `student_work` DISABLE KEYS */;

INSERT INTO `student_work` (`swork_id`, `swork_title`, `swork_content`, `swork_date`, `user_number`)
VALUES
	(5,'测试Java作业测试Java作业测试Java作业','测试Java作业测试Java作业测试Java作业测试Java作业','1478140713',141304120);

/*!40000 ALTER TABLE `student_work` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table swork_file
# ------------------------------------------------------------

DROP TABLE IF EXISTS `swork_file`;

CREATE TABLE `swork_file` (
  `file_id` int(12) NOT NULL AUTO_INCREMENT,
  `swork_id` int(12) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_extension` varchar(255) NOT NULL,
  `file_upload_time` int(11) NOT NULL,
  `file_hash` varchar(255) NOT NULL,
  `file_download_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`file_id`),
  KEY `fk_sworkfile_course_id` (`swork_id`),
  CONSTRAINT `fk_sworkfile_course_id` FOREIGN KEY (`swork_id`) REFERENCES `student_work` (`swork_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table swork_twork
# ------------------------------------------------------------

DROP TABLE IF EXISTS `swork_twork`;

CREATE TABLE `swork_twork` (
  `swork_id` int(11) NOT NULL,
  `twork_id` int(11) NOT NULL,
  `swork_grade` double(3,0) DEFAULT NULL COMMENT '成绩',
  `swork_comment` longtext CHARACTER SET utf8 COMMENT '评语',
  `swork_comment_date` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`swork_id`,`twork_id`),
  KEY `fk_st_t` (`twork_id`),
  CONSTRAINT `fk_st_s` FOREIGN KEY (`swork_id`) REFERENCES `student_work` (`swork_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_st_t` FOREIGN KEY (`twork_id`) REFERENCES `teacher_work` (`twork_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=gbk;

LOCK TABLES `swork_twork` WRITE;
/*!40000 ALTER TABLE `swork_twork` DISABLE KEYS */;

INSERT INTO `swork_twork` (`swork_id`, `twork_id`, `swork_grade`, `swork_comment`, `swork_comment_date`)
VALUES
	(5,16,NULL,NULL,NULL);

/*!40000 ALTER TABLE `swork_twork` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table teacher_course
# ------------------------------------------------------------

DROP TABLE IF EXISTS `teacher_course`;

CREATE TABLE `teacher_course` (
  `course_id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '课程号',
  `course_name` varchar(255) NOT NULL COMMENT '课程名',
  `course_content` text COMMENT '课程介绍',
  `teacher_number` int(12) NOT NULL COMMENT '教师号',
  PRIMARY KEY (`course_id`),
  KEY `fk_te_course` (`teacher_number`),
  CONSTRAINT `fk_te_course` FOREIGN KEY (`teacher_number`) REFERENCES `user` (`user_number`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `teacher_course` WRITE;
/*!40000 ALTER TABLE `teacher_course` DISABLE KEYS */;

INSERT INTO `teacher_course` (`course_id`, `course_name`, `course_content`, `teacher_number`)
VALUES
	(1,'操作系统原理','《操作系统原理》<br>\r\n一、主要目标和主要内容：<br>\r\n二、授课教师和授课对象：<br>\r\n三、课程类型和学时学分：<br> \r\n四、教学方式（授课形式和考核方式）：<br>\r\n五、教材与参考书目：',123456),
	(2,'计算机导论','《计算机导论》是计算机科学与技术等专业的学科导引课程，该课程的教学对象是计算机科学与技术等专业的大一新生，课程开设时间是一年级的第一学期。课程目标是在学生面前展现一幅全景式的计算机学科知识画卷，使学生在入门阶段就对本学科有清晰、明确的认识，在今后的学习过程中不再感到困惑和茫然，从而激发他们对计算机专业的学习兴趣，启发学生对本专业进行系统的思考，帮助并引导学生掌握和运用正确方法，而不在于传授学生具体专业知识。',123456),
	(3,'data structure','about data structure',123457),
	(4,'Java程序设计','Java语言是美国SUN公司1995年推出的面向对象的程序设计语言，该语言充分考虑了互联网时代的特点，在设计上具有跨平台性、面向对象、安全等特性，因此一经推出就受到IT界的广泛重视并大量采用，同时也成为教育界进行程序设计教学的一门重要编程语言。',123456),
	(5,'Python','Pythondasdasdasdasdasdasda',123457),
	(6,'计算机组成原理','计算机组成原理是计算机应用专业的一门必修课程，在计算机专业教学中处于核心地位，该课的教学内容跨越专业基础和专业课两个层次，具有专业基础课和专业课双重性质。通过本课程的学习使学生掌握计算机各大部件的基本工作原理、设计方法及其计算机整体的互连技术，为培养学生具有硬件系统的开发能力打下一定的基础。为后续学习《微型原理与接口技术》、《计算机系统结构》等专业课程提供必要的基础。',123456),
	(7,'软件技术基础','这是一门工科非计算机专业的必修课',123456);

/*!40000 ALTER TABLE `teacher_course` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table teacher_information
# ------------------------------------------------------------

DROP TABLE IF EXISTS `teacher_information`;

CREATE TABLE `teacher_information` (
  `teacher_number` int(12) NOT NULL AUTO_INCREMENT COMMENT '教师号',
  `teacher_introduction` text COMMENT '个人简介',
  PRIMARY KEY (`teacher_number`),
  CONSTRAINT `teacher_information_ibfk_1` FOREIGN KEY (`teacher_number`) REFERENCES `user` (`user_number`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `teacher_information` WRITE;
/*!40000 ALTER TABLE `teacher_information` DISABLE KEYS */;

INSERT INTO `teacher_information` (`teacher_number`, `teacher_introduction`)
VALUES
	(123456,'My name is Peng');

/*!40000 ALTER TABLE `teacher_information` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table teacher_work
# ------------------------------------------------------------

DROP TABLE IF EXISTS `teacher_work`;

CREATE TABLE `teacher_work` (
  `twork_id` int(8) NOT NULL AUTO_INCREMENT COMMENT '作业ID',
  `twork_title` varchar(255) NOT NULL COMMENT '作业题目',
  `twork_content` text NOT NULL COMMENT '作业要求',
  `twork_date` varchar(255) NOT NULL COMMENT ' 发布时间',
  `twork_update` varchar(255) DEFAULT NULL,
  `course_id` int(12) unsigned NOT NULL COMMENT '课程号',
  `twork_deadline` int(11) DEFAULT NULL COMMENT '截止时间',
  PRIMARY KEY (`twork_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `fk_tw_course` FOREIGN KEY (`course_id`) REFERENCES `teacher_course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `teacher_work` WRITE;
/*!40000 ALTER TABLE `teacher_work` DISABLE KEYS */;

INSERT INTO `teacher_work` (`twork_id`, `twork_title`, `twork_content`, `twork_date`, `twork_update`, `course_id`, `twork_deadline`)
VALUES
	(14,'操作系统的第一次作业','操作系统的第一次作业要求测试。。。。。','1477833973',NULL,1,1477958400),
	(15,'计算机组成原理 的作业','计算机组成原理 的作业计算机组成原理 的作业计算机组成原理 的作业计算机组成原理 的作业','1477834130',NULL,6,1478044800),
	(16,'测试Java作业','测试作业，测试Java作业','1478140679',NULL,4,1478304000),
	(17,'线性表和队列的不同','请举例说明并用程序实现','1478150913',NULL,7,1478736000);

/*!40000 ALTER TABLE `teacher_work` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table twork_file
# ------------------------------------------------------------

DROP TABLE IF EXISTS `twork_file`;

CREATE TABLE `twork_file` (
  `file_id` int(12) NOT NULL AUTO_INCREMENT,
  `twork_id` int(12) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_extension` varchar(255) NOT NULL,
  `file_upload_time` int(11) NOT NULL,
  `file_hash` varchar(255) NOT NULL,
  `file_download_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`file_id`),
  KEY `twork_id` (`twork_id`),
  CONSTRAINT `twork_file_ibfk_1` FOREIGN KEY (`twork_id`) REFERENCES `teacher_work` (`twork_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `twork_file` WRITE;
/*!40000 ALTER TABLE `twork_file` DISABLE KEYS */;

INSERT INTO `twork_file` (`file_id`, `twork_id`, `file_name`, `file_extension`, `file_upload_time`, `file_hash`, `file_download_count`)
VALUES
	(3,14,'test file','txt',1477834046,'K4rfThBg1yrlWOtBJai9rkKMKohI2eY3',0),
	(4,15,'test file','txt',1477834136,'K2k4ogP8dwjNxBrik6DSP-3g13OEXXBa',0);

/*!40000 ALTER TABLE `twork_file` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `user_number` int(12) NOT NULL COMMENT '用户ID',
  `user_name` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '姓名',
  `user_password` varchar(32) CHARACTER SET utf8 NOT NULL COMMENT '密码',
  `user_authKey` varchar(60) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`user_number`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`user_number`, `user_name`, `user_password`, `user_authKey`)
VALUES
	(123456,'彭老师','e10adc3949ba59abbe56e057f20f883e','bVmjsZqDyl0ATFWDITQRA6el0SHPxpgC'),
	(123457,'teacher2','e10adc3949ba59abbe56e057f20f883e','48mz4slUIBbirnkDnf_Qtqju0MFy6G4B'),
	(141304120,'Sanc','e10adc3949ba59abbe56e057f20f883e','zlJ4pKv0rW26jOE899-p_Ugi-9PxdhF_'),
	(141304121,'sancs','e10adc3949ba59abbe56e057f20f883e','4QdIbGIC-2aEgC8kVqYyPtfNAndqKMBx'),
	(141304122,'小明','e10adc3949ba59abbe56e057f20f883e','4mFd6EmpEvc6DtfOx0i0BboyiEiJ7spw'),
	(141304123,'xiaohua','e10adc3949ba59abbe56e057f20f883e','1Usdguug8j-AynHJ_qgQjtd3mkAeLdd1'),
	(141304128,'张永远','e10adc3949ba59abbe56e057f20f883e','pzoOR7bfN0C9vKp-e-DTtaiNi-aasLTL'),
	(1413041202,'op','e10adc3949ba59abbe56e057f20f883e','hTJ18teJ8PbXyEXGOKjDgXGVQxIqsWuU');

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
