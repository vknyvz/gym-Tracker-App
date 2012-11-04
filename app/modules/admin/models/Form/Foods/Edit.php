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
class Admin_Model_Form_Foods_Edit extends vkNgine_Form_AjaxDesign
{	
    public function init()
    {
    	parent::init('adminFormFoodsEdit');
    	
    	$this->addElements(array(
    			new vkNgine_Form_Element_Hidden('foodId'),
    			new vkNgine_Form_Element_Text('name',
    					array('label' 	=> Zend_Registry::get('t')->_('Name'),
    						  'class' 	=> 'field text medium'),
    					true),
    			new vkNgine_Form_Element_Text('servingSize',
    					array('label' 	=> Zend_Registry::get('t')->_('Serving Size'),
    						  'class' 	=> 'field text medium'),
    					true),
    			new vkNgine_Form_Element_Select('servingSizeType',
    					array('label' 	=> Zend_Registry::get('t')->_('Serving Size Type'),
    						  'class' 	=> 'select',
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
    			new vkNgine_Form_Element_Text('protein',
    					array('label' 	=> Zend_Registry::get('t')->_('Protein'),
    						  'class' 	=> 'field text medium'),
    					false),
    			new vkNgine_Form_Element_Text('calories',
    					array('label' 	=> Zend_Registry::get('t')->_('Calories'),
    						  'class' 	=> 'field text medium'),
    					false),
    			new vkNgine_Form_Element_Text('carbs',
    					array('label' 	=> Zend_Registry::get('t')->_('Carbs'),
    						  'class' 	=> 'field text medium'),
    					false),
    			new vkNgine_Form_Element_Text('fat',
    					array('label' 	=> Zend_Registry::get('t')->_('Fat'),
    						  'class' 	=> 'field text medium'),
    					false),
    			new vkNgine_Form_Element_Text('sugar',
    					array('label' 	=> Zend_Registry::get('t')->_('Sugar'),
    						  'class' 	=> 'field text medium'),
    					false),
    			new vkNgine_Form_Element_Text('sodium',
    					array('label' 	=> Zend_Registry::get('t')->_('Sodium'),
    						  'class' 	=> 'field text medium'),
    					false),
    			new vkNgine_Form_Element_Text('fiber',
    					array('label' 	=> Zend_Registry::get('t')->_('Fiber'),
    						  'class' 	=> 'field text medium'),
    					false),	
    			new vkNgine_Form_Element_Text('cholesterol',
    					array('label' 	=> Zend_Registry::get('t')->_('Cholesterol'),
    						  'class' 	=> 'field text medium'),
    					false),																					
    	));
    }
    
    public function setHidden($value)
    {
    	$this->getElement('foodId')->setValue($value);
    }
}		