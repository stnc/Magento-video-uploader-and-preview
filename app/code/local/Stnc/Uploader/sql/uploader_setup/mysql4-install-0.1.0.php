<?php

/*
-- DROP TABLE IF EXISTS videoupload;
-- DROP TABLE IF EXISTS {$this->getTable('videoupload')};
CREATE TABLE {$this->getTable('videoupload')} (

*/

$installer = $this;

$installer->startSetup();

$installer->run("CREATE TABLE stnc_videoupload(
  `videoupload_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NULL default '',
  `filename` varchar(255) NOT NULL default '',
   `sku` varchar(255) NOT NULL default '',
  `status` smallint(6) NOT NULL default '1',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`videoupload_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

$installer->endSetup(); 