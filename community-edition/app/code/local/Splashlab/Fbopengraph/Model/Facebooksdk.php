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

require_once (Mage::getModuleDir('', 'Splashlab_Fbopengraph').'/Lib/PHP-SDK-3.1.1/facebook.php');

class Splashlab_Fbopengraph_Model_Facebooksdk extends Facebook
{
    /**
     * @var object Facebook PHP SDK class
     */
    protected $_facebook;

    public function __construct($config) {
        $_appId = Mage::getStoreConfig('fbopengraph/open_graph/fb_application_id');
        $_appSecret = Mage::getStoreConfig('fbopengraph/open_graph/fb_application_secret');
        if ($_appId && $_appSecret) {
            $config['appId'] = $_appId;
            $config['secret'] = $_appSecret;
            parent::__construct($config);
        } else
            throw new CException('Facebook API could not be initialized');
    }

    /**
     * Make an API call.
     *
     * @return mixed The decoded response
     */
    public function api(/* polymorphic */) {
        $args = func_get_args();
        try {
            if (is_array($args[0])) {
                return $this->_restserver($args[0]);
            } else {
                return call_user_func_array(array($this, '_graph'), $args);
            }
        } catch (CurlException $e) { //timeout so try to resend
            if (is_array($args[0])) {
                return $this->_restserver($args[0]);
            } else {
                return call_user_func_array(array($this, '_graph'), $args);
            }
        }
        catch (Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
            Mage::log($e->getMessage(),Zend_Log::ERR);
            return false;
        }
    }

    /*
     * @param size size of the facebook image to return ( square (50x50), small (50 pixels wide, variable height), normal (100 pixels wide, variable height), and large (about 200 pixels wide, variable height) )
     * @return url of Facebook profile picture
     */
	public function getProfilePicture($size = null){
	    $id = $this->getUser();
		return $this->getProfilePictureById($id,$size);
    }

    /*
     * @param id Facebook user id
     * @param size size of the facebook image to return
     * @return url of Facebook profile picture
     */
	public function getProfilePictureById($id, $size = null){
		if (!$size)
			return Mage::app()->getRequest()->getScheme().'://graph.facebook.com/'.$id.'/picture';
		else {
			return Mage::app()->getRequest()->getScheme().'://graph.facebook.com/'.$id.'/picture?type='.$size;
        }
    }

    /*
     *
     * @return array of Facebook Open Graph user data for the logged in user "me"
     */
    public function getInfo() {
        return $this->getInfoById('me');
    }

    /*
     * @param Facebook user id
     * @return array of Facebook Open Graph user data
     */
    public function getInfoById($id) {
        if ($this->getUser()) {
            return $this->api('/'.$id);
        } else {
            return false;
        }
    }

}
