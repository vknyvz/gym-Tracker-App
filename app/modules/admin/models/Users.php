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
class Admin_Model_Users extends Model_Users {
    
    protected $_dependentTables = array('Admin_Model_Users_Admins');
	
	/**
	 * fetch admin user by email
	 * 
	 * @param string $email
	 */
	public function fetchWithEmail($email) 
	{		
		$user = parent::fetchWithEmail($email);
		
		if (!$user instanceof Model_User) {
			return false;
		}
		
		$adminInfo = $user->findDependentRowset('Admin_Model_Users_Admins', 'Admin');
		
		if (count($adminInfo)>0) {
			$row = $adminInfo->current();
			
			$user->type = 'ADMIN';
			$user->level = $row->level;
		}
		else {
			$user = false;
		}		
		
		return $user;
	}
		
	/** 
	 * fetch all admin users with pagination
	 * 
	 * @return Zend_Paginator
	 */
	public function fetchAllWithPagination($page, $orderBy = 'userId', $orderBySort = 'ASC')
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
	 * fills up a user object to a admin user
	 * 
	 * @param Model_User $user
	 */
	private function makeAdmin(Model_User $user) 
	{
		$adminInfo = $user->findDependentRowset('Admin_Model_Users_Admins', 'Admin');
		
		if(count($adminInfo) > 0) {
			$row = $adminInfo->current();
			
			$user->type = 'ADMIN';
			$user->level = $row->level;
		}
		else {
			$user = false;
		}
				
		return $user;
	}

	/** 
	 * fetch an admin user
	 * 
	 * @param int $userId
	 */
	public function fetch($userId)
	{
		$select = $this->select();		
		$select->where('userId = ?', $userId);
		
		$user = $this->fetchRow($select);
		$user = $this->makeAdmin($user);

		return $user;
	}	

	/**
	 * insert a new admin user
	 * 
	 * @param array $data
	 */
	public function insert($data) 
	{
		$level = $data['level'];
		
		unset($data['userId']);
		unset($data['level']);
		
		$userId = parent::insert($data);

		$modelUsersAdmins = new Admin_Model_Users_Admins();
		$modelUsersAdmins->insert(array('userId' => $userId, 'level' => $level));		
				
		return $userId;
	}		

	/**
	 * update an admin user
	 * 
	 * @param int $userId
	 * @param array $data
	 */
	public function update($userId, $data) 
	{
		if (!empty($data['level'])) {
			$modelUsersAdmins = new Admin_Model_Users_Admins();
			$modelUsersAdmins->update($userId, array('level' => $data['level']));
			unset($data['level']);
		}
		
		return parent::update($userId, $data);		
	}	
	
	/**
	 * delete an admin user
	 *
	 * @param int $userId
	 */	
	public function delete($userId)
	{
		$modelUsersAdmins = new Admin_Model_Users_Admins();
		$modelUsersAdmins->delete($userId);
				
		parent::delete($userId);
	}	
}