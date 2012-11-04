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
class vkNgine_Form_Element_Checkbox extends Zend_Form_Element_Checkbox
{
	public function __construct($spec = null, $options = null, $required = false)
    {
    	parent::__construct($spec, $options);
    	
    	$this->setLabel($options['label'])
       		 ->setChecked($options['value'])
       		 ->setRequired($required)
       		 ->setDescription($options['desc'] ? $options['desc'] : null)
       		 ->setCheckedValue($options['checkedValue'])
       		 ->setUncheckedValue($options['uncheckedValue'])
       		 ->setDecorators(array(new vkNgine_Form_Element_Decorator_Checkbox(array('placement' => $options['placement'], 'labelClass' => 'empty'))));
     }
}

