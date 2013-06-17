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
class Public_Model_Form_Myaccount_Settings extends vkNgine_Form_AjaxDesign
{	
    public function init()
    {
    	parent::init('publicFormMyaccountCalendar');
    	
    	$this->setAttrib('class', 'form');
    	
    	$this->addElements(array(
    		new vkNgine_Form_Element_Password(
				'password', 
				array('label'  => null,
					  'id'     => null,
					  'class'  => 'input-password m-wrap medium',
					  'autocomplete' => 'off',
					  'desc'   => Zend_Registry::get('t')->_('Write a new password only if you want to change your current password'),
					  'removeDecorators' => 1), 	
				true),
    		new vkNgine_Form_Element_Select('calendarView',
    				array('label' 	=> null,
    					  'class' 	=> 'setCalendarView m-wrap large',
    					  'escape'  => false,
    					  'style'   => true,
    					  'removeDecorators' => true,
    					  'desc' 	=> Zend_Registry::get('t')->_('This will change the default view of the calendar')),
    				array('Weekly'  => Zend_Registry::get('t')->_('Weekly'),
    					  'Monthly' => Zend_Registry::get('t')->_('Monthly'),
    				),
   					true),
    		new vkNgine_Form_Element_Radio('notifications',
    				array('label' => null,
    					  'class' => 'notifications',
    					  'removeDecorators' => true),
    				array('senddaily' => Zend_Registry::get('t')->_(' Send daily reminders'),
    					  'senddailyifnolog' => Zend_Registry::get('t')->_(' Send daily reminders if nothing logged for the day'),
    					  'disable' => Zend_Registry::get('t')->_(" Don't send any reminders"),
    				),
    				true),
    	));
    }
    
    public function changePassword()
    {
    	$this->removeElement('notifications');
    	$this->removeElement('calendarView');
    	
    }
}