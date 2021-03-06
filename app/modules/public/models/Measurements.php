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
class Public_Model_Measurements extends vkNgine_DbTable_Abstract
{
    protected $_name = 'measurements';
	protected $_primary	= 'id';
	
	protected $_saveInsertDate	= true;
	
	public function fetchByDate($date, Model_User $user) 
	{
		$select = $this->select();
		$select->where('date = ?', $date);
		$select->where('userId = ?', $user->getId());
		
		return $this->fetchAll($select)->toArray();		
	}
}
