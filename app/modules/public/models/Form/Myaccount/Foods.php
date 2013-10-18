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
class Public_Model_Form_Myaccount_Foods extends vkNgine_Form_AjaxDesign
{	
    public function init()
    {
    	parent::init('publicFormMyaccountFoods');
    	
    	$this->setAttrib('class', 'form');
    	    	
    	$this->addElements(array(
    		new vkNgine_Form_Element_Hidden('foodId'),
    		new vkNgine_Form_Element_Text('foodSearch',
    				array('label' 	=> null,
    					  'class' 	=> 'foodsearch m-wrap xlarge',    					  
    					  'removeDecorators' => true,
    					  'escape'  => false,
    					  'placeholder' => Zend_Registry::get('t')->_('Enter a food'),
    					  'desc' 	=> null),
    				true),
    		new vkNgine_Form_Element_Text('servingSize',
    				array('label' 	=> null,
    					  'class'   => 'm-wrap small',   					  
    					  'onkeyup' => 'var value = $(this).val(); $("#servingSize").val(value);',
    					  'escape'  => false,
    					  'placeholder' => Zend_Registry::get('t')->_('How much?'),
    					  'desc' 	=> null),
    				true),    			
    		new vkNgine_Form_Element_Select('servingSizes',
    				array('label' 	=> null,
    					  'class' 	=> 'small m-wrap',
    					  'readonly'=> '',
    					  'onkeyup' => 'var value = $(this).val(); $("#servingSizes").val(value);',
    					  'escape'  => false,
    					  'desc' 	=> null),
    				array(''        => Zend_Registry::get('t')->_('Choose One'),
    					  'serving' => 'Serving',
    					  'gr'      => 'gr',
    					  'cup'     => Zend_Registry::get('t')->_('cup'),
    					  'tbsp'    => Zend_Registry::get('t')->_('tbsp'),
    					  'tsp' 	=> Zend_Registry::get('t')->_('tsp'),
    					  'oz'		=> 'oz',
    					  'ml'		=> 'ml',
    					  'lb'	 	=> 'lb'),
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