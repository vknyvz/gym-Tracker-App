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
class Public_Model_Form_Workout_Manage extends vkNgine_Form_AjaxDesign
{	
    public function init()
    {
    	parent::init('publicFormManageWorkout');
    	
    	$this->setAttrib('class', 'form');
    	
    	$this->addElements(array(
			new vkNgine_Form_Element_Hidden('workoutId'),
    	));
    }
    
    public function setHidden($value)
    {
    	$this->getElement('workoutId')->setValue($value);
    }
}