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
class Public_Model_Form_Measurements_Edit extends vkNgine_Form_AjaxDesign
{	
    public function init()
    {
    	parent::init('publicFormEditMeasurements');
    	
    	$this->setAttrib('class', 'form');
    	    	 
    	$this->addElements(array(
    			new vkNgine_Form_Element_Text('value',
	    			array('label' 	=> null,
	    				  'class' 	=> 'input',
	    				  'style'   => 'width:200px',
	    				  'placeholder' => Zend_Registry::get('t')->_('Value')),
	    			true), 
    			new vkNgine_Form_Element_Select('type',
	    			array('label'   => null,
	    				  'class'   => 'select',
	    				  'style'   => 'width:200px',
	    				  'escape'  => false,
	    				  'desc'    => null),
    				array('WEIGHT' => Zend_Registry::get('t')->_('Weight'),),
	    			true), 
    			new vkNgine_Form_Element_Text('date',
	    			array('label' => null, 
	    				  'class' => 'input datePicker',
	    				  'style' => 'width:200px',
	    				  'placeholder' => Zend_Registry::get('t')->_('Record Date')),
	    			true),
    	));
    }
}