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
class Model_Exercise extends Zend_Db_Table_Row
{
	/**
	 * get exercise id
	 * 
	 * @return int
	 */
	public function getId()
	{
		return $this['exerciseId'];
	}
	
	/**
	 * get exercise name
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this['name'];
	}			
}