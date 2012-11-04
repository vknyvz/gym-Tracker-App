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
class Admin_AuthController extends Zend_Controller_Action
{
    public function init()
    {
    	parent::init();
    	
		// preload helpers
		$helper = new vkNgine_View_Helper_AdminUrl();    	
    	$this->view->registerHelper($helper, 'adminUrl');
    	    	
    	$this->config = vkNgine_Config::getSystemConfig();
		$this->view->headTitle('Master Admin')->setSeparator(' - ');
    	
		$this->view->t = Zend_Registry::get('t');
		$this->t = Zend_Registry::get('t');
		
       	$this->_helper->layout->setLayout('layout_auth');    	
    }
    
	public function indexAction()
    {
    	if (vkNgine_Auth::isAuthenticated()) {
    		$this->_redirect('/admin');
			exit;
    	}
    	
        $this->_redirect("/auth/login");
		exit;
    }
    
    public function loginAction()
    {
    	if (vkNgine_Auth::isAuthenticated()) {
    		$this->_redirect('/admin');
			exit;
    	}
    	
      	$view = Zend_Registry::get('view');
		$view->headTitle('Administrator Login');
		
    	$loginForm = $this->getAdminLoginForm();
    	$recoverForm = $this->getAdminRecoverForm();
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {    		
    		$email = $this->_getParam('email');
    		$password = $this->_getParam('password');
    		$remember = $this->_getParam('remember');
    		
    		$hash = new Zend_Session_Namespace('CsrfError');
    		if($hash->message) {
	    		echo Zend_Json::encode(array('title'   => $this->t->_('Error Message'), 
										 	 'message' => $this->t->_($hash->message),
											 'icon'    => 'error' ));
				exit;
    		}
    		else {
    			if ($loginForm->isValid($request->getPost())){
		    		if ((!empty($email)) && (!empty($password))) { 
		    			$info = array (
		    				'email' => $email,
		    				'password' => $password,
		    				'remember' => $remember
		    			);
		    			
		    			if (vkNgine_Admin_Auth::attemptLogin($info)) {
		    				
		    				$this->user = vkNgine_Admin_Auth::revalidate();
		    				
		    				if(isset($info['remember']) and ($info['remember'])) {
			            		$config = vkNgine_Config::getSystemConfig();
				        		if(isset($config->settings->login->remember)) {
		    						$rememberMeHowLong = $config->settings->login->remember;
				        		}
		    					else {
		    						$rememberMeHowLong = 60 * 60 * 24 * 14; // 14 days
		    					}
				    			Zend_Session::rememberMe($rememberMeHowLong);
			        		}
			        		else {
				        		Zend_Session::forgetMe();
			        		}
		    				
			        		$logger = Zend_Registry::get('logger');
		    				$logger->log('ADMIN_LOGIN_REQUEST', print_r($info, true), vkNgine_Log::INFO, $this->user['userId']);
		    				
		    				$modelTrafficLogins = new vkNgine_Log_Logins();
		    				$modelTrafficLogins->insertTrafficLogin($this->user['userId'], 'ADMIN');
		
		    				$modelTrafficActivity = new vkNgine_Log_Activity();
		    				$modelTrafficActivity->processActivity($this->user, $request, 'Logged in to Admin Panel');
		    				
		    				$modelUsers = new Admin_Model_Users();
							$modelUsers->update($this->user['userId'], array('lastLogin' => date('Y-m-d H:i:s')));
	
							echo Zend_Json::encode(array('success' => 1, 
														 'title'   => $this->t->_('Success Message'),
													     'message' => $this->t->_('Logged in Successfully'),
														 'icon'    => 'success',
														 'href'    => '/admin'
							));
							exit;
		    			}
		    			else {
		    				echo Zend_Json::encode(array('title'   => $this->t->_('Error Message'), 
													 	 'message' => $this->t->_('Invalid Login or Password!'),
														 'icon'    => 'error' ));
							exit;
		    			}
		    		}
		    		else {
	    				echo Zend_Json::encode(array('title'   => $this->t->_('Error Message'), 
												 	 'message' => $this->t->_('Username or Password is Invalid!'),
													 'icon'    => 'error' ));
						exit;
		    		}
    			}
    			else {
    				echo Zend_Json::encode(array('title'   => $this->t->_('Error Message'),
    						'message' => $this->t->_('Username or Password is Invalid!'),
    						'icon'    => 'error' ));
    				exit;
    			}
    		}
    	}    

    	$this->view->loginForm = $loginForm;
    	$this->view->recoverForm = $recoverForm;
    }
    
