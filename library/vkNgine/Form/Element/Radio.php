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
class vkNgine_Form_Element_Radio extends Zend_Form_Element_Radio
{
	public function __construct($spec = null, $options = null, $values, $required = false)
	{
		parent::__construct($spec, $options);
		
		$this->addFilter('StringTrim')
			 ->setRequired($required)
			 ->setRegisterInArrayValidator(false)
			 
			 ->addMultiOptions($values);
		
		if(isset($options['label'])){
			$this->setLabel($options['label']);
		}
		
		if(isset($options['class'])){
			$this->setAttrib('class', $options['class']); 
		}
		
		if(isset($options['desc'])){
			$this->setDescription($options['desc']);
		}
		
		if(isset($options['label'])){
			$this->setLabel($options['label']);
		}
	}
}