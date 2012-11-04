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
class vkNgine_Form_Element_Textarea extends Zend_Form_Element_Textarea
{
	public function __construct($spec = null, $options = null, $required = false)
    {
    	parent::__construct($spec, $options);
    	
    	$this->setLabel($options['label'])
       		 ->setRequired($required);
    	 
    	if($options['style']) {
    		$this->setAttrib('style', $options['style']);
    	}
    	else {
    		$this->setAttrib('style', 'width: 384px; height: 110px;');
    	}
    	
    	if($required && isset($options['notEmptyErrorMessage'])){
    		$this->addValidator('NotEmpty', false, array('messages' => $options['notEmptyErrorMessage']));
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