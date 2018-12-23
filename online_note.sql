/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : online_note

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-12-21 08:55:01
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
  `article_content_code` varchar(255) NOT NULL,
  `article_click` int(10) NOT NULL,
  `article_time` int(15) NOT NULL,
  `folder_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`article_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of o_article
-- ----------------------------
INSERT INTO `o_article` VALUES ('3', '123123', '', '```\nfunction(){\nasdasdasd\n\n}\n```', '0', '1545300453', '1', '1');
INSERT INTO `o_article` VALUES ('4', '123412341', '', '', '0', '1545300459', '1', '1');

-- ----------------------------
-- Table structure for `o_folder`
-- ----------------------------
DROP TABLE IF EXISTS `o_folder`;
CREATE TABLE `o_folder` (
  `folder_id` int(10) NOT NULL AUTO_INCREMENT,
  `folder_name` varchar(50) DEFAULT NULL,
  `part_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`folder_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of o_folder
-- ----------------------------
INSERT INTO `o_folder` VALUES ('1', 'JavaScript', '1', '1');
INSERT INTO `o_folder` VALUES ('2', 'Vue2', '1', '1');

-- ----------------------------
-- Table structure for `o_part`
-- ----------------------------
DROP TABLE IF EXISTS `o_part`;
CREATE TABLE `o_part` (
  `part_id` int(10) NOT NULL AUTO_INCREMENT,
  `part_name` varchar(50) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`part_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of o_part
-- ----------------------------
INSERT INTO `o_part` VALUES ('1', '前端相关笔记', '1');
INSERT INTO `o_part` VALUES ('2', '123123', null);

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
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of o_user
-- ----------------------------
INSERT INTO `o_user` VALUES ('1', 'hesir22', '0', 'hesir22', '', '28fc2749e2c71d04b6f08df7128b73db');
