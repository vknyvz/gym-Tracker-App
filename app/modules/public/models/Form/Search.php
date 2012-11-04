<?php
/**
 * vkNgine3 Admin System
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the new BSD license.
 *
 * @category    core
 * @package     vkNgine3
 * @copyright   Copyright (c) 2011 Volkan Yavuz (http://www.vknyvz.com)
 */
class Public_Model_Form_Search extends vkNgine_Form_Design
{	
    public function init()
    {
    	$this->setName('publicFormSearch');
    	$this->setAction('/index/search/');
    	$this->setMethod('get');
    	
    	$this->addElements(array(
    			new vkNgine_Form_Element_Text('searchinput',
    					array('placeholder' => Zend_Registry::get('t')->_('Search exercises'),
    						  'label' => null,
    						  'class' => '',
    						  'removeDecorators' => true),
    					false),
    			new vkNgine_Form_Element_Submit('searchbutton',
    					array('value' => null,
    						  'class' => null,
    						  'removeDecorators' => true),
    					false),
    	));
    }
}