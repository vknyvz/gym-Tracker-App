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
    		new vkNgine_Form_Element_Select('calendarView',
    				array('label' 	=> Zend_Registry::get('t')->_('Default Calendar View'),
    					  'class' 	=> 'select setCalendarView',
    					  'style'   => 'width:250px',
    					  'escape'  => false,
    					  'desc' 	=> Zend_Registry::get('t')->_('This will change the default view of the calendar')),
    				array('Weekly'  => Zend_Registry::get('t')->_('Weekly'),
    					  'Monthly' => Zend_Registry::get('t')->_('Monthly'),
    				),
   					true),
    		new vkNgine_Form_Element_Radio('notifications',
    				array('label' => Zend_Registry::get('t')->_('Notifications'),
    					  'class' => 'notifications'),
    				array('senddaily' => Zend_Registry::get('t')->_(' Send daily reminders'),
    					  'senddailyifnolog' => Zend_Registry::get('t')->_(' Send daily reminders if nothing logged for the day'),
    					  'disable' => Zend_Registry::get('t')->_(" Don't send any reminders"),
    				),
    				true),
    	));
    }
    
    public function setMobile()
    {
    	$this->getElement('calendarView')
    		 ->setAttrib('disabled', 'disabled')
    		 ->setDescription(Zend_Registry::get('t')->_('You can\'t change the layout of the calendar on the mobile app'));
    }
}