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
class Model_Foods extends vkNgine_DbTable_Abstract
{
    protected $_name = 'foods';
	protected $_primary	= 'foodId';
	
	protected $_rowClass = 'Model_Food';
	
	/**
	 * fetch a food
	 *
	 * @param int $foodId
	 */
	public function fetch($foodId)
	{
		$select = $this->select();
		$select->where('foodId = ?', $foodId);
	
		return $this->fetchRow($select);
	}
	
	
	public function fetchResults($foodName)
	{
		$select = $this->select();
		$select->where('name LIKE (?)', '%' . $foodName . '%');
		
		return $this->fetchAll($select)->toArray();
	}
	
	/**
	 * update a food
	 *
	 * @param int $foodId
	 * @param array $data
	 */
	public function update($foodId, $data)
	{
		$where = $this->getAdapter()->quoteInto('foodId = ?', (int) $foodId);
		parent::update($data, $where);
	}
	
	/**
	 * fetch all foods with pagination support
	 *
	 * @param int $page
	 * @param string $orderBy
	 * @param string $orderBySort
	 * @param array $searchParams
	 * @return Zend_Paginator
	 */
	public function fetchAllWithPagination($page, $orderBy = 'name', $orderBySort = 'ASC')
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
}