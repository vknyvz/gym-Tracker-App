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
class vkNgine_Log_Logins extends vkNgine_DbTable_Abstract 
{
	protected $_name = "log_logins";
	protected $_primary	= 'id';

	/**
	 * insert a log
	 * 
	 * @param int $userId
	 * @param string $userType
	 */
	public function insertTrafficLogin($userId, $userType)
	{	
		$data = array (			
			'userId'       => $userId,
			'userType'     => $userType,
			'dateInserted' => date('Y-m-d H:m:s'),
			'ip' 		   => $_SERVER['REMOTE_ADDR']
		);
						
		parent::insert($data);		
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
	 * fetch last logged in date
	 * 
	 * @param Model_User $user
	 * @return Ambigous <Zend_Db_Table_Row_Abstract, NULL, unknown>
	 */
	public function fetchLastLoggedInInfo(Model_User $user)
	{
		$sql = 'SELECT max(id) as maxId FROM ' . $this->_name . ' WHERE `userId` = ' . (int) $user->getId();
		
		$data = $this->_db->fetchRow($sql);
		
		$select = $this->select();
		$select->where($this->getPrimary() . ' = ?', (int) $data['maxId']);
		
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