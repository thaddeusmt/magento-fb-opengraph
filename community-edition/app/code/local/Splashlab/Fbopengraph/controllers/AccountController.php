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

//we need to add this one since Magento won't autoload it
require_once Mage::getModuleDir('controllers', 'Mage_Customer').DS.'AccountController.php';

class Splashlab_Fbopengraph_AccountController extends Mage_Customer_AccountController
{
    /**
     * Login customer, and create new customer if one does not exist
     */
    public function loginwithfacebookAction()
    {
        Mage::log('calling action');
        $customerSession = $this->_getSession();
        if ($customerSession->isLoggedIn()) {
        	$this->_redirect('customer/account/');
            return;
        }

        if($facebookInfo = Mage::getSingleton('fbopengraph/facebooksdk')->getInfo()) {
            // if we have their FB id, see if this account is already registered, log in the user
            $existingCustomer = Mage::helper('fbopengraph')->loadUserByFacebookId($facebookInfo['id']);
            if ($existingCustomer && $existingCustomer->getId()) {
                $customerSession->setCustomerAsLoggedIn($existingCustomer);
	            $this->_loginPostRedirect();
                return;
            // if there is no existing account create one
            } else {
                if (Mage::helper('customer')->isRegistrationAllowed()) {
                    $newCustomer = $customerSession->getCustomer();
                    $newCustomer->setFacebookId($facebookInfo['id']);
                    $newCustomer->setEmail($facebookInfo['email']);
                    $newCustomer->setFirstname($facebookInfo['first_name']);
                    $newCustomer->setLastname($facebookInfo['last_name']);

                    if ($newCustomer->validate()) {
                        $newCustomer->save();
                        $customerSession->addNotice(Mage::helper('fbopengraph')->__('You have successfully created an account using Facebook. Just click on the Facebook button to log in the future!'));
                        $customerSession->setCustomerAsLoggedIn($newCustomer);
                        $this->_loginPostRedirect();
                        return;
                    }
                } else {
                    $customerSession->addError("Sorry, new customer registrations are not allowed.");
                }
            }
        }

        $customerSession->addError("There was a problem connecting with Facebook. Please register for a normal account instead.");
        $this->_redirect('customer/account/create');
        return;
    }

}
