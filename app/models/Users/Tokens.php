<?php
class Model_Users_Tokens extends vkNgine_DbTable_Abstract
{
	protected $_name = 'users_tokens';
	protected $_primary = 'tokenId';
	protected $_saveInsertDate = true;
	
	/**
	 * fetch a token
	 *
	 * @param Model_User $user
	 * @param string $token
	 */
	public function fetch(Model_User $user, $token) {
		$select = $this->select();
		
		$select->where('userId = ?', (int) $user->getId());
		$select->where('token = ?', $token);
		
		return $this->fetchRow($select);
	}	
	
	/**
	 * add a password token and return the token's string
	 * 
	 * @param Model_User $user
	 */
	public function add(Model_User $user)
	{
		// make random token
		$chars = "abcdefghijkmnopqrstuvwxyz023456789";
    	srand((double)microtime()*1000000);
    	$i = 0;
    	$token = '' ;

    	while ($i < 40) {
			$num = rand() % 33;
			$tmp = substr($chars, $num, 1);
			$token = $token . $tmp;
        	$i++;
    	}
    	
    	$data = array (
    		'token' => $token,
    		'userId' => $user->getId()
    	);
    	
    	$this->insert($data);
    	
    	return $token;
	}
	
	/**
	 * insert a new token
	 * 
	 * @param array $data
	 */
	public function insert($data) 
	{
		return parent::insert($data);
	}
	
	/**
	 * update a token
	 * 
	 * @param int $tokenId
	 * @param array $data
	 */
	public function update($tokenId, $data) 
	{
		$where = $this->getAdapter()->quoteInto('tokenId = ?', $tokenId);
				
		return parent::update($data, $where);
	}
	
	/**
	 * delete a token
	 * 
	 * @param int $tokenId
	 */
	public function delete($tokenId)
	{
		$where = $this->getAdapter()->quoteInto('tokenId = ?', (int) $tokenId);	
		
		parent::delete($where);
	}	
}