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
class vkNgine_Form_Element_Password extends Zend_Form_Element_Password
{
	public function __construct($spec = null, $options = null, $required = false)
    {
		parent::__construct($spec, $options);
	
		$this->setLabel($options['label'])
			 ->setRequired($required)
       	     ->setAttrib('class', $options['class'])
        	 ->addValidator('Alnum')
        	 ->setDescription((isset($options['desc'])) ? $options['desc'] : null)
       		 ->addValidator('StringLength', false, array(6, 256));
		
		if(isset($options['removeDecorators'])){
			$this->removeDecorator('HtmlTag')
			->removeDecorator('Label');
		}
		else {
			$this->setDecorators(array(new vkNgine_Form_Element_Decorator_Text()));
		}
    }
}