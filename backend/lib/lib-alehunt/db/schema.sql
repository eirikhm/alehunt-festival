DROP TABLE IF EXISTS `tbl_migration`;
DROP TABLE IF EXISTS `event`;
DROP TABLE IF EXISTS `venue_beer`;
DROP TABLE IF EXISTS `venue`;
DROP TABLE IF EXISTS `beer`;
DROP TABLE IF EXISTS `brewer`;
DROP TABLE IF EXISTS `beer_type`;

DROP TABLE IF EXISTS `country`;

CREATE TABLE IF NOT EXISTS country (
  iso CHAR(2) NOT NULL PRIMARY KEY,
  name VARCHAR(80) NOT NULL,
  printable_name VARCHAR(80) NOT NULL,
  iso3 CHAR(3),
  numcode int
) ENGINE=InnoDb DEFAULT CHARSET=utf8;

CREATE TABLE `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8;

CREATE TABLE `beer_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `beer_type_ref_beer_type` FOREIGN KEY (`parent`) REFERENCES `beer_type` (`id`)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `brewer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `created` datetime DEFAULT NULL,
  `country_id` char(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `brewer_ref_country` FOREIGN KEY (`country_id`) REFERENCES `country` (`iso`)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


CREATE TABLE `beer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `brewer_id` int(11) DEFAULT NULL,
  `beer_type_id` int(11) DEFAULT NULL,
  `abv` float DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `beer_ref_brewer_id` FOREIGN KEY (`brewer_id`) REFERENCES `brewer` (`id`),
  CONSTRAINT `beer_ref_beer_type` FOREIGN KEY (`beer_type_id`) REFERENCES `beer_type` (`id`)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `venue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `description` text,
  `created` datetime DEFAULT NULL,
  `country_id` char(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `venue_ref_country` FOREIGN KEY (`country_id`) REFERENCES `country` (`iso`)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


CREATE TABLE `venue_beer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `venue_id` int(11) DEFAULT NULL,
  `beer_id` int(11) DEFAULT NULL,
  `unit_type` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `venue_beer_ref_beer` FOREIGN KEY (`beer_id`) REFERENCES `beer` (`id`),
  CONSTRAINT `venue_beer_ref_venue` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`id`)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;



CREATE TABLE `user_logbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `beer_id` int(11) NOT NULL,

  `venue_id` int(11) DEFAULT NULL,
  `unit_type` int(11) DEFAULT NULL,
  `batch` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `appearance` text DEFAULT NULL,
  `aroma` text DEFAULT NULL,
  `taste` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `logbook_ref_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `logbook_ref_beer` FOREIGN KEY (`beer_id`) REFERENCES `beer` (`id`),
  CONSTRAINT `logbook_ref_venue` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`id`)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `param` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


DROP TABLE city;
CREATE TABLE `city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code_name` varchar(255) NOT NULL,
  `country_id` char(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_key` (`code_name`),
  CONSTRAINT `city_ref_country` FOREIGN KEY (`country_id`) REFERENCES `country` (`iso`)
) ENGINE=InnoDb AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;