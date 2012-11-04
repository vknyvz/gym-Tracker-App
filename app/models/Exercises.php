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
class Model_Exercises extends vkNgine_DbTable_Abstract
{
    protected $_name = 'exercises';
	protected $_primary	= 'exerciseId';
	protected $_rowClass = 'Model_Exercise';
	
	protected $_saveInsertDate	= true;
	protected $_saveUpdateDate	= true;
	
	/**
	 * fetch an admin user
	 *
	 * @param int $userId
	 */
	public function fetch($exerciseId)
	{
		$select = $this->select();
		$select->where('exerciseId = ?', $exerciseId);
	
		return $this->fetchRow($select);
	}
	
	/**
	 * fetch all exercises with pagination support
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
	
	public function search($q)
	{
		$select = $this->select();
		$select->where('name LIKE ?', '%'.$q.'%');
		$select->orwhere('primaryMuscle LIKE ?', '%'.$q.'%');
		
		return $this->fetchAll($select);
	}
	
	/**
	 * update an exercise
	 *
	 * @param int $exerciseId
	 * @param array $data
	 */
	public function update($exerciseId, $data)
	{
		$where = $this->getAdapter()->quoteInto('exerciseId = ?', (int) $exerciseId);
		parent::update($data, $where);
	}
	
	
	/**
	 * delete an exercise
	 *
	 * @param int $exerciseId
	 */
	public function delete($exerciseId)
	{
		parent::delete($exerciseId);
	}
}