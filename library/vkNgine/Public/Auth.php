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
class vkNgine_Public_Auth
{
    /**
     * Returns the Auth Adapter class in use for this configuration.
     * 
     * @param	array	$params Array of input username and password
     * @return	Zend_Auth_Adapter_Interface
     */
    static function getAuthAdapter(array $params)
    {    	
    	$adapter = new vkNgine_Public_Auth_Adapter();
    	$adapter->setEmail($params['username']);
    	$adapter->setPassword($params['password']);
    	
    	if (array_key_exists('noCredentialTreatment', $params)) {
			$adapter->setNoCredentialTreatment($params['noCredentialTreatment']);
		}
    	
		return $adapter;
    }
    
    /**
     * Returns true if session is authenticated (an identity exists).
     * 
     * @return	bool
     */
    static function isAuthenticated()
    {
    	return Zend_Auth::getInstance()->hasIdentity();
    }
    
    /**
     * gets user identity
     */
    static function getIdentity()
    {
    	return Zend_Auth::getInstance()->getIdentity();
    }
    
    /**
     * Attempts login with input data.
     * 
     * @param	array	$values	Array of input login data to pass to the auth adapter.
     * @return	Zend_Auth_Result
     */
    public function attemptLogin($values)
    {    	
		$adapter = self::getAuthAdapter($values);
        $auth    = Zend_Auth::getInstance();
        $result  = $auth->authenticate($adapter);
		
        if ($result->isValid()){
        	$modelUsers = new Public_Model_Users();
        	$user = $modelUsers->fetchWithEmail($values['username']);
        	        	
        	$userInfo = $user->toArray();
        	$userInfo['type'] = $user->type;
        	
           	$storage = $auth->getStorage();
        	$storage->write($userInfo);
        	
        	return true;
        }
        
        return false;
    }
    
    /**
     * Clears the session data and logs out the current user.
     * 
     * @return void
     */
    public function logout()
    {
    	return Zend_Auth::getInstance()->clearIdentity();
    }
    
    /**
     * revalidate the user 
     *
     * @return array 
     */
    public function revalidate() {
       	$user = vkNgine_Auth::getIdentity();
       	
        $modelPublicUsers = new Public_Model_Users();
        $dbUser = $modelPublicUsers->fetchWithEmail($user['email']);
       					
		return $dbUser;
    }	
}
