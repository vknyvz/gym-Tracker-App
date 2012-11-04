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
class Model_Users extends vkNgine_DbTable_Abstract
{
    protected $_name = 'users';
	protected $_primary	= 'userId';
	protected $_rowClass = 'Model_User';
	
	protected $_saveInsertDate	= true;
	protected $_saveUpdateDate	= true;
	
	/**
	 * add a data user
	 * 
	 * @param array $data
	 * @return int
	 */
	public function insert($data)
	{
		$data['password'] = md5($data['password']);
					
		return parent::insert($data);			
	}
	
	/**
	 * fetch user by email
	 * 
	 * @param string $email
	 */
	public function fetchWithEmail($email)
	{
		$select = $this->select();
		$select->where('email = ?', $email);
		
		return $this->fetchRow($select);
	}

	/**
	 * fetch a single user
	 * 
	 * @param int $userId
	 */
	public function fetch($userId) 
	{
	    $key = vkNgine_Cache::USER . $userId;
	
	    $user = $this->_cache->load($key);
	    if($user) {
	    	return $user;
	    }
	    
		$select = $this->select();
		$select->where('userId = ?', (int) $userId);
		
		$row = $this->fetchRow($select);
		$this->_cache->save($row, $key);
		
		return $row;			
	}
	
	public function search($q)
	{
		$select = $this->select();
		$select->where('userId = ?', $q);
		$select->orwhere('email LIKE ?', '%'.$q.'%');
		$select->orwhere('firstName LIKE ?', '%'.$q.'%');
		$select->orwhere('lastName LIKE ?', '%'.$q.'%');
		$select->orwhere('companyName LIKE ?', '%'.$q.'%');
		$select->orwhere('mailingAddress LIKE ?', '%'.$q.'%');
		
		return $this->fetchAll($select);
	}
	
	/**
	 * fetch an active user
	 * 
	 * @param int $userId
	 */
	public function fetchActive($userId) 
	{
		$select = $this->select();
		$select->where('userId = ?', (int) $userId);
		$select->where('active = ?', 'Y');
		$row = $this->fetchRow($select);
		
		return $row;		
	}
		
	/**
	 * update a user
	 * 
	 * @param int $userId
	 * @param array $data
	 */
	public function update($userId, $data) 
	{
		if (!empty($data['password'])) {
			$data['password'] = md5($data['password']);	
		}
		
		$where = $this->getAdapter()->quoteInto('userId = ?', (int) $userId);
		
		parent::update($data, $where);
	}	
	
	/**
	 * delete a user
	 *
	 * @param int $userId
	 */	
	public function delete($userId)
	{			
		parent::delete($userId);
	}	
}