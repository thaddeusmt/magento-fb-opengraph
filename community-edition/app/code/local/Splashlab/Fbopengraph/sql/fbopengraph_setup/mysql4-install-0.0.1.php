<?php
/**
 * SplashLab Social - Facebook Open Graph Extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category    Splashlab
 * @package     Splashlab_Fbopengraph
 * @copyright   Copyright (c) 2011 Evan Johnson / SplashLab Social (http://splashlabsocial.com)
 * @author      Evan Johnson / SplashLab Social (http://splashlabsocial.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/*
 * adding the facebook_id field
 * need to:
 * -alter customer_entity table
 * -set up customer_eav_attribute settings
 * -add field to the admin form by adding entry to customer_form_attribute
 *
 */

$installer = $this;

$installer->startSetup();
$entityTypeId = $installer->getEntityTypeId('customer');

// add a new facebook_id column to the customer_entity table
$installer->run("ALTER TABLE {$this->getTable('customer_entity')}
    ADD COLUMN `facebook_id` BIGINT(20) UNSIGNED AFTER `email`,
    ADD INDEX IDX_FB_AUTH(`facebook_id`, `website_id`)");

// set up attribute settings in the back end
$installer->addAttribute('customer', 'facebook_id', array(
    'type' => 'static',
    'label' => 'Facebook ID',
    'required' => 0,
    'visible' => 1,
    'multiline_count'=>0
));

$attribute = Mage::getSingleton('eav/config')->getAttribute('customer', $installer->getAttributeId($entityTypeId, 'facebook_id'));
$data = array(
    'sort_order'        => 85,
    'validate_rules'    => array(
    'max_text_length'   => 40,
    'input_validation'  => 'numeric'
    ),
);
$attribute->addData($data);

// add the new attribute to the admin edit form
$usedInForms[] = 'adminhtml_customer';
$attribute->setData('used_in_forms', $usedInForms);
$attribute->save();

$installer->endSetup();
