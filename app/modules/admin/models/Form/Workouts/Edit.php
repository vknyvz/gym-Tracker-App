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
class Admin_Model_Form_Workouts_Edit extends vkNgine_Form_AjaxDesign
{	
    public function init()
    {
    	parent::init('adminFormWorkoutsEdit');
    	    	 
    	$this->addElements(array(
    			new vkNgine_Form_Element_Hidden('workoutId'),
    			new vkNgine_Form_Element_Select('userId',
   					array('label' 	=> Zend_Registry::get('t')->_('User'),
    					  'class' 	=> 'field select medium',
    					  'escape'  => false,
    					  'desc' 	=> Zend_Registry::get('t')->_('Workout will be added to this user')),
    				array(),
    				true),
    			new vkNgine_Form_Element_Text('name',
	    			array('label' 	=> Zend_Registry::get('t')->_('Workout Name'),
	    				  'class' 	=> 'field text medium'),
	    			true), 
    			new vkNgine_Form_Element_Text('startDate',
	    			array('label' => Zend_Registry::get('t')->_('Start Date'),
	    				  'class' => 'field text medium datePicker'),
	    			false), 
    			new vkNgine_Form_Element_Text('endDate',
	    			array('label' => Zend_Registry::get('t')->_('End Date'),
	    				  'class' => 'field text medium datePicker'),
	    			false),
    			new vkNgine_Form_Element_Text('source',
    				array('label' => Zend_Registry::get('t')->_('Source'),
    					  'class' => 'field text medium'),
    				false),
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
    	$this->getElement('workoutId')->setValue($value);
    }
}