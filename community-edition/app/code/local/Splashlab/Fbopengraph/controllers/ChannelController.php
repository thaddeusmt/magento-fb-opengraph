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

class Splashlab_Fbopengraph_ChannelController extends Mage_Core_Controller_Front_Action
{
    /**
     * Create the channel.html content for the Facebook JavaScript SDK
     */
    public function indexAction()
    {
        $cache_expire = 60*60*24*365; //1 year
		$this->getResponse()
				->setHeader('Pragma', 'public', true)
				->setHeader('Cache-Control', 'max-age='.$cache_expire, true)
				->setHeader('Expires', gmdate('D, d M Y H:i:s', time()+$cache_expire), true)
				;
        $this->getResponse()->setBody('<script src="//connect.facebook.net/en_US/all.js"></script>');
    }

}
