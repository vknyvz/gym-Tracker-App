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
class vkNgine_Validate_NotUser extends Zend_Validate_Abstract
{	
	protected $excludeAddress = null;
	
	const REGISTERED_USER_EMAIL = 'invalid';
	
	protected $_messageTemplates = array(
		self::REGISTERED_USER_EMAIL => "Email already registered",
	);
	
	public function __construct($excludeAddress = null)
	{
		$this->excludeAddress = $excludeAddress;
	}		
	
	public function isValid($value)
	{	
		if ($value == $this->excludeAddress) {
			return true;
		}		
		
		$modelUsers = new Model_Users();
		$user = $modelUsers->fetchWithEmail($value);
	
		if ($user) {
			$this->_error('Email already registered');
			return false;
		}
		return true;
	}
	
}