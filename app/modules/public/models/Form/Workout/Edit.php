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
class Public_Model_Form_Workout_Edit extends vkNgine_Form_AjaxDesign
{	
    public function init()
    {
    	parent::init('publicFormEditWorkout');
    	
    	$this->setAttrib('class', 'form');
    	    	 
    	$this->addElements(array(
    			new vkNgine_Form_Element_Hidden('workoutId'),
    			new vkNgine_Form_Element_Text('name',
	    			array('label' 	=> null,
	    				  'class' 	=> 'm-wrap large',
	    				  'placeholder' => Zend_Registry::get('t')->_('Workout Name')),
	    			true),
    			new vkNgine_Form_Element_Select('day',
    				array('label' 	=> Zend_Registry::get('t')->_('How many days a week'),
    					  'class' 	=> 'm-wrap large',
    					  'escape'  => false
    					 ),
   						  
   					array('1' => '1','2' => '2',
   						  '3' => '3','4' => '4',
   						  '5' => '5','6' => '6',
   						  '7' => '7',
   						 ),
   					true),
    			new vkNgine_Form_Element_Textarea('notes',
    				array('label' 	=> null,
    					  'class' 	=> 'span5 m-wrap',
    					  'rows'    => 3,
    				      'escape'  => false,
    					  'placeholder' => Zend_Registry::get('t')->_('Notes')),
    				false),
    			new vkNgine_Form_Element_Text('startDate',
	    			array('label' => null,
	    				  'readonly' => '',
	    				  'class' => 'm-wrap m-ctrl-medium date-picker',
	    				  'placeholder' => Zend_Registry::get('t')->_('Start Date')),
	    			false), 
    			new vkNgine_Form_Element_Text('endDate',
	    			array('label' => null,
	    				  'readonly' => '',
	    				  'class' => 'm-wrap m-ctrl-medium date-picker',
	    				  'placeholder' => Zend_Registry::get('t')->_('End Date')),
	    			false),
    			new vkNgine_Form_Element_Text('source',
    				array('label' => null,
    					  'class' => 'm-wrap large',
    					  'placeholder' => Zend_Registry::get('t')->_('Source')),
    				false),
    	));
    }
    
    public function setHidden($value)
    {
    	$this->getElement('workoutId')->setValue($value);
    }
}