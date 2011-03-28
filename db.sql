SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
CREATE DATABASE `brochat` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `brochat`;
CREATE TABLE IF NOT EXISTS `chatlog` (
  `postid` int(20) NOT NULL auto_increment,
  `chat` text NOT NULL,
  `stamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`postid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1271 ;
CREATE TABLE IF NOT EXISTS `userlist` (
  `userid` double NOT NULL auto_increment,
  `username` text NOT NULL,
  `stamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `sessionid` text NOT NULL,
  `ping` text NOT NULL,
  PRIMARY KEY  (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=455 ;
