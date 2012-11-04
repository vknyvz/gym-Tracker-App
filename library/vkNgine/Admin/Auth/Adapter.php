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
class vkNgine_Admin_Auth_Adapter implements Zend_Auth_Adapter_Interface 
{	
	/**
	 * user's email
	 * @var string
	 */
	protected $_email = null;
	
	/**
	 * 
	 * user's password
	 * @var string
	 */	
	protected $_password = null;
	
	/**
	 * 
	 * Enter credential treatment here ...
	 * @var int
	 */	
	protected $_noCredentialTreatment = 0;
	
   /**
     * $_authenticateResultInfo
     *
     * @var array
     */
    protected $_authenticateResultInfo = null;
    	
    /**
     * authenticate() - defined by Zend_Auth_Adapter_Interface.  This method is called to
     * attempt an authentication.  Previous to this call, this adapter would have already
     * been configured with all necessary information to successfully connect to a database
     * table and attempt to find a record matching the provided identity.
     *
     * @throws Zend_Auth_Adapter_Exception if answering the authentication query is impossible
     * @return Zend_Auth_Result
     */
    public function authenticate()
    {
    	$modelUsers = new Admin_Model_Users();        	
    	$user = $modelUsers->fetchWithEmail($this->_email);

        if (!$user instanceof Model_User) {
            $this->_authenticateResultInfo['code'] = Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID;
            $this->_authenticateResultInfo['messages'][] = 'User not found';        	
        }
        elseif ($user->active != 'Y') {    	
      		$this->_authenticateResultInfo['code'] = Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID;
            $this->_authenticateResultInfo['messages'][] = 'User is not active';        	
        }
        elseif ($user->password != md5($this->_password)) {
        	if ($this->_noCredentialTreatment && ($user->password == $this->_password)) {        		
				$this->_authenticateResultInfo['code'] = Zend_Auth_Result::SUCCESS;
				$this->_authenticateResultInfo['messages'][] = 'Authentication successful.';
			}
			else {
      			$this->_authenticateResultInfo['code'] = Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID;
            	$this->_authenticateResultInfo['messages'][] = 'Password is invaild';   
			}	
        }
        else {
           	$this->_authenticateResultInfo['code'] = Zend_Auth_Result::SUCCESS;
			$this->_authenticateResultInfo['messages'][] = 'Authentication successful.';        	
        }       	    	
        
        return $this->_authenticateCreateAuthResult();
    }
    
    /**
     * setEmail() - set the user's email
     *
     * @param string $email
     * @return vkNgine_Admin_Auth_Adapter Provides a fluent interface
     */
    public function setEmail($email)
    {
        $this->_email = $email;
        return $this;
    }   

    /**
     * setPassword() - set the user's email
     *
     * @param string $password
     * @return vkNgine_Admin_Auth_Adapter Provides a fluent interface
     */
    public function setPassword($password)
    {
        $this->_password = $password;
        return $this;
    }     
    
    /**
     * setNoCredentialTreatment() - set the credential treatment.
     *
     * @param string $noCredentialTreatment
     * @return vkNgine_Admin_Auth_Adapter Provides a fluent interface
     */
    public function setNoCredentialTreatment($noCredentialTreatment)
    {
        $this->_noCredentialTreatment = $noCredentialTreatment;
        return $this;
    }     
    
    /**
     * _authenticateCreateAuthResult() - Creates a Zend_Auth_Result object from
     * the information that has been collected during the authenticate() attempt.
     *
     * @return Zend_Auth_Result
     */
    protected function _authenticateCreateAuthResult()
    {
        return new Zend_Auth_Result(
            $this->_authenticateResultInfo['code'],
            null,
            $this->_authenticateResultInfo['messages']
            );
    }
}
