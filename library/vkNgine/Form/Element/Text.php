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
class vkNgine_Form_Element_Text extends Zend_Form_Element_Text
{
	public function __construct($spec = null, $options = null, $required = false)
    {
		parent::__construct($spec, $options);
		
		$this->addFilter('StringTrim')
			 ->setRequired($required)
        	 ->setLabel($options['label'])
        	 ->setAttrib('class', $options['class'])
        	 ->addValidator('StringLength', false, array(1, 255));
		
		if($required && isset($options['notEmptyErrorMessage'])){
			$this->addValidator('NotEmpty', false, array('messages' => $options['notEmptyErrorMessage']));
		}
		
		if(isset($options['value'])){
			$this->setValue($options['value']);
		}
		
		if(isset($options['removeDecorators'])){
			$this->removeDecorator('HtmlTag')
				 ->removeDecorator('Label');
		}
		else {
			$this->setDecorators(array(new vkNgine_Form_Element_Decorator_Text()));
		}
    }
}