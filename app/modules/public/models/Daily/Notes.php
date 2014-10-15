<?php
/**
 * vkn GYM Tracker
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the new BSD license.
 *
 * @category    core
 * @package     vknGYMTracking
 * @copyright   Copyright (c) 2011-2015 Volkan Yavuz (http://www.vknyvz.com)
 */
class Public_Model_Daily_Exercises extends vkNgine_DbTable_Abstract
{
    protected $_name = 'daily_notes';
	protected $_primary	= 'id';
	
	protected $_saveInsertDate	= true;	
}
	