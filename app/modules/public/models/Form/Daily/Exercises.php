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
class Public_Model_Form_Daily_Exercises extends vkNgine_Form_AjaxDesign
{	
    public function init()
    {
    	parent::init('publicFormDailyExercises');
    	
    	$miles = null;
    	$miles[null] = 0;
    	for($i=0; $i<8; $i++) {
    		for($v=0; $v<100; $v++) {
    			if($i) {
    				
    				$miles[$i . '.' . $v] = $i . '.' . $v;
    			}
    		}
    	}
    	   	
    	$this->addElements(array(
    		new vkNgine_Form_Element_Hidden('date'),
    		new vkNgine_Form_Element_Hidden('forward'),
    		new vkNgine_Form_Element_Select('workoutId',
	    			array('label' 	=> null,
    					  'class' 	=> 'input-large setdays',
    					  'escape'  => false,
	    				  'select'  => 'none',
    					  'desc' 	=> null),
    				array(),
    				false),
    		new vkNgine_Form_Element_Select('workoutDay',
    				array('label' 	=> Zend_Registry::get('t')->_('Choose a workout day'),
    					  'class' 	=> 'input-mini',
	    				  'style'   => 'none', 
    					  'escape'  => false),
    				array(),
    				false),
    			new vkNgine_Form_Element_Select('type',
    					array('label' 	=> null,
    							'class' 	=> 'input-large',
    							'escape'  => false,
    							'style'   => 'none',
    							'desc' 	=> null),
    					array('' => $this->convertText2Turkish(Zend_Registry::get('t')->_('Choose an Activity')),
    							'Cycling' => $this->convertText2Turkish(Zend_Registry::get('t')->_('Cycling')),
    							'Rope Jumping' => $this->convertText2Turkish(Zend_Registry::get('t')->_('Rope Jumping')),
    							'Football' => $this->convertText2Turkish(Zend_Registry::get('t')->_('Football')),
    							'Running' => $this->convertText2Turkish(Zend_Registry::get('t')->_('Running')),
    							'Stairs' => $this->convertText2Turkish(Zend_Registry::get('t')->_('Stairs')),
    							'Swimming' => $this->convertText2Turkish(Zend_Registry::get('t')->_('Swimming')),
    							'Weight Lifting' => $this->convertText2Turkish(Zend_Registry::get('t')->_('Weight Lifting'))),
    					false),
    		new vkNgine_Form_Element_Select('timeSpentHour',
   					array('label' 	=> 'Hour',
   						  'class' 	=> 'input-xsmall',
   						  'style'   => 'none',
   						  'escape'  => false),
    				array(null => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5),
    				false),
    		new vkNgine_Form_Element_Select('timeSpentMin',
   					array('label' 	=> 'Minute',
   						  'class' 	=> 'input-xsmall',
   						  'style'   => 'none',
   						  'escape'  => false),
    				array(null => 0, 10 => 10, 15 => 15, 20 => 20, 25 => 25, 30 => 30, 35 => 35, 40 => 40, 45 => 45),
    				false),
    		new vkNgine_Form_Element_Select('miles',
   					array('label' 	=> 'Miles',
   						  'class' 	=> 'input-xsmall',
   						  'style'   => 'none',
   						  'escape'  => false),
    				$miles,
    				false),			
    			new vkNgine_Form_Element_Textarea('moreDetails',
    					array('label' 	=> null,
    							'class' 	=> 'input-xlarge',
    							'escape'  => false,
    							'style'   => 'height: 100px;',
    							'placeholder' => Zend_Registry::get('t')->_('More details for this')),
    					false),
    	));
    }
    
	public function setWorkouts($workouts)
    {
    	$element = $this->getElement('workoutId');
    	$element->addMultiOption(null, $this->convertText2Turkish(Zend_Registry::get('t')->_('Choose an Exercise')));
    	
    	foreach ($workouts as $workout) {
    		$element->addMultiOption($workout['workoutId'], $workout['name']);
    	}
    }
    
    public function setDay($value)
    {
    	$element = $this->getElement('workoutDay');
    	 
    	for($i=1; $i<=$value; $i++){
    		$element->addMultiOption($i, $i);
    	}
    }
    
    public function setHidden($value, $action)
    {
    	$this->getElement('date')->setValue($value);
    	$this->getElement('forward')->setValue($action);
    }    
}