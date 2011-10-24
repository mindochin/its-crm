-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Окт 24 2011 г., 23:12
-- Версия сервера: 5.1.41
-- Версия PHP: 5.3.2-1ubuntu4.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `its-crm-new`
--

-- --------------------------------------------------------

--
-- Структура таблицы `AuthAssignment`
--

CREATE TABLE IF NOT EXISTS `AuthAssignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `AuthItem`
--

CREATE TABLE IF NOT EXISTS `AuthItem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `AuthItemChild`
--

CREATE TABLE IF NOT EXISTS `AuthItemChild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `itscrm_acts`
--

CREATE TABLE IF NOT EXISTS `itscrm_acts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT '0',
  `client_id` int(11) NOT NULL DEFAULT '0',
  `template_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `sum` float(11,2) NOT NULL DEFAULT '0.00',
  `num` varchar(50) DEFAULT NULL,
  `body` text NOT NULL,
  `note` text,
  `is_sign` enum('n','y') NOT NULL DEFAULT 'n',
  PRIMARY KEY (`id`),
  KEY `is_sign` (`is_sign`),
  KEY `order_id` (`order_id`),
  KEY `client_id` (`client_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

-- --------------------------------------------------------

--
-- Структура таблицы `itscrm_acts_tmpl`
--

CREATE TABLE IF NOT EXISTS `itscrm_acts_tmpl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Структура таблицы `itscrm_clients`
--

CREATE TABLE IF NOT EXISTS `itscrm_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `fullname` varchar(255) NOT NULL DEFAULT '',
  `requisite` text,
  `address` text,
  `contactdata` text,
  `headpost` varchar(255) DEFAULT NULL,
  `headfio` varchar(255) DEFAULT NULL,
  `headbasis` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Структура таблицы `itscrm_config`
--

CREATE TABLE IF NOT EXISTS `itscrm_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(100) NOT NULL,
  `value` text NOT NULL,
  `desc` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Структура таблицы `itscrm_contacts`
--

CREATE TABLE IF NOT EXISTS `itscrm_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `post` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `icq` varchar(255) DEFAULT NULL,
  `note` text,
  `client_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `person_name` (`name`),
  KEY `client_id` (`client_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Структура таблицы `itscrm_contracts`
--

