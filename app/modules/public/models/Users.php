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
class Public_Model_Users extends Model_Users 
{
    protected $_dependentTables = array('Public_Model_Users_Publics');
	
	/**
	 * fetch user by email
	 * 
	 * @param string $email
	 */
	public function fetchWithEmail($email) {
		$user = parent::fetchWithEmail($email);

		if (!$user instanceof Model_User) {
			return false;
		}
				
		$user = self::makePublic($user);
		return $user;
	}
		
	/**
	 * fetch all admin users
	 * 
	 * @return array
	 */
	public function fetchAll()
	{
	   $select = $this->select();
	   
	   $select->order('CONCAT(firstName, " ", lastName) ASC');
	   $select->where('userId IN (SELECT userId from users_admins)');
	   
	   $users = parent::fetchAll($select);
	   foreach ($users as $user) {
	   		$user = $this->makePublic($user);
	   }
	   
	   return $users;	   
	}

	/**
	 * fills up a user object to a public user
	 * 
	 * @param Model_User $user
	 */
	private function makePublic(Model_User $user) {
		// add the public info
		$userInfo = $user->findDependentRowset('Public_Model_Users_Publics', 'Standard');
		
		if (count($userInfo)>0) {
			$row = $userInfo->current();
			
			$user->type = 'STANDARD';
			$user->level = $row->level;
		}
		else {
			$user = false;
		}
		
		return $user;
	}

	/** 
	 * fetch a user
	 * 
	 * @params int $userId
	 */
	public function fetch($userId)
	{
		$select = $this->select();
		
		$select->where('userId = ?', $userId);
		
		$user = $this->fetchRow($select);	

		$user = $this->makePublic($user);

		return $user;
	}	

	/**
	 * insert a new user
	 * 
	 * @params array $data
	 */
	public function insert($data) {

		$level = $data['level'];
		unset($data['userId']);
		unset($data['level']);
		$userId = parent::insert($data);

		$modelUsersAdmins = new Model_Users_Publics();
		$modelUsersAdmins->insert(array('userId' => $userId, 'level' => $level));		
				
		return $userId;
	}		

	/**
	 * update a user
	 * 
	 * @params int $userId 
	 * @params array $data
	 */
	public function update($userId, $data) {

		// reset the admin's level
		if (!empty($data['level'])) {
			$modelUsersPublics = new Model_Users_Publics();
			$modelUsersPublics->update($userId, array('level' => $data['level']));
			unset($data['level']);
		}
		
		return parent::update($userId, $data);		
	}	
	
	/**
	 * delete a user
	 *
	 * @param int $userId
	 */	
	public function delete($userId)
	{
		$modelUsersPublics = new Model_Users_Publics();
		$modelUsersPublics->delete($userId);
				
		parent::delete($userId);

	}	
}