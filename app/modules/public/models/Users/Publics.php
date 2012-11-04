<?php
class Public_Model_Users_Publics extends vkNgine_DbTable_Abstract
{
    protected $_name = 'users_admins';
	protected $_primary	= 'userId';
    
	/**
	 * reference map info
	 * 
	 * @var array
	 */
	protected $_referenceMap    = array(
        'Standard' => array(
            'columns'           => array('userId'),
            'refTableClass'     => 'Public_Model_Users',
            'refColumns'        => array('userId')
        )
    );	   

	/**
	 * update a user's permissions
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