CREATE TABLE IF NOT EXISTS `itscrm_contracts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `num` varchar(50) DEFAULT NULL,
  `date` date NOT NULL,
  `client_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `note` text,
  `duedate` date DEFAULT NULL,
  `autoprolonged` enum('yes','no') DEFAULT 'no',
  `template_id` int(11) NOT NULL,
  `body` text NOT NULL,
  `sum` float(11,2) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `is_sign` enum('n','y') NOT NULL DEFAULT 'n',
  PRIMARY KEY (`id`),
  KEY `is_sign` (`is_sign`),
  KEY `order_id` (`order_id`),
  KEY `client_id` (`client_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=68 ;

-- --------------------------------------------------------

--
-- Структура таблицы `itscrm_contracts_tmpl`
--

CREATE TABLE IF NOT EXISTS `itscrm_contracts_tmpl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Структура таблицы `itscrm_invoices`
--

CREATE TABLE IF NOT EXISTS `itscrm_invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `act_id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `sum` float(11,2) NOT NULL,
  `num` varchar(100) NOT NULL,
  `note` text,
  `is_paid` enum('n','y','p') NOT NULL DEFAULT 'n',
  `is_sign` enum('n','y') NOT NULL DEFAULT 'n',
  PRIMARY KEY (`id`),
  UNIQUE KEY `num` (`order_id`,`num`),
  KEY `act_id` (`act_id`),
  KEY `order_id` (`order_id`),
  KEY `issign` (`is_sign`),
  KEY `is_paid` (`is_paid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Структура таблицы `itscrm_invoices_fkt`
--

CREATE TABLE IF NOT EXISTS `itscrm_invoices_fkt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `act_id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `sum` float(11,2) NOT NULL,
  `num` varchar(100) NOT NULL DEFAULT '',
  `note` text,
  `is_sign` enum('n','y') NOT NULL DEFAULT 'n',
  PRIMARY KEY (`id`),
  KEY `is_sign` (`is_sign`),
  KEY `act_id` (`act_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `itscrm_invoices_tmpl`
--

CREATE TABLE IF NOT EXISTS `itscrm_invoices_tmpl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Структура таблицы `itscrm_logs`
--

CREATE TABLE IF NOT EXISTS `itscrm_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) DEFAULT NULL,
  `class` varchar(50) NOT NULL DEFAULT '',
  `function` varchar(50) NOT NULL DEFAULT '',
  `msg` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Структура таблицы `itscrm_orders`
--

CREATE TABLE IF NOT EXISTS `itscrm_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `client_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `date` date NOT NULL,
  `fixpay` float(11,2) DEFAULT NULL,
  `note` text,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `client_id` (`client_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=84 ;

-- --------------------------------------------------------

--
-- Структура таблицы `itscrm_payments`
--

CREATE TABLE IF NOT EXISTS `itscrm_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `amount` float(11,2) NOT NULL,
  `note` text,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- Структура таблицы `itscrm_price`
--

CREATE TABLE IF NOT EXISTS `itscrm_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `unit` varchar(255) NOT NULL DEFAULT 'шт.',
  `cost` float(11,2) NOT NULL DEFAULT '0.00',
  `group` enum('services','goods') NOT NULL DEFAULT 'services',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Структура таблицы `itscrm_users`
--

CREATE TABLE IF NOT EXISTS `itscrm_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(50) NOT NULL DEFAULT '',
  `display_name` varchar(50) NOT NULL DEFAULT '',
  `login_name` varchar(50) NOT NULL DEFAULT '',
  `timezone` varchar(100) NOT NULL DEFAULT 'Europe/London',
  `email` varchar(250) NOT NULL DEFAULT '',
  `www` varchar(100) DEFAULT NULL,
  `icq` varchar(50) DEFAULT NULL,
  `jabber` varchar(100) DEFAULT NULL,
  `notify` enum('yes','no') NOT NULL DEFAULT 'no',
  `last_login` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `last_ip` varchar(255) DEFAULT NULL,
  `last_hostname` varchar(250) DEFAULT NULL,
  `group_id` int(11) NOT NULL DEFAULT '0',
  `about` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_login_name` (`login_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `itscrm_u_profiles`
--

CREATE TABLE IF NOT EXISTS `itscrm_u_profiles` (
  `user_id` int(11) NOT NULL,
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `firstname` varchar(50) NOT NULL DEFAULT '',
  `birthday` date NOT NULL DEFAULT '0000-00-00',
  `displayname` varchar(50) NOT NULL DEFAULT '',
  `notify` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `itscrm_u_profiles_fields`
--

CREATE TABLE IF NOT EXISTS `itscrm_u_profiles_fields` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `varname` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `field_type` varchar(50) NOT NULL,
  `field_size` int(3) NOT NULL DEFAULT '0',
  `field_size_min` int(3) NOT NULL DEFAULT '0',
  `required` int(1) NOT NULL DEFAULT '0',
  `match` varchar(255) NOT NULL DEFAULT '',
  `range` varchar(255) NOT NULL DEFAULT '',
  `error_message` varchar(255) NOT NULL DEFAULT '',
  `other_validator` varchar(255) NOT NULL DEFAULT '',
  `default` varchar(255) NOT NULL DEFAULT '',
  `widget` varchar(255) NOT NULL DEFAULT '',
  `widgetparams` varchar(5000) NOT NULL DEFAULT '',
  `position` int(3) NOT NULL DEFAULT '0',
  `visible` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `varname` (`varname`,`widget`,`visible`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Структура таблицы `itscrm_u_users`
--

CREATE TABLE IF NOT EXISTS `itscrm_u_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `createtime` int(10) NOT NULL DEFAULT '0',
  `lastvisit` int(10) NOT NULL DEFAULT '0',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`),
  KEY `superuser` (`superuser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Структура таблицы `itscrm_works`
--

CREATE TABLE IF NOT EXISTS `itscrm_works` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `act_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `unit` varchar(255) NOT NULL DEFAULT '',
  `cost` float(11,2) NOT NULL DEFAULT '0.00',
  `group` enum('services','goods') NOT NULL DEFAULT 'services',
  `quantity` int(11) NOT NULL DEFAULT '0',
  `location` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2582 ;

-- --------------------------------------------------------

--
-- Структура таблицы `Rights`
--

CREATE TABLE IF NOT EXISTS `Rights` (
  `itemname` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`itemname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
