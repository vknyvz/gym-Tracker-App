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
class Model_Food extends Zend_Db_Table_Row
{
	/**
	 * get food name
	 * 
	 * @return Model_Food
	 */
	public function getName()
	{
		return $this['name'];
	}
	
	/**
	 * get serving Size
	 * 
	 * @return Model_Food
	 */
	public function getServingSize()
	{
		return $this['servingSize'];
	}
}