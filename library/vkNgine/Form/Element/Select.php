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
class vkNgine_Form_Element_Select extends Zend_Form_Element_Select
{
	public function __construct($spec = null, $options = null, $values, $required = false)
    {
    	parent::__construct($spec, $options);
		
		$this->addFilter('StringTrim')
			 ->setRequired($required)
        	 ->setLabel($options['label'])
        	 ->setAttrib('class', $options['class'])
        	 ->setRegisterInArrayValidator(false) 
        	 ->setDescription($options['desc'] ? $options['desc'] : null)
        	 ->addMultiOptions($values);
		
		if(!isset($options['style']))
        	 $this->setDecorators(array(new vkNgine_Form_Element_Decorator_Text()));
    }
}