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
class vkNgine_Form_Design extends vkNgine_Form_Abstract
{
	public function init($name)
    {
    	$this->setName($name);
    	
    	$this->addDecorator('formElements');
		$this->addDecorator('HtmlTag', array('tag' => 'ul', 'class' => 'vkNgineForm'));
		$this->addDecorator('form');
    }
}