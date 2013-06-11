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
class Public_Model_Daily_Intake extends vkNgine_DbTable_Abstract
{
    protected $_name = 'daily_intake';
	protected $_primary	= 'id';
	
	protected $_saveInsertDate	= true;
}