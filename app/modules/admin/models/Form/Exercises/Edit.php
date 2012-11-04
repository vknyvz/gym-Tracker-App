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
class Admin_Model_Form_Exercises_Edit extends vkNgine_Form_AjaxDesign
{	
    public function init()
    {
    	parent::init('adminFormExercisesEdit');
    	    	 
    	$this->addElements(array(
    			new vkNgine_Form_Element_Hidden('exerciseId'),
    			new vkNgine_Form_Element_Text('name',
	    			array('label' 	=> Zend_Registry::get('t')->_('Exercise Name'),
	    				  'class' 	=> 'field text medium'),
	    			true), 
    			new vkNgine_Form_Element_Textarea('instructions',
	    			array('label' => Zend_Registry::get('t')->_('Instructions'),
	    				  'class' => 'field text medium'),
	    			false), 
    			new vkNgine_Form_Element_Text('primaryMuscle',
	    			array('label' => Zend_Registry::get('t')->_('Primary Muscle'),
	    				  'class' => 'field text medium'),
	    			false), 
    			new vkNgine_Form_Element_Text('secondaryMuscle',
	    			array('label' => Zend_Registry::get('t')->_('Secondary Muscle'),
	    				  'class' => 'field text medium'),
	    			false), 
    			new vkNgine_Form_Element_Text('mechanics',
	    			array('label' => Zend_Registry::get('t')->_('Mechanics'),
	    				  'class' => 'field text medium'),
	    			false), 
    			new vkNgine_Form_Element_Text('equipmentUsed',
	    			array('label' => Zend_Registry::get('t')->_('Equipment Used'),
	    				  'class' => 'field text medium'),
	    			false),
    	));
    			
    	$this->addDisplayGroup(array(
    		'exerciseId', 'name', 'primaryMuscle', 'secondaryMuscle', 'mechanics', 'equipmentUsed'
    	), 'general', array('legend' => Zend_Registry::get('t')->_('General Information')));
    	
    	$general = $this->getDisplayGroup('general');
    	$general->setDecorators(array(
    			'FormElements',
    			'Fieldset',
    			array('HtmlTag',array('tag'=>'div','style' => 'float:left;width:400px;'))
    	));
    	
    	$this->addElements(array(
    			new vkNgine_Form_Element_Textarea('instructions',
    					array('label' => Zend_Registry::get('t')->_('Instructions'),
    						  'class' => 'field text medium'),
    					false),
    	));
    	
    	$this->addDisplayGroup(array(
    		'instructions'
    	), 'additional_information', array('legend' => Zend_Registry::get('t')->_('Additional Information')));
    	
    	$additional_information = $this->getDisplayGroup('additional_information');
    	$additional_information->setDecorators(array(
    			'FormElements',
    			'Fieldset',
    			array('HtmlTag',array('tag'=>'div','style' => 'float:left;width:400px;'))
    	));
    }
    
    public function setHidden($value)
    {
    	$this->getElement('exerciseId')->setValue($value);
    }
}