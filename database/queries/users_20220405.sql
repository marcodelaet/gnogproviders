/*
SQLyog Community v13.1.9 (64 bit)
MySQL - 5.6.51-cll-lve : Database - gnogcrm_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`gnogcrm_db` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `gnogcrm_db`;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` varchar(40) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(60) NOT NULL,
  `mobile_international_code` varchar(3) DEFAULT NULL,
  `mobile_prefix` varchar(3) DEFAULT NULL,
  `mobile_number` varchar(12) DEFAULT NULL,
  `authentication_string` varchar(32) NOT NULL,
  `password_last_changed` datetime DEFAULT NULL,
  `token` varchar(250) DEFAULT NULL,
  `account_locked` enum('N','Y') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`email`,`mobile_international_code`,`mobile_prefix`,`mobile_number`,`authentication_string`,`password_last_changed`,`token`,`account_locked`,`created_at`,`updated_at`) values 
('674e9ab8-7af1-11ec-aa0b-008cfa5abdac','eduardo','eduardo@gnog.com.mx','52',NULL,'5548557291','e10adc3949ba59abbe56e057f20f883e',NULL,'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2NDgyMzA3NTgsInVpZCI6IjY3NGU5YWI4LTdhZjEtMTFlYy1hYTBiLTAwOGNmYTVhYmRhYyIsImVtYWlsIjoiZWR1YXJkb0Bnbm9nLmNvbS5teCJ9.4syMW9n8jcNrlwrnMJKQsCvUSxGroTzVsC24bfbgfl4=','N','2022-01-21 12:36:17','2022-01-28 12:35:15'),
('958eb862-7584-11ec-b3bb-008cfa5abdac','fernando','fernando@gnog.com.mx','52',NULL,'5559974544','878d8fbbdbc150e18596393858cafc42','2022-01-21 12:41:09','eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2NDQ4NjU2NjEsInVpZCI6Ijk1OGViODYyLTc1ODQtMTFlYy1iM2JiLTAwOGNmYTVhYmRhYyIsImVtYWlsIjoiZmVybmFuZG9AZ25vZy5jb20ubXgifQ==.q6f7XAZV94WZ0VNhznQpG8mAMifEPp3/cH0AAPtHwIA=','N','2022-01-14 14:54:44','2022-01-21 12:41:09'),
('99770fe9-b1f1-11ec-b66b-008cfa5abdac','juan','juan@gnog.com.mx','52',NULL,'5599999999','14be5326d74625082654f13b40e6944e',NULL,'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2NDg4NDExOTgsInVpZCI6Ijk5NzcwZmU5LWIxZjEtMTFlYy1iNjZiLTAwOGNmYTVhYmRhYyIsImVtYWlsIjoianVhbkBnbm9nLmNvbS5teCJ9./tM0+spofOCenVDv88H+vr409MiyKc+RAwt2s9Wb5NI=','N','2022-04-01 12:26:16','2022-04-01 12:26:16'),
('a8e03016-7af1-11ec-aa0b-008cfa5abdac','esteph','estephanie@gnog.com.mx','52',NULL,'5599999999','df10ef8509dc176d733d59549e7dbfaf','2022-03-30 10:45:18',NULL,'N','2022-01-21 12:38:08','2022-03-30 10:45:18'),
('a9d0f448-7580-11ec-b3bb-008cfa5abdac','marcodelaet','marco@delaet.com.br','55','11','11989348999','e10adc3949ba59abbe56e057f20f883e',NULL,'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2NDg4NDExMjIsInVpZCI6ImE5ZDBmNDQ4LTc1ODAtMTFlYy1iM2JiLTAwOGNmYTVhYmRhYyIsImVtYWlsIjoibWFyY29AZGVsYWV0LmNvbS5iciJ9.Y1Cy6iz5MP8vrkGECY8ll4XNBbMqejqPLIt0CGmgNTQ=','N','2022-01-14 14:28:36','2022-01-14 14:48:51'),
('bf2e276f-7af1-11ec-aa0b-008cfa5abdac','daniel','daniel@gnog.com.mx','52',NULL,'5512434534','30076bf6a5e4bd7d4aee18ad9c603710','2022-01-28 12:33:35','eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2NDg4MzczNjksInVpZCI6ImJmMmUyNzZmLTdhZjEtMTFlYy1hYTBiLTAwOGNmYTVhYmRhYyIsImVtYWlsIjoiZGFuaWVsQGdub2cuY29tLm14In0=.YAf6RgOcumI4eI7/k9SRla/7MReut5jGvd4bgWvZqPo=','N','2022-01-21 12:38:45','2022-01-28 12:33:35'),
('e6d72833-7af1-11ec-aa0b-008cfa5abdac','fernanda','fernanda.rosas@gnog.com.mx','52',NULL,'5531175602','e10adc3949ba59abbe56e057f20f883e',NULL,'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2NDMzOTgwODIsInVpZCI6ImU2ZDcyODMzLTdhZjEtMTFlYy1hYTBiLTAwOGNmYTVhYmRhYyIsImVtYWlsIjoiZmVybmFuZGEucm9zYXNAZ25vZy5jb20ubXgifQ==.11yBeswtAOjDnXpuFw6iMoFgXWOpM65AcPYWLHf6X/E=','N','2022-01-21 12:39:52','2022-01-28 12:28:23');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
