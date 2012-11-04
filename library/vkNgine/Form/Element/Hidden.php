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
class vkNgine_Form_Element_Hidden extends Zend_Form_Element_Hidden
{
	public function __construct($spec = null, $options = null)
    {
    	parent::__construct($spec, $options);
    	
    	$this->removeDecorator('label')
          	 ->removeDecorator('HtmlTag');
    }
}