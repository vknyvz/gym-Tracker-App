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
class Admin_Model_Users_Admins extends vkNgine_DbTable_Abstract
{
    protected $_name = 'users_admins';
	protected $_primary	= 'userId';
    
	/**
	 * reference map info
	 * 
	 * @var array
	 */
	protected $_referenceMap    = array(
        'Admin' => array(
	 		'columns' 			=> array('userId'),
            'refTableClass'     => 'Admin_Model_Users',
            'refColumns'        => array('userId')
        )
    );	   

	/**
	 * update an admin user
	 * 
	 * @params int $userId
	 * @params array $data
	 */
	public function update($userId, $data) 
	{
		$where = $this->getAdapter()->quoteInto('userId = ?', $userId);
		
		parent::update($data, $where);
	}	

	/**
	 * delete a user
	 *
	 * @param int $userId
	 */	
	public function delete($userId)
	{
		$where = $this->getAdapter()->quoteInto('userId = ?', $userId);
		
		parent::delete($where);
	}
}