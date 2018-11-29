CREATE TABLE `marketplace_spas` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `version` varchar(100) NOT NULL DEFAULT '',
  `title` varchar(50) DEFAULT '',
  `token` varchar(50) DEFAULT '',
  `state` varchar(50) NOT NULL DEFAULT '',
  `license` varchar(250) DEFAULT '',
  `description` varchar(250) DEFAULT '',
  `file` varchar(100) NOT NULL DEFAULT '',
  `homepage` varchar(100) DEFAULT '',
  `creation_dtime` datetime DEFAULT '0000-00-00 00:00:00',
  `modif_dtime` datetime DEFAULT '0000-00-00 00:00:00',
  `tenant` mediumint(9) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_unique_idx` (`tenant`,`name`),
  KEY `tenant_foreignkey_idx` (`tenant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `marketplace_templates` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(64) NOT NULL DEFAULT '',
  `state` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(64) NOT NULL DEFAULT '',
  `title` varchar(250) NOT NULL DEFAULT 'no title',
  `description` varchar(250) NOT NULL DEFAULT 'auto created template',
  `mime_type` varchar(64) NOT NULL DEFAULT 'application/octet-stream',
  `file_path` varchar(250) NOT NULL DEFAULT '',
  `file_name` varchar(250) NOT NULL DEFAULT 'unknown',
  `file_size` int(11) NOT NULL DEFAULT 0,
  `downloads` int(11) NOT NULL DEFAULT 0,
  `creation_dtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modif_dtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tenant` mediumint(9) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `name_idx` (`tenant`,`name`),
  KEY `mime_type_idx` (`tenant`,`mime_type`),
  KEY `tenant_foreignkey_idx` (`tenant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
