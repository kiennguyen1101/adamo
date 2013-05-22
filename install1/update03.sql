DROP TABLE IF EXISTS `myphpauction_option`;
CREATE TABLE IF NOT EXISTS `myphpauction_option` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '',
  `value` longtext NOT NULL,
  `autoload` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  INDEX ( `name` )
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;