/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : online_note

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-01-02 17:50:42
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `o_article`
-- ----------------------------
DROP TABLE IF EXISTS `o_article`;
CREATE TABLE `o_article` (
  `article_id` int(10) NOT NULL AUTO_INCREMENT,
  `article_title` varchar(255) DEFAULT NULL,
  `article_content` varchar(255) NOT NULL,
  `article_content_md` varchar(255) NOT NULL,
  `article_state` int(2) NOT NULL,
  `article_click` int(10) NOT NULL,
  `article_time` int(15) NOT NULL,
  `folder_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`article_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of o_article
-- ----------------------------
INSERT INTO `o_article` VALUES ('3', 'JavaScript', '<p>1asdcxasd</p>\n', '1asdcxasd', '1', '0', '1545300453', '1', '1');
INSERT INTO `o_article` VALUES ('4', 'this is new1', '<p>JavaScript   111</p>\n<pre><code class=\"lang-\"> function(){\n\n123123\nasdasd\n\n</code></pre>\n', 'JavaScript   111\n```\n function(){\n\n123123\nasdasd\n\n```\n', '2', '0', '1545300459', '1', '1');
INSERT INTO `o_article` VALUES ('5', 'this is', '<p>123</p>\n', '123', '1', '0', '1545384207', '2', '1');

-- ----------------------------
-- Table structure for `o_cate`
-- ----------------------------
DROP TABLE IF EXISTS `o_cate`;
CREATE TABLE `o_cate` (
  `cate_id` int(10) NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(100) DEFAULT NULL,
  `cate_pid` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of o_cate
-- ----------------------------
INSERT INTO `o_cate` VALUES ('1', 'web前端', '0', '1');
INSERT INTO `o_cate` VALUES ('2', 'javascript', '0', '1');
INSERT INTO `o_cate` VALUES ('3', 'jquery', '1', '1');
INSERT INTO `o_cate` VALUES ('4', '笔记', '1', '1');
INSERT INTO `o_cate` VALUES ('5', 'html', '4', '1');
INSERT INTO `o_cate` VALUES ('6', '12e34', '5', '1');

-- ----------------------------
-- Table structure for `o_folder`
-- ----------------------------
DROP TABLE IF EXISTS `o_folder`;
CREATE TABLE `o_folder` (
  `folder_id` int(10) NOT NULL AUTO_INCREMENT,
  `folder_name` varchar(50) NOT NULL,
  `folder_parentId` int(10) NOT NULL,
  `folder_level` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  PRIMARY KEY (`folder_id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of o_folder
-- ----------------------------
INSERT INTO `o_folder` VALUES ('1', '系列学习总计', '0', '1', '1');
INSERT INTO `o_folder` VALUES ('2', 'Vue22', '1', '2', '1');
INSERT INTO `o_folder` VALUES ('3', 'angular1', '1', '2', '1');
INSERT INTO `o_folder` VALUES ('4', '3online_Note1', '2', '3', '1');
INSERT INTO `o_folder` VALUES ('34', '新建文件夹', '3', '3', '1');
INSERT INTO `o_folder` VALUES ('35', '新建文件夹', '2', '3', '1');
INSERT INTO `o_folder` VALUES ('36', '新建文件夹', '2', '3', '1');
INSERT INTO `o_folder` VALUES ('31', '4级', '4', '4', '1');

-- ----------------------------
-- Table structure for `o_part`
-- ----------------------------
DROP TABLE IF EXISTS `o_part`;
CREATE TABLE `o_part` (
  `part_id` int(10) NOT NULL AUTO_INCREMENT,
  `part_name` varchar(50) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`part_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of o_part
-- ----------------------------
INSERT INTO `o_part` VALUES ('1', '前端相关笔记', '1');
INSERT INTO `o_part` VALUES ('3', '总结', '1');
INSERT INTO `o_part` VALUES ('4', 'html', '1');

-- ----------------------------
-- Table structure for `o_user`
-- ----------------------------
DROP TABLE IF EXISTS `o_user`;
CREATE TABLE `o_user` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) DEFAULT NULL,
  `user_phone` int(11) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_photo` varchar(255) NOT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `user_sex` int(1) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of o_user
-- ----------------------------
INSERT INTO `o_user` VALUES ('1', 'hesir22', '2147', '378504221@qq.com', '', '28fc2749e2c71d04b6f08df7128b73db', '1');
