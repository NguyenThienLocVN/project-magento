<?php
die('OK');
$read = Mage::getSingleton('core/resource')->getConnection('core_read');

$eid = $read->fetchRow('select entity_type_id from eav_entity_type where entity_type_code="quote_item"');
$quote_type_id = $eid['entity_type_id'];

$eid = $read->fetchRow('select entity_type_id from eav_entity_type where entity_type_code="order_item"');

$order_type_id = $eid['entity_type_id'];

$installer = $this;
$installer->startSetup();


$c = array (
    'entity_type_id'=>$quote_type_id,
    'attribute_code'=>'mto_length',
    'backend_type'=>'varchar',
    'frontend_input'=>'text',
    'is_global' => '1',
    'is_visible' => '0',
    'is_required' => '0',
    'is_user_defined' => '1',
);

$attribute = new Mage_Eav_Model_Entity_Attribute();
$attribute->loadByCode($c['entity_type_id'],$c['attribute_code'])->setStoreId(0)->addData($c);
$attribute->save();

$c = array (
    'entity_type_id'=>$order_type_id,
    'attribute_code'=>'mto_length',
    'backend_type'=>'varchar',
    'frontend_input'=>'text',
    'is_global' => '1',
    'is_visible' => '0',
    'is_required' => '0',
    'is_user_defined' => '1',
);

$attribute = new Mage_Eav_Model_Entity_Attribute();
$attribute->loadByCode($c['entity_type_id'],$c['attribute_code'])->setStoreId(0)->addData($c);
$attribute->save();

$installer->endSetup();