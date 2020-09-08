# ************************************************************
# Sequel Pro SQL dump
# Версия 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Адрес: 127.0.0.1 (MySQL 5.5.5-10.3.22-MariaDB-1:10.3.22+maria~bionic)
# Схема: skimp
# Время создания: 2020-09-08 08:53:55 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Дамп таблицы contents
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contents`;

CREATE TABLE `contents` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `caption` varchar(255) NOT NULL DEFAULT '',
  `cdate` datetime DEFAULT NULL,
  `type` enum('file','db','catalog') NOT NULL DEFAULT 'file',
  `path` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `description_image` varchar(255) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `content_title` varchar(255) DEFAULT NULL,
  `content_image` varchar(255) DEFAULT NULL,
  `lang` varchar(2) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_schema` text DEFAULT NULL,
  `og_type` varchar(32) DEFAULT 'article',
  `og_image` varchar(255) DEFAULT NULL,
  `section` varchar(32) DEFAULT NULL,
  `template` varchar(32) DEFAULT NULL,
  `items` varchar(32) DEFAULT NULL,
  `breadcrumb` text DEFAULT NULL,
  `options` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `contents` WRITE;
/*!40000 ALTER TABLE `contents` DISABLE KEYS */;

INSERT INTO `contents` (`id`, `caption`, `cdate`, `type`, `path`, `description`, `description_image`, `content`, `content_title`, `content_image`, `lang`, `url`, `meta_keywords`, `meta_description`, `meta_title`, `meta_schema`, `og_type`, `og_image`, `section`, `template`, `items`, `breadcrumb`, `options`)
VALUES
	(1,'Terms of use','2016-01-06 14:02:48','file','terms_of_use_en',NULL,NULL,NULL,NULL,NULL,'en','/',NULL,NULL,NULL,NULL,'article',NULL,'document',NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `contents` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы contents_tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contents_tags`;

CREATE TABLE `contents_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caption` varchar(255) NOT NULL,
  `ident` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL,
  `cdate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы contents2contents_tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contents2contents_tags`;

CREATE TABLE `contents2contents_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_content` int(11) NOT NULL,
  `id_tag` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы contents2users_types
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contents2users_types`;

CREATE TABLE `contents2users_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_content` int(11) NOT NULL,
  `id_type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы failed_jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Дамп таблицы festi_listeners
# ------------------------------------------------------------

DROP TABLE IF EXISTS `festi_listeners`;

CREATE TABLE `festi_listeners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `plugin` varchar(32) NOT NULL,
  `method` varchar(64) NOT NULL,
  `callback_plugin` varchar(32) NOT NULL,
  `callback_method` varchar(64) NOT NULL,
  `url_area` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `plugin` (`plugin`),
  KEY `callback_plugin` (`callback_plugin`),
  KEY `id_url_area` (`url_area`),
  CONSTRAINT `festi_listeners_ibfk_1` FOREIGN KEY (`plugin`) REFERENCES `festi_plugins` (`ident`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `festi_listeners_ibfk_2` FOREIGN KEY (`callback_plugin`) REFERENCES `festi_plugins` (`ident`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `festi_listeners_ibfk_3` FOREIGN KEY (`url_area`) REFERENCES `festi_url_areas` (`ident`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы festi_menu_permissions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `festi_menu_permissions`;

CREATE TABLE `festi_menu_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_role` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `festi_menu_permissions` WRITE;
/*!40000 ALTER TABLE `festi_menu_permissions` DISABLE KEYS */;

INSERT INTO `festi_menu_permissions` (`id`, `id_role`, `id_menu`)
VALUES
	(3,1,2),
	(21,1,1),
	(22,1,3);

/*!40000 ALTER TABLE `festi_menu_permissions` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы festi_menus
# ------------------------------------------------------------

DROP TABLE IF EXISTS `festi_menus`;

CREATE TABLE `festi_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caption` varchar(64) NOT NULL,
  `url` varchar(64) DEFAULT NULL,
  `id_parent` int(11) DEFAULT NULL,
  `order_n` int(11) NOT NULL,
  `description` varchar(128) DEFAULT NULL,
  `id_section` int(10) unsigned DEFAULT NULL,
  `area` varchar(32) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_section` (`id_section`),
  KEY `area` (`area`),
  CONSTRAINT `festi_menus_ibfk_1` FOREIGN KEY (`id_section`) REFERENCES `festi_sections` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `festi_menus_ibfk_2` FOREIGN KEY (`area`) REFERENCES `festi_url_areas` (`ident`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

LOCK TABLES `festi_menus` WRITE;
/*!40000 ALTER TABLE `festi_menus` DISABLE KEYS */;

INSERT INTO `festi_menus` (`id`, `caption`, `url`, `id_parent`, `order_n`, `description`, `id_section`, `area`, `icon`)
VALUES
	(1,'Hosts','/table/host',NULL,2,NULL,NULL,NULL,'dns'),
	(2,'Links','/table/shortener',NULL,1,NULL,NULL,NULL,'link'),
	(3,'Imports','/table/imports/',NULL,3,NULL,NULL,NULL,'cloud_download'),
	(4,'Menu','/table/menu',NULL,4,NULL,NULL,NULL,'menus');

/*!40000 ALTER TABLE `festi_menus` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы festi_plugins
# ------------------------------------------------------------

DROP TABLE IF EXISTS `festi_plugins`;

CREATE TABLE `festi_plugins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` enum('active','hidden') NOT NULL DEFAULT 'active',
  `ident` varchar(32) NOT NULL,
  `version` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ident` (`ident`),
  UNIQUE KEY `ident_2` (`ident`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `festi_plugins` WRITE;
/*!40000 ALTER TABLE `festi_plugins` DISABLE KEYS */;

INSERT INTO `festi_plugins` (`id`, `status`, `ident`, `version`)
VALUES
	(1,'active','Contents',NULL),
	(2,'active','Jimbo',NULL);

/*!40000 ALTER TABLE `festi_plugins` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы festi_section_actions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `festi_section_actions`;

CREATE TABLE `festi_section_actions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_section` int(10) unsigned NOT NULL,
  `plugin` varchar(32) NOT NULL,
  `method` varchar(64) NOT NULL,
  `mask` enum('2','4','6') NOT NULL DEFAULT '2',
  `comment` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `plugin` (`plugin`,`method`,`id_section`),
  KEY `id_action` (`id_section`),
  KEY `id` (`id`),
  KEY `mask` (`mask`),
  KEY `method` (`method`),
  CONSTRAINT `festi_section_actions_ibfk_1` FOREIGN KEY (`id_section`) REFERENCES `festi_sections` (`id`) ON UPDATE NO ACTION,
  CONSTRAINT `festi_section_actions_ibfk_2` FOREIGN KEY (`plugin`) REFERENCES `festi_plugins` (`ident`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы festi_sections
# ------------------------------------------------------------

DROP TABLE IF EXISTS `festi_sections`;

CREATE TABLE `festi_sections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `caption` varchar(64) NOT NULL,
  `ident` varchar(32) NOT NULL,
  `mask` enum('2','4','6') NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы festi_sections_user_permission
# ------------------------------------------------------------

DROP TABLE IF EXISTS `festi_sections_user_permission`;

CREATE TABLE `festi_sections_user_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_section` int(10) unsigned NOT NULL,
  `id_user` int(10) unsigned NOT NULL,
  `value` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_action_2` (`id_section`,`id_user`),
  KEY `id_action` (`id_section`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `festi_sections_user_permission_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users_` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `festi_sections_user_permission_ibfk_3` FOREIGN KEY (`id_section`) REFERENCES `festi_sections` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы festi_sections_user_types_permission
# ------------------------------------------------------------

DROP TABLE IF EXISTS `festi_sections_user_types_permission`;

CREATE TABLE `festi_sections_user_types_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_section` int(10) unsigned NOT NULL,
  `id_user_type` int(10) unsigned NOT NULL,
  `value` int(11) NOT NULL DEFAULT 2,
  PRIMARY KEY (`id`),
  KEY `id_section` (`id_section`),
  CONSTRAINT `festi_sections_user_types_permission_ibfk_1` FOREIGN KEY (`id_section`) REFERENCES `festi_sections` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы festi_settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `festi_settings`;

CREATE TABLE `festi_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caption` varchar(255) NOT NULL,
  `name` varchar(32) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `festi_settings` WRITE;
/*!40000 ALTER TABLE `festi_settings` DISABLE KEYS */;

INSERT INTO `festi_settings` (`id`, `caption`, `name`, `value`)
VALUES
	(5,'','auth_login_column','login'),
	(6,'','auth_pass_column','pass'),
	(7,'','users_table','users'),
	(8,'','users_types_table','users_types'),
	(9,'','auth_role_column','id_type'),
	(10,'','js_version','1'),
	(11,'','site_caption','Festi'),
	(12,'','host','skimp.tk');

/*!40000 ALTER TABLE `festi_settings` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы festi_texts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `festi_texts`;

CREATE TABLE `festi_texts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ident` varchar(32) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы festi_url_areas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `festi_url_areas`;

CREATE TABLE `festi_url_areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ident` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ident` (`ident`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `festi_url_areas` WRITE;
/*!40000 ALTER TABLE `festi_url_areas` DISABLE KEYS */;

INSERT INTO `festi_url_areas` (`id`, `ident`)
VALUES
	(1,'backend'),
	(2,'default');

/*!40000 ALTER TABLE `festi_url_areas` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы festi_url_rules
# ------------------------------------------------------------

DROP TABLE IF EXISTS `festi_url_rules`;

CREATE TABLE `festi_url_rules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `plugin` varchar(32) NOT NULL,
  `pattern` varchar(255) NOT NULL,
  `method` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `plugin` (`plugin`),
  CONSTRAINT `festi_url_rules_ibfk_1` FOREIGN KEY (`plugin`) REFERENCES `festi_plugins` (`ident`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `festi_url_rules` WRITE;
/*!40000 ALTER TABLE `festi_url_rules` DISABLE KEYS */;

INSERT INTO `festi_url_rules` (`id`, `plugin`, `pattern`, `method`)
VALUES
	(1,'Contents',' ~^/manage/contents/$~','onDisplayManagePage'),
	(2,'Jimbo',' ~^/$~','onDisplayDefault'),
	(3,'Jimbo',' ~^/login/$~','onDisplaySignin'),
	(4,'Jimbo',' ~^/logout/$~','onDisplayLogout'),
	(5,'Contents','~^/(.*)$~','onDisplayPage');

/*!40000 ALTER TABLE `festi_url_rules` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы festi_url_rules2areas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `festi_url_rules2areas`;

CREATE TABLE `festi_url_rules2areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_url_rule` int(10) unsigned NOT NULL,
  `area` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_url_rule` (`id_url_rule`,`area`),
  KEY `area` (`area`),
  CONSTRAINT `festi_url_rules2areas_ibfk_1` FOREIGN KEY (`area`) REFERENCES `festi_url_areas` (`ident`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `festi_url_rules2areas` WRITE;
/*!40000 ALTER TABLE `festi_url_rules2areas` DISABLE KEYS */;

INSERT INTO `festi_url_rules2areas` (`id`, `id_url_rule`, `area`)
VALUES
	(1,2,'backend'),
	(2,3,'backend'),
	(3,4,'backend'),
	(4,5,'default');

/*!40000 ALTER TABLE `festi_url_rules2areas` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(1,'2014_10_12_000000_create_users_table',1),
	(2,'2019_08_19_000000_create_failed_jobs_table',1);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы shortener_hosts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `shortener_hosts`;

CREATE TABLE `shortener_hosts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `host` varchar(128) DEFAULT NULL,
  `cdate` timestamp NULL DEFAULT current_timestamp(),
  `mdate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `host` (`host`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `shortener_hosts` WRITE;
/*!40000 ALTER TABLE `shortener_hosts` DISABLE KEYS */;

INSERT INTO `shortener_hosts` (`id`, `host`, `cdate`, `mdate`)
VALUES
	(1,'https://skimp.tk.local','2020-04-14 14:23:16',NULL);

/*!40000 ALTER TABLE `shortener_hosts` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы shortener_imports
# ------------------------------------------------------------

DROP TABLE IF EXISTS `shortener_imports`;

CREATE TABLE `shortener_imports` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `host` varchar(128) DEFAULT NULL,
  `file_input` varchar(255) DEFAULT NULL,
  `file_output` varchar(255) DEFAULT '',
  `status` enum('waiting','in_progress','ready','error') DEFAULT NULL,
  `count` int(11) unsigned DEFAULT NULL,
  `error` text DEFAULT NULL,
  `cdate` timestamp NULL DEFAULT current_timestamp(),
  `mdate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `host` (`host`),
  CONSTRAINT `shortener_imports_ibfk_1` FOREIGN KEY (`host`) REFERENCES `shortener_hosts` (`host`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы shortener_links
# ------------------------------------------------------------

DROP TABLE IF EXISTS `shortener_links`;

CREATE TABLE `shortener_links` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `host` varchar(128) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `code` varchar(32) DEFAULT NULL,
  `view_count` int(11) DEFAULT NULL,
  `id_import` int(11) unsigned DEFAULT NULL,
  `cdate` timestamp NULL DEFAULT current_timestamp(),
  `mdate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `code_2` (`code`),
  KEY `host` (`host`),
  KEY `id_import` (`id_import`),
  CONSTRAINT `shortener_links_ibfk_1` FOREIGN KEY (`host`) REFERENCES `shortener_hosts` (`host`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `shortener_links_ibfk_2` FOREIGN KEY (`id_import`) REFERENCES `shortener_imports` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `shortener_links` WRITE;
/*!40000 ALTER TABLE `shortener_links` DISABLE KEYS */;

INSERT INTO `shortener_links` (`id`, `host`, `link`, `code`, `view_count`, `id_import`, `cdate`, `mdate`)
VALUES
	(1,'https://skimp.tk.local','https://facebook.com','x2',0,NULL,'2020-07-20 09:52:00','2020-04-28 10:37:30'),
	(2,'https://skimp.tk.local','https://google.com','x3',0,NULL,'2020-07-03 09:52:00',NULL),
	(4,'https://skimp.tk.local','https://habr.com','x5',NULL,NULL,'2020-07-20 09:52:00',NULL),
	(18,'https://skimp.tk.local','https://short.com','x9',NULL,NULL,'2020-07-24 09:52:00',NULL),
	(19,'https://skimp.tk.local','https://new.domain.com/1','x11',NULL,NULL,'2020-07-24 09:52:00',NULL),
	(20,'https://skimp.tk.local','https://new.test.20.domain.com/12/','x24',NULL,NULL,'2020-07-24 09:52:00',NULL),
	(25,'https://skimp.tk.local','http://google.com/aaa','x1887',NULL,NULL,NULL,NULL),
	(26,'https://skimp.tk.local','https://nfs.com/','x7171',NULL,NULL,'2020-07-24 09:52:00',NULL),
	(27,'https://skimp.tk.local','https://nfs.com/123/23/22','x5160',NULL,NULL,'2020-07-24 09:52:00',NULL),
	(29,'https://skimp.tk.local','https://nfs.com/333333/222/133/111','x7254',NULL,NULL,'2020-09-07 09:40:36',NULL),
	(33,'https://skimp.tk.local','http://nnn.com/asd','x824',NULL,NULL,'2020-09-07 13:07:49',NULL);

/*!40000 ALTER TABLE `shortener_links` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы shortener_statistics
# ------------------------------------------------------------

DROP TABLE IF EXISTS `shortener_statistics`;

CREATE TABLE `shortener_statistics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_link` int(11) unsigned DEFAULT NULL,
  `ip` varchar(15) DEFAULT '',
  `referer` varchar(255) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `server` longtext DEFAULT NULL,
  `cdate` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_link` (`id_link`),
  CONSTRAINT `shortener_statistics_ibfk_1` FOREIGN KEY (`id_link`) REFERENCES `shortener_links` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`)
VALUES
	(1,'Admin','demo@demo.com',NULL,'e00cf25ad42683b3df678c61f42c6bda','99d6ad5babb5aaa455feb4215d9399d7','2020-09-08 06:34:41','2020-09-08 06:34:41');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы users_
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users_`;

CREATE TABLE `users_` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_type` int(11) unsigned NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `lastname` varchar(64) DEFAULT NULL,
  `login` varchar(128) DEFAULT NULL,
  `pass` varchar(32) NOT NULL,
  `email` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `id_type` (`id_type`),
  KEY `login` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users_` WRITE;
/*!40000 ALTER TABLE `users_` DISABLE KEYS */;

INSERT INTO `users_` (`id`, `id_type`, `name`, `lastname`, `login`, `pass`, `email`)
VALUES
	(1,1,NULL,NULL,'admin','21232f297a57a5a743894a0e4a801fc3','demo@test.com');

/*!40000 ALTER TABLE `users_` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы users_types
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users_types`;

CREATE TABLE `users_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `caption` varchar(128) NOT NULL,
  `ident` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ident` (`ident`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users_types` WRITE;
/*!40000 ALTER TABLE `users_types` DISABLE KEYS */;

INSERT INTO `users_types` (`id`, `caption`, `ident`)
VALUES
	(1,'Admin','admin'),
	(2,'User','user');

/*!40000 ALTER TABLE `users_types` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
