<?php



//$installer = $this;
//$installer->startSetup();
//
//$installer->run(" DROP TABLE IF EXISTS {$this->getTable('sales_quote_item_varchar')};
//CREATE TABLE {$this->getTable('sales_quote_item_varchar')} (
//  value_id int(11) NOT NULL auto_increment,
//  entity_type_id smallint(8) unsigned NOT NULL default '0',
//  attribute_id smallint(5) unsigned NOT NULL default '0',
//  entity_id int(10) unsigned NOT NULL default '0',
//  value varchar(255) NOT NULL default '',
//  PRIMARY KEY  (value_id),
//  KEY FK_sales_quote_item_VARCHAR_ENTITY_TYPE (entity_type_id),
//  KEY FK_sales_quote_item_VARCHAR_ATTRIBUTE (attribute_id),
//  KEY FK_sales_quote_item_VARCHAR_ENTITY (entity_id),
//  CONSTRAINT FK_sales_quote_item_VARCHAR_ENTITY_TYPE FOREIGN KEY (entity_type_id) REFERENCES {$this->getTable('eav_entity_type')} (entity_type_id) ON DELETE CASCADE ON UPDATE CASCADE,
//  CONSTRAINT FK_sales_quote_item_VARCHAR_ATTRIBUTE FOREIGN KEY (attribute_id) REFERENCES {$this->getTable('eav_attribute')} (attribute_id) ON DELETE CASCADE ON UPDATE CASCADE,
//  CONSTRAINT FK_sales_quote_item_VARCHAR_ENTITY FOREIGN KEY (entity_id) REFERENCES {$this->getTable('customer_entity')} (entity_id) ON DELETE CASCADE ON UPDATE CASCADE,
//) ENGINE=InnoDB DEFAULT CHARSET=utf8; ");
//
//
//$installer->endSetup();