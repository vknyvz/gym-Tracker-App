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
abstract class vkNgine_Form_SubForm_Abstract extends vkNgine_Form_Abstract
{
	public function __construct($options = null)
	{
		parent::__construct($options);		
    	$this->setIsArray(true);
	}
}