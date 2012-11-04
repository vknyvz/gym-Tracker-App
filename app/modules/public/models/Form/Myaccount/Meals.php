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
class Public_Model_Form_Myaccount_Meals extends vkNgine_Form_AjaxDesign
{	
    public function init()
    {
    	parent::init('publicFormMyaccountMeals');
    	
    	$this->setAttrib('class', 'form');
    	
    	$this->addElements(array(
    		new vkNgine_Form_Element_Select('meals',
    				array('label' 	=> null,
    					  'class' 	=> 'select',
    					  'style'   => 'width:250px',
    					  'escape'  => false,
    					  'desc' 	=> null),
    				array(),
   					true),
    	));
    }
    
    public function setMeals($meals)
    {
    	$element = $this->getElement('meals');
    
    	foreach ($meals as $meal) {
    		$element->addMultiOption($meal['mealId'], $meal['title']);
    	}
    }
}