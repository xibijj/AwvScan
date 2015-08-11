/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50704
Source Host           : localhost:3306
Source Database       : wvs_scan

Target Server Type    : MYSQL
Target Server Version : 50704
File Encoding         : 65001

Date: 2015-05-30 21:58:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `point_server`
-- ----------------------------
DROP TABLE IF EXISTS `point_server`;
CREATE TABLE `point_server` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pointip` varchar(15) DEFAULT NULL,
  `pointport` int(5) DEFAULT '80',
  `level` int(2) DEFAULT '0',
  `status` varchar(10) DEFAULT NULL,
  `hash` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash` (`hash`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of point_server
-- ----------------------------

-- ----------------------------
-- Table structure for `scan_list`
-- ----------------------------
DROP TABLE IF EXISTS `scan_list`;
CREATE TABLE `scan_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `createtime` varchar(50) DEFAULT NULL,
  `user` varchar(10) DEFAULT NULL,
  `pointserver` varchar(15) DEFAULT NULL,
  `group` varchar(20) DEFAULT NULL,
  `rule` varchar(10) DEFAULT NULL,
  `siteuser` varchar(50) DEFAULT NULL,
  `sitepwd` varchar(50) DEFAULT NULL,
  `cookie` text,
  `status` varchar(10) DEFAULT NULL,
  `hash` varchar(32) NOT NULL,
  PRIMARY KEY (`id`,`hash`),
  UNIQUE KEY `hash` (`hash`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of scan_list
-- ----------------------------

-- ----------------------------
-- Table structure for `target_info`
-- ----------------------------
DROP TABLE IF EXISTS `target_info`;
CREATE TABLE `target_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `user` varchar(10) DEFAULT NULL,
  `scantime` varchar(50) DEFAULT NULL,
  `finishtime` varchar(50) DEFAULT NULL,
  `banner` varchar(50) DEFAULT NULL,
  `responsive` varchar(10) DEFAULT NULL,
  `os` varchar(50) DEFAULT NULL,
  `technologies` varchar(50) DEFAULT NULL,
  `hash` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash` (`hash`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of target_info
-- ----------------------------

-- ----------------------------
-- Table structure for `target_vul`
-- ----------------------------
DROP TABLE IF EXISTS `target_vul`;
CREATE TABLE `target_vul` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `modulename` varchar(100) DEFAULT NULL,
  `details` text,
  `affects` varchar(255) DEFAULT NULL,
  `parameter` varchar(50) DEFAULT NULL,
  `severity` varchar(10) DEFAULT NULL,
  `request` text,
  `response` text,
  `hash` varchar(32) DEFAULT NULL,
  `unique` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`unique`),
  KEY `hash` (`hash`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of target_vul
-- ----------------------------

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(10) DEFAULT NULL,
  `passwd` varchar(32) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `ctime` varchar(50) DEFAULT NULL,
  `lasttime` varchar(50) DEFAULT NULL,
  `group` varchar(10) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'x', '123456', 'admin@scan.com', '10086', '1432882109', null, null, '1');
