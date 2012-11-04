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
class Admin_Model_Form_Workouts_Exercises_Edit extends vkNgine_Form_AjaxDesign
{	
    public function init()
    {
    	parent::init('adminFormWorkoutsExercisesEdit');
    	
    	$this->addElements(array(
    		new vkNgine_Form_Element_Hidden('workoutId'),
    		new vkNgine_Form_Element_Select('exerciseId',
    				array('label' 	=> Zend_Registry::get('t')->_('Exercises'),
    					  'class' 	=> 'field select medium',
    					  'escape'  => false,
    					  'desc' 	=> null),
    				array(),
    				false),
    		new vkNgine_Form_Element_Text('sets',
	    			array('label' 	=> Zend_Registry::get('t')->_('Sets'),
	    				  'class' 	=> 'field text medium'),
	    			false), 
    	));
    }
    
    public function setExercises($exercises)
    {
    	$element = $this->getElement('exerciseId');
    	 
    	foreach ($exercises as $exercise) {
    		$element->addMultiOption($exercise['exerciseId'], $exercise['name']);
    	}
    }
    
    public function setHidden($value)
    {
    	$this->getElement('workoutId')->setValue($value);
    }
}