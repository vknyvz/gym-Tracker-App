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
class Model_Workouts extends vkNgine_DbTable_Abstract
{
    protected $_name = 'workouts';
	protected $_primary	= 'workoutId';
	
	protected $_saveInsertDate	= true;
	protected $_saveUpdateDate	= true;
	
	/**
	 * fetch a workout
	 *
	 * @param int $workoutId
	 */
	public function fetch($workoutId)
	{
		$select = $this->select();
		$select->where('workoutId = ?', $workoutId);
	
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
	
	/**
	 * update an exercise
	 *
	 * @param int $exerciseId
	 * @param array $data
	 */
	public function update($workoutId, $data)
	{
		$where = $this->getAdapter()->quoteInto('workoutId = ?', (int) $workoutId);
		parent::update($data, $where);
	}
}
