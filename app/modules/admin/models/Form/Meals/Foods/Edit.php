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
class Admin_Model_Form_Meals_Foods_Edit extends vkNgine_Form_AjaxDesign
{	
    public function init()
    {
    	parent::init('adminFormMealsFoodsEdit');
    	
    	$this->addElements(array(
    			new vkNgine_Form_Element_Hidden('mealId'),
    			new vkNgine_Form_Element_Select('foodId',
    					array('label' 	=> Zend_Registry::get('t')->_('Foods'),
    						  'class' 	=> 'field select medium',
    						  'escape'  => false,
    						  'desc' 	=> null),
    					array(),
    					false),
    	));
    }
    
    public function setFoods($foods)
    {
    	$element = $this->getElement('foodId');
    
    	foreach ($foods as $food) {
    		$element->addMultiOption($food['foodId'], $food['name']);
    	}
    }
    
    public function setHidden($value)
    {
    	$this->getElement('mealId')->setValue($value);
    }
}