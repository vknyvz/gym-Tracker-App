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
class Public_Model_Form_Daily_Details extends vkNgine_Form_AjaxDesign
{	
    public function init()
    {
    	parent::init('publicFormDailyDetails');
    	
    	$this->setAttrib('class', 'form');    	
    	   	
    	$this->addElements(array(
    		new vkNgine_Form_Element_Hidden('date'),
    		new vkNgine_Form_Element_Hidden('forward'),
    		new vkNgine_Form_Element_Select('type',
    			array('label' 	=> null,
    				  'class' 	=> 'select',
   					  'escape'  => false,
   					  'desc' 	=> Zend_Registry::get('t')->_('Color will color the box, Supplement will log the daily use')),
  				array('' => $this->convertText2Turkish(Zend_Registry::get('t')->_('Choose One')),
				      'COLOR' => $this->convertText2Turkish(Zend_Registry::get('t')->_('Color')),
  					  'SUPPLEMENT' => $this->convertText2Turkish(Zend_Registry::get('t')->_('Supplement'))),
    			true),    
    		new vkNgine_Form_Element_Text('value',
    			array('label' 	=> null,
    				  'class' 	=> 'input',
    				  'style'   => 'width:100%',
    				  'maxlength' => 17,
    				  'removeDecorators' => true,
    			      'placeholder' => Zend_Registry::get('t')->_('Enter the value for the type')),
    			false),
    		new vkNgine_Form_Element_Select('color',
    			array('label' 	=> null,
    				  'class' 	=> 'select',
    				  'style'   => 'width:100%',
    				  'escape'  => false,
    				  'desc' 	=> Zend_Registry::get('t')->_('Choose one if you want to color a box on the calendar')),
    			array('' => $this->convertText2Turkish(Zend_Registry::get('t')->_('Choose One')),
    				  'LightSlateGray' => $this->convertText2Turkish(Zend_Registry::get('t')->_('off gym'))),
    			false),

    	));
  	}			
    
    public function setHidden($value, $action)
    {
    	$this->getElement('date')->setValue($value);
    	$this->getElement('forward')->setValue($action);
    }
}