    public function recoverAction()
    {
    	if (vkNgine_Auth::isAuthenticated()) {
    		$this->_redirect('/admin');
			exit;
    	}
    	
    	$form = $this->getAdminRecoverForm();
    	
    	$request = $this->getRequest();
		
    	if($request->isPost()) {
    		$post = $request->getPost();
    		
    		if($form->isValid($post)) {
		    	$values = $form->getValues();
		    	
		    	$modelUsers = new Model_Users();
		    	$user = $modelUsers->fetchWithEmail($values['recoverEmail']);
		    	
		    	if($user instanceof Model_User) {
			    	$modelUsersTokens = new Model_Users_Tokens();
			    	$token = $modelUsersTokens->add($user); 
			    	
			    	$toEmails = array($values['recoverEmail']);
			    	
			    	$email = "
			    		Dear {$user->getFullname()},
			    		<p>You have requested to reset your password. Please click the below link to reset your password.</p>
			    		
			    		<p><a href='http://" . $_SERVER['HTTP_HOST'] . "/admin/auth/resetpassword/token/{$token}'>Reset Password</a></p>
			    		
			    		<small>vkNgine v" . vkNgine_Version::VERSION . "</small>
			    	"; 
			    	
			    	$emailOptions = array('type'  => 'html', 
			    						  'email' => $email
			    	);
			    	
			    	vkNgine_Email::send($this->t->_('vkNgine Recover Password'), null, $toEmails, $emailOptions);
	    	
			    	echo Zend_Json::encode(array('success' => 1, 
												 'title'   => $this->t->_('Success Message'),
											     'message' => $this->t->_('Instructions sent to reset the password'),
												 'icon'    => 'success',
												 'stayPut' => 1
					));
					exit;
		    	}
		    	else {
		    		echo Zend_Json::encode(array('title'   => $this->t->_('Error Message'), 
										 	 	 'message' => $this->t->_('Email is invalid or couldn\'t be found'),
											 	' icon'    => 'error' ));
					exit;
		    	}
    		}
    		else {
    			echo Zend_Json::encode(array('title'   => $this->t->_('Error Message'), 
										 	 'message' => $this->t->_('Email is invalid or couldn\'t be found'),
											 'icon'    => 'error' ));
				exit;
    		}
    	}
    }
    
    public function resetpasswordAction()
    {
    	if (vkNgine_Auth::isAuthenticated()) {
    		$this->_redirect('/admin');
			exit;
    	}
    	
    	$modelUsers = new Model_Users();
    	$modelUsersTokens = new Model_Users_Tokens();
    	
    	$token = $this->_getParam('token');
    	
    	if(!$token) {
    		$this->_redirect('/admin/auth/login');
    	}
    	
    	$form = self::getResetPasswordForm();
    	
    	$request = $this->getRequest();
    	
    	if ($request->isPost()) {
			$post = $request->getPost();
			
			if($form->isValid($post)) {
				$values = $form->getValues();	
				
				$user = $modelUsers->fetchWithEmail($values['email']);
	    		    		
	    		$token = $modelUsersTokens->fetch($user, $values['token']);
	    		
	    		if($token) {
		    		$data = array (
		    			'password' => $values['password']
		    		);
		    		
		    		$modelUsers->update($user->getId(), $data);
		    		
		    		$modelUsersTokens->delete($token['tokenId']);
		    		
		    		echo Zend_Json::encode(array('success' => 1, 
												 'title'   => $this->t->_('Success Message'),
											     'message' => $this->t->_('Password was changed successfully'),
												 'icon'    => 'success',
												 'href'    => '/admin/auth/login'
					));
					exit;
	    		}
	    		else {
					echo Zend_Json::encode(array('title'   => $this->t->_('Error Message'), 
										 	 	 'message' => $this->t->_('Given token was not valid'),
											 	 'icon'   => 'error' ));
					exit;
				}	
			}
			else {
				echo Zend_Json::encode(array('title'   => $this->t->_('Error Message'), 
									 	 	 'message' => $this->t->_('Given token/email or password was not valid'),
		 								 	 'icon'    => 'error' ));
				exit;
			}	
    	}
    	
    	$this->view->form = $form->setTokenValue($token);
    }
    
    private function getAdminLoginForm()   
	{
		$form = new Admin_Model_Form_Login(array(
			'method' => 'post',
			'action' => $this->_helper->url('login', 'auth'),
		));		
    	
		return $form;
	}  
    
	private function getAdminRecoverForm()
	{
		$form = new Admin_Model_Form_Recover(array(
			'method' => 'post',
			'action' => $this->_helper->url('recover', 'auth'),
		));		
    	
		return $form;
	}
	
	private function getResetPasswordForm()
	{
		$form = new Admin_Model_Form_Reset_Password(array(
			'method' => 'post',
			'action' => $this->_helper->url('resetpassword', 'auth'),
		));		
    	
		return $form;
	}
	
    public function logoutAction()
    {
    	Zend_Auth::getInstance()->clearIdentity();
        	
		return $this->_helper->redirector('login'); 
    }    
}