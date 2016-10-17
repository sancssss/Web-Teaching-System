/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : interaction_yzu

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2016-10-17 09:23:11
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `auth_assignment`
-- ----------------------------
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

-- ----------------------------
-- Records of auth_assignment
-- ----------------------------
INSERT INTO `auth_assignment` VALUES ('student', '141304120', '1475332431');
INSERT INTO `auth_assignment` VALUES ('student', '141304121', '1475480652');
INSERT INTO `auth_assignment` VALUES ('student', '141304122', '1475569978');
INSERT INTO `auth_assignment` VALUES ('student', '141304123', '1475570067');
INSERT INTO `auth_assignment` VALUES ('teacher', '123456', '1475370417');
INSERT INTO `auth_assignment` VALUES ('teacher', '123457', '1475480530');

-- ----------------------------
-- Table structure for `auth_item`
-- ----------------------------
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

-- ----------------------------
-- Records of auth_item
-- ----------------------------
INSERT INTO `auth_item` VALUES ('admin', '1', null, null, null, '1475328607', '1475328607');
INSERT INTO `auth_item` VALUES ('nochecked_teacher', '1', null, null, null, '1475328913', '1475328913');
INSERT INTO `auth_item` VALUES ('student', '1', null, null, null, '1475328606', '1475328606');
INSERT INTO `auth_item` VALUES ('studentmonitor', '1', null, null, null, '1475328607', '1475328607');
INSERT INTO `auth_item` VALUES ('teacher', '1', null, null, null, '1475328607', '1475328607');

-- ----------------------------
-- Table structure for `auth_item_child`
-- ----------------------------
DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of auth_item_child
-- ----------------------------
INSERT INTO `auth_item_child` VALUES ('studentmonitor', 'student');

-- ----------------------------
-- Table structure for `auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of auth_rule
-- ----------------------------

-- ----------------------------
-- Table structure for `course_file`
-- ----------------------------
DROP TABLE IF EXISTS `course_file`;
CREATE TABLE `course_file` (
  `file_id` int(12) NOT NULL AUTO_INCREMENT,
  `course_id` int(12) unsigned NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_extension` varchar(255) DEFAULT NULL,
  `file_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`file_id`),
  KEY `fk_coursefile_course_id` (`course_id`),
  CONSTRAINT `fk_coursefile_course_id` FOREIGN KEY (`course_id`) REFERENCES `teacher_course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of course_file
-- ----------------------------

-- ----------------------------
-- Table structure for `migration`
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of migration
-- ----------------------------
INSERT INTO `migration` VALUES ('m000000_000000_base', '1475323392');
INSERT INTO `migration` VALUES ('m140506_102106_rbac_init', '1475323523');

