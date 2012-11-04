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
class Admin_Model_Form_Meals_Edit extends vkNgine_Form_AjaxDesign
{	
    public function init()
    {
    	parent::init('adminFormMealsEdit');
    	    	 
    	$this->addElements(array(
    			new vkNgine_Form_Element_Hidden('mealId'),
    			new vkNgine_Form_Element_Select('userId',
   					array('label' 	=> Zend_Registry::get('t')->_('User'),
    					  'class' 	=> 'field select medium',
    					  'escape'  => false,
    					  'desc' 	=> Zend_Registry::get('t')->_('Meal will be added to this user')),
    				array(),
    				true),
    			new vkNgine_Form_Element_Text('title',
    					array('label' 	=> Zend_Registry::get('t')->_('Title'),
    						  'class' 	=> 'field text medium'),
    					true),
    			));
    }
    			
   	public function setUsers($users)
    {
    	$element = $this->getElement('userId');
   		$element->addMultiOption(null, $this->convertText2Turkish(Zend_Registry::get('t')->_('Choose One')));
    			
		foreach ($users as $user) {
    		$element->addMultiOption($user['userId'], $user['firstName'] . ' ' . $user['lastName']);
  		}
  	}
    			
    public function setHidden($value)
    {
    	$this->getElement('mealId')->setValue($value);
    }
}		