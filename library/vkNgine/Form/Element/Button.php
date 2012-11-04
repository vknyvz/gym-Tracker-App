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
class vkNgine_Form_Element_Button extends Zend_Form_Element_Button
{
    public function __construct($spec = null, $options = null)
    {
		parent::__construct($spec, $options);
    	
		$this->removeDecorator('DtDdWrapper')
       		 ->setAttribs(array('class' => 'ui-button float-right ui-state-default ui-corner-all'))
       		 ->setLabel($options['label']);
    }
}