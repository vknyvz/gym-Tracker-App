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
class vkNgine_Log_Log extends vkNgine_DbTable_Abstract 
{
	protected $_name = "log";
	protected $_primary	= 'id';
		
	/**
	 * Fetch all with pagination support
	 * 
	 * @param int $page
	 * @param string $orderBy
	 * @param string $orderBySort
	 * 
	 * @return Zend_Paginator
	 */
	public function fetchAllWithPagination($page, $orderBy = 'dateInserted', $orderBySort = 'DESC')
	{
		$select = $this->select();		
		$select->order($orderBy . ' ' . $orderBySort);
	   
		$paginator = Zend_Paginator::factory($select);
		
		if ($page != 'ALL') {
			$paginator->setItemCountPerPage(vkNgine_Config::getSystemConfig()->pagination->perPage)->setCurrentPageNumber($page);
		} else {
			$paginator->setItemCountPerPage(9999);
		}
		
		return $paginator;
	}
	
	/**
	 * fetch a log
	 *  
	 * @param int $logId
	 */
	public function fetch($logId)
	{
		$select = $this->select();
		$select->where($this->getPrimary() . ' = ?', (int) $logId);
		
		return $this->fetchRow($select);
	}
	
	/**
	 * delete a log
	 *  
	 * @param int $logId
	 */
	public function delete($logId)
	{
		$where = $this->getAdapter()->quoteInto($this->getPrimary() . ' = ?', (int) $logId);
		
		parent::delete($where);
	}
}