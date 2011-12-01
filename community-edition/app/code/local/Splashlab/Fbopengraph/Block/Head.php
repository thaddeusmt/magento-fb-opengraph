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
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Splashlab_Fbopengraph_Block_Head extends Mage_Core_Block_Template
{

    private $_product;
    private $_category;

    public function getTitle() {
        if ($this->getProduct() ) {
            return $this->getProductTitle();
        } elseif ($this->getCategory()) {
            return $this->getCategoryTitle();
        } else {
            return $this->getCurrentTitle();
        }

    }

    public function getType() {
        if ($this->getProduct()) {
            return 'product';
        } else {
            return 'website';
        }
    }

    public function getPageUrl() {
        if ($this->getProduct()) {
            return $this->getProductUrl();
        } else {
            return $this->getCurrentUrl();
        }
    }

    public function getImage() {
        if ($this->getProduct()) {
            return $this->getProductImage();
        } elseif ($this->getCategory()) {
            return $this->getCategoryImage();
        } else {
            return $this->getSiteLogoSrc();
        }
    }



    public function getDescription() {
        if ($this->getProduct()) {
            return $this->getProductDescription();
        } else {
            $head = $this->getLayout()->getBlock('head');
            return $head->getDescription();
            //return $this->getSiteDescription();
        }
    }

    public function getSiteTitle()
    {
        if (empty($this->_data['title'])) {
            $this->_data['title'] = Mage::getStoreConfig('design/head/default_title');
        }
        return htmlspecialchars(html_entity_decode(trim($this->_data['title']), ENT_QUOTES, 'UTF-8'));
    }

    public function getSiteDescription()
    {
        if (empty($this->_data['description'])) {
            $this->_data['description'] = Mage::getStoreConfig('design/head/default_description');
        }
        return $this->_data['description'];
    }



    protected function getSiteLogoSrc()
    {
        if (empty($this->_data['logo_src'])) {
            $this->_data['logo_src'] = Mage::getStoreConfig('design/header/logo_src');
        }
        return $this->getSkinUrl($this->_data['logo_src']);
    }

    protected function getCurrentUrl() {
        return Mage::helper('core/url')->getCurrentUrl();
    }

    protected function getCurrentTitle() {
        return Mage::getSingleton('cms/page')->getTitle();
    }




    protected function getCategory()
    {
        if (!$this->_category) {
            $this->_category = $this->hasData('category') ? $this->getData('category') : Mage::registry('current_category');
        }
        return $this->_category;
    }

    protected function getCategoryTitle() {
        return $this->getSiteTitle(). ' | ' .$this->getCategory()->getName();
    }

    protected function getCategoryImage() {
        if ($image = $this->getCategory()->getThumbnail())
            return Mage::getBaseUrl('media').'catalog/category/'.$image;
        elseif ($image = $this->getCategory()->getImageUrl())
            return $image;
        else
            return $this->getSiteLogoSrc();
    }




    protected function getProduct()
    {
        if (!$this->_product) {
            $this->_product = $this->hasData('product') ? $this->getData('product') : Mage::registry('product');
        }
        return $this->_product;
    }

    protected function getProductImage() {
        if ($product = $this->getProduct())
            return Mage::helper('catalog/image')->init($product, 'image');
        else
            return false;
    }

    protected function getProductTitle() {
        if ($product = $this->getProduct()) {
            return $product->getName();
        } else {
            return '';
        }
    }

    protected function getProductUrl() {
        return Mage::helper('catalog/product')->getProductUrl($this->getProduct());
    }

    protected function getProductDescription() {
        $product = $this->getProduct();
        if($description = $product->getShortDescription()) {
            return htmlspecialchars(strip_tags($description));
        } elseif($description = $product->getDescription()) {
            return htmlspecialchars(strip_tags($description));
        } else {
            return $this->getSiteDescription();
        }
    }

}
