# Host: localhost  (Version: 5.5.38)
# Date: 2015-06-10 08:08:04
# Generator: MySQL-Front 5.3  (Build 4.120)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "point_server"
#

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "point_server"
#

/*!40000 ALTER TABLE `point_server` DISABLE KEYS */;
INSERT INTO `point_server` VALUES (1,'10.0.13.58',80,2,'1','10ce467d32964f07039320e3bc4f42d7');
/*!40000 ALTER TABLE `point_server` ENABLE KEYS */;

#
# Structure for table "scan_list"
#

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "scan_list"
#

/*!40000 ALTER TABLE `scan_list` DISABLE KEYS */;
INSERT INTO `scan_list` VALUES (1,'http://10.0.140.148:8080/eomp/loginmgmt/frame.action','2015-06-09','x','10.0.13.58','','4','aa','aa','a','ok','4e2311c9ea164ce9fe2f15f000b97d14');
/*!40000 ALTER TABLE `scan_list` ENABLE KEYS */;

#
# Structure for table "target_info"
#

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "target_info"
#

/*!40000 ALTER TABLE `target_info` DISABLE KEYS */;
INSERT INTO `target_info` VALUES (1,'http://10.0.140.148:8080/eomp/loginmgmt/frame.action',NULL,'2 minutes, 53 seconds','9/6/2015, 17:06:53','Apache-Coyote/1.1','True','Unknown','Array','4e2311c9ea164ce9fe2f15f000b97d14');
/*!40000 ALTER TABLE `target_info` ENABLE KEYS */;

#
# Structure for table "target_vul"
#

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "target_vul"
#

/*!40000 ALTER TABLE `target_vul` DISABLE KEYS */;
INSERT INTO `target_vul` VALUES (1,'Cookie without HttpOnly flag set','Crawler','Cookie name: <font color=\"dark\">&quot;JSESSIONID&quot;</font><br/>Cookie domain: <font color=\"dark\">&quot;10.0.140.148&quot;</font><br/>','/','Array','low','GET / HTTP/1.1\r\n\r\n','  \r\n','4e2311c9ea164ce9fe2f15f000b97d14','41a0e3c92680909af0a7a49b97158467'),(2,'OPTIONS method is enabled','Scripting (Options_Server_Method.script)','Methods allowed: <font color=\"dark\"><b>GET, HEAD, POST, PUT, DELETE, TRACE, OPTIONS</b></font>','Web Server','Array','low','OPTIONS / HTTP/1.1\r\nCookie: JSESSIONID=9D7EFED10AFF7E4359B84B843457869C\r\nHost: 10.0.140.148:8080\r\nConnection: Keep-alive\r\nAccept-Encoding: gzip,deflate\r\nUser-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.63 Safari/537.36\r\nAccept: */*\r\n\r\n','HTTP/1.1 200 OK\r\nServer: Apache-Coyote/1.1\r\nAllow: GET, HEAD, POST, PUT, DELETE, TRACE, OPTIONS\r\nContent-Length: 0\r\nDate: Tue, 09 Jun 2015 09:04:00 GMT\r\n','4e2311c9ea164ce9fe2f15f000b97d14','055bf03fcaa50607e124302f9e6f1e58'),(3,'Java Debug Wire Protocol remote code execution','Scripting (Java_Debug_Wire_Protocol_Audit.script)','Server responded on port <b>8787</b> with JDWP handshake magic string: <font color=\"dark\">JDWP-Handshake</font>','Web Server','Array','high','Array','Array','4e2311c9ea164ce9fe2f15f000b97d14','2da48c3aab05efb2ec50410490efa232');
/*!40000 ALTER TABLE `target_vul` ENABLE KEYS */;

#
# Structure for table "user"
#

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

#
# Data for table "user"
#

/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'x','123456','admin@scan.com','10086','1432882109','1433894653',NULL,'1');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
