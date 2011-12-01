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

class Splashlab_Fbopengraph_Helper_Data extends Mage_Core_Helper_Abstract
{

    public function getAppConfig($configName)
	{
		return Mage::getStoreConfig('fbopengraph/open_graph/' . $configName);
	}

    public function getStoreLocale()
	{
		return Mage::app()->getLocale()->getLocaleCode();
	}

    public function getFacebookLoginUrl()
	{
        $params['redirect_uri'] = $this->_getUrl('fbopengraph/account/loginwithfacebook');
        $params['scope'] = Mage::helper('fbopengraph')->getAppConfig('fb_application_perms');
		return Mage::getSingleton('fbopengraph/facebooksdk')->getLoginUrl($params);
	}

    public function getFacebookLogoutUrl()
	{
        $params['next'] = Mage::helper('customer')->getLogoutUrl();
		return Mage::getSingleton('fbopengraph/facebooksdk')->getLogoutUrl($params);
	}

    public function loadUserByFacebookId($facebookId)
	{
        $facebookId = (string) $facebookId;
        $connection = Mage::getSingleton('core/resource') ->getConnection('core_read');
		$select = $connection->select()->
            from(
                Mage::getSingleton('core/resource')->getTableName('customer_entity'),
                array('entity_id')
            )
            ->where('facebook_id=:facebook_id');

        if ($id = $connection->fetchOne($select, array('facebook_id' => $facebookId))) {
            if($customer = Mage::getModel('customer/customer')->load($id))
                return $customer;
        }
        return array();
	}
}
