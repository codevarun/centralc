CREATE TABLE IF NOT EXISTS `#__ohanah_events` (
  `ohanah_event_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ohanah_category_id` int(11) unsigned,
  `title` varchar(300) NOT NULL,
  `slug` varchar(300) NOT NULL,
  `description` text NOT NULL COMMENT '@Filter("html")',
  `header` varchar(500) NOT NULL,
  `date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `address` varchar(500) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `timezone` int(11) DEFAULT NULL,
  `geolocated_city` varchar(100) NOT NULL,
  `geolocated_country` varchar(30) NOT NULL,
  `geolocated_state` varchar(50) NOT NULL,
  `venue` varchar(255) NOT NULL,
  `ohanah_venue_id` int(11) unsigned,
  `limit_number_of_attendees` tinyint(1) NOT NULL DEFAULT '0',
  `attendees_limit` int(11) DEFAULT '0',
  `ticket_cost` varchar(10) DEFAULT NULL,
  `payment_currency` varchar(10) DEFAULT NULL,
  `frontendsubmission` tinyint(1) NOT NULL DEFAULT '0',
  `created_by_name` varchar(300) DEFAULT '',
  `created_by_email` varchar(300) DEFAULT '',
  `mailchimp_list_id` varchar(300) DEFAULT '',
  `customfields` mediumtext NOT NULL,
  `isRecurring` tinyint(1) NOT NULL DEFAULT '0',
  `everyNumber` int(11) NOT NULL DEFAULT '0',
  `everyWhat` varchar(10) NOT NULL DEFAULT '',
  `endOnDate` date DEFAULT NULL,
  `endAfterNumber` int(11) NOT NULL DEFAULT '0',
  `endAfterWhat` varchar(10) NOT NULL DEFAULT '',
  `recurringParent` int(11) NOT NULL DEFAULT '0',
  `picture` varchar(100) NOT NULL DEFAULT '',
  `frontend_submitted` TINYINT( 1 ) NOT NULL DEFAULT '0',
  `end_time_enabled` TINYINT( 1 ) NOT NULL DEFAULT '0',
  `who_can_register` TINYINT( 1 ) NOT NULL DEFAULT '0',
  `close_registration_day` DATE NOT NULL,
  `custom_payment_url` varchar(300) DEFAULT '',
  `custom_registration_url` varchar(300) DEFAULT '',
  `payment_gateway` varchar(20) DEFAULT '',
  `registration_system` varchar(20) DEFAULT '',
  `allow_only_one_ticket` TINYINT(1) DEFAULT 0,
  PRIMARY KEY (`ohanah_event_id`),
  UNIQUE KEY `slug` (slug(300))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ohanah_attachments` (
  `ohanah_attachment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `target_id` int(11) NOT NULL,
  `target_type` varchar(20) NOT NULL,
  PRIMARY KEY (`ohanah_attachment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ohanah_categories` (
  `ohanah_category_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(300) NOT NULL,
  `slug` varchar(300) NOT NULL,
  `description` text NOT NULL COMMENT '@Filter("html")',
  `enabled` tinyint(1) DEFAULT 1,  
  `picture` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`ohanah_category_id`),
  UNIQUE KEY `slug` (slug(300))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `#__ohanah_categories` (title, slug) VALUES (
  'Uncategorized',
  'uncategorized'
);

CREATE TABLE IF NOT EXISTS `#__ohanah_registrations` (
  `ohanah_registration_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ohanah_event_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `number_of_tickets` int(11) NOT NULL,
  `text` text NOT NULL,
  `notes` text NOT NULL,
  `created_by` int(11) unsigned NOT NULL,
  `created_on` datetime NOT NULL,
  `paid` TINYINT( 1 ) NOT NULL,
  `checked_in` TINYINT( 1 ) NOT NULL,
  `params` mediumtext NOT NULL,
  PRIMARY KEY (`ohanah_registration_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ohanah_venues` (
  `ohanah_venue_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL COMMENT '@Filter("html")',
  `address` varchar(500) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `timezone` int(11) NOT NULL,
  `geolocated_city` varchar(100) NOT NULL,
  `geolocated_country` varchar(30) NOT NULL,
  `geolocated_state` varchar(50) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `picture` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`ohanah_venue_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;