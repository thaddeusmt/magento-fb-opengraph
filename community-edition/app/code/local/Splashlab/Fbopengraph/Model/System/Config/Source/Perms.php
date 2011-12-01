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

class Splashlab_Fbopengraph_Model_System_Config_Source_Perms
{

    public function toOptionArray()
    {
        return array(
            array('value'=>Mage::helper('fbopengraph')->__('email'), 'label'=>Mage::helper('fbopengraph')->__('email')),
            array('value'=>Mage::helper('fbopengraph')->__('user_birthday'), 'label'=>Mage::helper('fbopengraph')->__('user_birthday')),
            array('value'=>Mage::helper('fbopengraph')->__('read_stream'), 'label'=>Mage::helper('fbopengraph')->__('read_stream')),
            array('value'=>Mage::helper('fbopengraph')->__('publish_stream'), 'label'=>Mage::helper('fbopengraph')->__('publish_stream')),
            array('value'=>Mage::helper('fbopengraph')->__('offline_access'), 'label'=>Mage::helper('fbopengraph')->__('offline_access')),
            array('value'=>Mage::helper('fbopengraph')->__('user_checkins'), 'label'=>Mage::helper('fbopengraph')->__('user_checkins')),
            array('value'=>Mage::helper('fbopengraph')->__('rsvp_event'), 'label'=>Mage::helper('fbopengraph')->__('rsvp_event')),
            array('value'=>Mage::helper('fbopengraph')->__('sms'), 'label'=>Mage::helper('fbopengraph')->__('sms')),
            array('value'=>Mage::helper('fbopengraph')->__('publish_checkins'), 'label'=>Mage::helper('fbopengraph')->__('publish_checkins')),
            array('value'=>Mage::helper('fbopengraph')->__('user_likes'), 'label'=>Mage::helper('fbopengraph')->__('user_likes')),
        );
    }

}