-- ----------------------------
-- Table structure for `student_course`
-- ----------------------------
DROP TABLE IF EXISTS `student_course`;
CREATE TABLE `student_course` (
  `student_number` int(12) NOT NULL COMMENT '学生学号',
  `course_id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '课程号',
  `verified` tinyint(1) NOT NULL DEFAULT '0' COMMENT '确认与否',
  PRIMARY KEY (`student_number`,`course_id`),
  KEY `fk_coures` (`course_id`),
  CONSTRAINT `fk_coures` FOREIGN KEY (`course_id`) REFERENCES `teacher_course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_stu` FOREIGN KEY (`student_number`) REFERENCES `user` (`user_number`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of student_course
-- ----------------------------
INSERT INTO `student_course` VALUES ('141304120', '1', '1');
INSERT INTO `student_course` VALUES ('141304120', '2', '1');
INSERT INTO `student_course` VALUES ('141304120', '3', '1');
INSERT INTO `student_course` VALUES ('141304120', '4', '1');
INSERT INTO `student_course` VALUES ('141304120', '5', '1');
INSERT INTO `student_course` VALUES ('141304120', '6', '1');
INSERT INTO `student_course` VALUES ('141304121', '1', '1');
INSERT INTO `student_course` VALUES ('141304121', '2', '1');

-- ----------------------------
-- Table structure for `student_information`
-- ----------------------------
DROP TABLE IF EXISTS `student_information`;
CREATE TABLE `student_information` (
  `student_number` int(12) NOT NULL COMMENT '学号',
  `student_class` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '班级',
  PRIMARY KEY (`student_number`),
  CONSTRAINT `fk_stuinfo_student_number` FOREIGN KEY (`student_number`) REFERENCES `user` (`user_number`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of student_information
-- ----------------------------
INSERT INTO `student_information` VALUES ('141304120', '计科1401');
INSERT INTO `student_information` VALUES ('141304121', '计科1401');

-- ----------------------------
-- Table structure for `student_work`
-- ----------------------------
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of student_work
-- ----------------------------
INSERT INTO `student_work` VALUES ('1', 'diyicizuoy', 'dasdasdasdasd', null, '141304120');
INSERT INTO `student_work` VALUES ('3', 'ceshiasdkashdjkhajksh', 'dasdfkjaskldfjhaskldakls', '1476518579', '141304120');

-- ----------------------------
-- Table structure for `swork_file`
-- ----------------------------
DROP TABLE IF EXISTS `swork_file`;
CREATE TABLE `swork_file` (
  `file_id` int(12) NOT NULL AUTO_INCREMENT,
  `swork_id` int(12) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_extension` varchar(255) NOT NULL,
  PRIMARY KEY (`file_id`),
  KEY `fk_sworkfile_course_id` (`swork_id`),
  CONSTRAINT `fk_sworkfile_course_id` FOREIGN KEY (`swork_id`) REFERENCES `student_work` (`swork_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of swork_file
-- ----------------------------

-- ----------------------------
-- Table structure for `swork_twork`
-- ----------------------------
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

-- ----------------------------
-- Records of swork_twork
-- ----------------------------
INSERT INTO `swork_twork` VALUES ('1', '7', '90', '123123123123', '1476191683');
INSERT INTO `swork_twork` VALUES ('3', '8', '100', 'test pingyu', '1476576867');

-- ----------------------------
-- Table structure for `teacher_course`
-- ----------------------------
DROP TABLE IF EXISTS `teacher_course`;
CREATE TABLE `teacher_course` (
  `course_id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '课程号',
  `course_name` varchar(255) NOT NULL COMMENT '课程名',
  `course_content` text COMMENT '课程介绍',
  `teacher_number` int(12) NOT NULL COMMENT '教师号',
  PRIMARY KEY (`course_id`),
  KEY `fk_te_course` (`teacher_number`),
  CONSTRAINT `fk_te_course` FOREIGN KEY (`teacher_number`) REFERENCES `user` (`user_number`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of teacher_course
-- ----------------------------
INSERT INTO `teacher_course` VALUES ('1', 'Computer System', 'Computer System', '123456');
INSERT INTO `teacher_course` VALUES ('2', 'MySQL', 'about MySQL', '123456');
INSERT INTO `teacher_course` VALUES ('3', 'data structure', 'about data structure', '123457');
INSERT INTO `teacher_course` VALUES ('4', '数据结构', '数据化啊实打实大苏打', '123456');
INSERT INTO `teacher_course` VALUES ('5', 'Python', 'Pythondasdasdasdasdasdasda', '123457');
INSERT INTO `teacher_course` VALUES ('6', '大学英语', '大学bed发货就卡是否', '123456');

-- ----------------------------
-- Table structure for `teacher_work`
-- ----------------------------
DROP TABLE IF EXISTS `teacher_work`;
CREATE TABLE `teacher_work` (
  `twork_id` int(8) NOT NULL AUTO_INCREMENT COMMENT '作业ID',
  `twork_title` varchar(255) NOT NULL COMMENT '作业题目',
  `twork_content` text NOT NULL COMMENT '作业要求',
  `twork_date` varchar(255) NOT NULL COMMENT ' 发布时间',
  `twork_update` varchar(255) DEFAULT NULL,
  `course_id` int(12) unsigned NOT NULL COMMENT '课程号',
  PRIMARY KEY (`twork_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `fk_tw_course` FOREIGN KEY (`course_id`) REFERENCES `teacher_course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of teacher_work
-- ----------------------------
INSERT INTO `teacher_work` VALUES ('7', '第一次作业', '第一次作业第一次作业第一次作业第一次作业第一次作业x', '1475935215', '1476577675', '1');
INSERT INTO `teacher_work` VALUES ('8', '第二个测试作业', '啊是大家哈就是的好好打输了的话', '1475938377', null, '1');
INSERT INTO `teacher_work` VALUES ('9', 'MySQL的第一次作业', 'create MySQL table and learn how to query data by select', '1476600257', null, '2');

-- ----------------------------
-- Table structure for `twork_file`
-- ----------------------------
DROP TABLE IF EXISTS `twork_file`;
CREATE TABLE `twork_file` (
  `file_id` int(12) NOT NULL AUTO_INCREMENT,
  `twork_id` int(12) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_extension` varchar(255) NOT NULL,
  PRIMARY KEY (`file_id`),
  KEY `twork_id` (`twork_id`),
  CONSTRAINT `twork_file_ibfk_1` FOREIGN KEY (`twork_id`) REFERENCES `teacher_work` (`twork_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of twork_file
-- ----------------------------

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_number` int(12) NOT NULL COMMENT '用户ID',
  `user_name` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '姓名',
  `user_password` varchar(32) CHARACTER SET utf8 NOT NULL COMMENT '密码',
  `user_authKey` varchar(60) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`user_number`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('123456', '彭老师', 'e10adc3949ba59abbe56e057f20f883e', 'bVmjsZqDyl0ATFWDITQRA6el0SHPxpgC');
INSERT INTO `user` VALUES ('123457', 'teacher2', 'e10adc3949ba59abbe56e057f20f883e', '48mz4slUIBbirnkDnf_Qtqju0MFy6G4B');
INSERT INTO `user` VALUES ('141304120', 'Sanc', 'e10adc3949ba59abbe56e057f20f883e', 'zlJ4pKv0rW26jOE899-p_Ugi-9PxdhF_');
INSERT INTO `user` VALUES ('141304121', 'sancs', 'e10adc3949ba59abbe56e057f20f883e', '4QdIbGIC-2aEgC8kVqYyPtfNAndqKMBx');
INSERT INTO `user` VALUES ('141304122', '小明', 'e10adc3949ba59abbe56e057f20f883e', '4mFd6EmpEvc6DtfOx0i0BboyiEiJ7spw');
INSERT INTO `user` VALUES ('141304123', 'xiaohua', 'e10adc3949ba59abbe56e057f20f883e', '1Usdguug8j-AynHJ_qgQjtd3mkAeLdd1');
