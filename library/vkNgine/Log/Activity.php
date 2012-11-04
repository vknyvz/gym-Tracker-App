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
class vkNgine_Log_Activity extends vkNgine_DbTable_Abstract 
{
	protected $_name 	= "log_activity";
	protected $_primary	= 'activityId';
		
	/**
	 * fetch all traffic activity attached to a user
	 * 
	 * @param Model_User $user
	 * @param int $page
	 */
	public function fetchByUserWithPage(Model_User $user, $page = 1)
	{
		$select = $this->select();			
		$select->where('userId = ?', (int) $user->userId);	
		$select->order('date DESC');		
	
		$paginator = Zend_Paginator::factory($select);
		if ($page!='ALL') {
			$paginator->setItemCountPerPage(15)->setCurrentPageNumber($page);
		} else {
			$paginator->setItemCountPerPage(100);
		}
		
		return $paginator;
	}
	
	/**
	 * Fetch all with pagination support
	 * 
	 * @param int $page
	 * @param string $orderBy
	 * @param string $orderBySort
	 * 
	 * @return Zend_Paginator
	 */
	public function fetchAllWithPagination($page, $orderBy = 'date', $orderBySort = 'DESC')
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
	 * fetch all the public traffic activity attached to a user
	 * 
	 * @param Model_User $user
	 * @param unknown_type $page
	 */
	public function fetchPublicByUser(Model_User $user, $limit = 10)
	{
		$select = $this->select();			
		$select->where('userId = ?', (int) $user->userId);
		$select->where('permission = ?', 'PUBLIC');
		$select->order('date DESC');
		$select->limit('10');
		
		$rows = $this->fetchAll($select)->toArray();
		
		return $rows;
	}
	
	/**
	 * add a traffic activity
	 *
	 * @param Model_Unit $unit
	 * @param Model_User $user
	 * @param array $request
	 */
	public function add(Model_User $user, $request)
	{
		$data = array (
					'userId' => $user->userId,
					'module' => $request['module'],
					'action' => $request['action'],
					'description' => $request['description'],
					'date' => $request['date']
		);		
				
		if(isset($request['permission']))
			$data['permission'] = $request['permission'];
					
		return $this->insert($data);			
	}
	
	/**
	 * 
	 * @param unknown_type $unit
	 * @param Model_User $user
	 * @param unknown_type $request
	 */
	public function isLatestActivityWasProfileUpdate($unit, Model_User $user, $request)
	{
		$select = $this->select();			
		$select->where('userId = ?', (int) $user->userId);
		$select->where('permission = ?', 'PUBLIC');
		$select->order('date DESC');
		$select->limit('1');
		
		if($row = $this->fetchRow($select)) {
			$row = $row->toArray();
			if(($row['action'] == 'update') and ($row['module'] == 'profile')) {
				return true;
			}
			else {
				return false;
			}
		} else {
			return false;
		}
		
	}
	
	/**
	 * process a traffic activity
	 *
	 * @param Model_User $user
	 * @param unknown_type $request
	 * @param unknown_type $description
	 */
	public function processActivity(Model_User $user, $request, $description = '')
	{			
		$trafficActivity = array();
		$trafficActivity['module'] = $request->getControllerName();
		$trafficActivity['action'] = $request->getActionName();
		$trafficActivity['description'] = $description;
		$trafficActivity['date'] = date('Y-m-d H:i:s');
					
		//Add traffic activity
		$this->add($user, $trafficActivity);		
	}
	
	/**
	 * insert a new traffic activity
	 * 
	 * @param array $data
	 */
	public function insert($data) 
	{	
		return parent::insert($data);
	}
	
	/** 
	 * delete a user
	 * 
	 * @param int $logId
	 */
	public function delete($logId)
	{
		$where = $this->getAdapter()->quoteInto($this->getPrimary() . ' = ?', (int) $logId);
		parent::delete($where);
	}	
}