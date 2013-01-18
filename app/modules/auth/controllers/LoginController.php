<?php
class Auth_LoginController extends vkNgine_Auth_Controller
{
	private $loggedin = false;
	
    public function init()
    {
    	parent::init();
    }
    
    public function indexAction()
    {
        $this->_forward('login');
    }

	public function preDispatch()
	{
		if ('logout' == $this->getRequest()->getActionName()) {
			if (!Zend_Auth::getInstance()->hasIdentity()) {
				$this->_helper->redirector('index');
			}
		}
	}    
    
    public function loginAction()
    {    	
    	if (vkNgine_Auth::isAuthenticated()){
            header("location:/");
            exit;
        }
        
    	$logger = Zend_Registry::get('logger');
    	
    	$form = $this->getLoginForm();    
    	
		$request = $this->getRequest();
		
		$this->view->error = false;
		
    	if ($request->isPost()) {
    		if ($form->isValid($request->getPost())){
    			$info = $form->getValues();
				
				$user = null;
    			if (vkNgine_Public_Auth::attemptLogin($info)){    				
    				$user = vkNgine_Auth::revalidate();    				
    			} 
    			else {
    				$this->view->error = true;    				
    			}
    			
    			$user = vkNgine_Auth::revalidate();
    			
    			$logger->log('LOGIN_REQUEST', print_r($info, true), vkNgine_Log::INFO, $user['userId']);
    			
    			if ($user != null) {     				 				
	            	$modelUsers = new Model_Users();    				
					$modelTrafficActivity = new vkNgine_Log_Activity();
					$modelTrafficLogins = new vkNgine_Log_Logins();
					
					$modelTrafficActivity->processActivity($user, $request, 'Logged in to Site');
   					$modelTrafficLogins->insertTrafficLogin($user->userId, $user->type); 
   					
   					$config = vkNgine_Config::getSystemConfig();
   					Zend_Session::rememberMe($config->settings->login->remember);
   					
					$modelUsers->update($user['userId'], array('lastLogin' => date('Y-m-d H:i:s')));	

					echo Zend_Json::encode(array('success' => 1, 
												 'icon'    => 'success',
												 'href'    => '/'
					));
					exit;
				}
	    		else {
	    			echo Zend_Json::encode(array('title'   => $this->t->_('Error Message'),
												 'message' => $this->t->_('Access denied!'),
												 'icon'    => 'error' ));
					exit; 
	    		}
    		}
    		else {
    			echo Zend_Json::encode(array('title'   => $this->t->_('Error Message'),
											 'message' => $this->t->_('Access denied!'),
											 'icon'    => 'error' ));
				exit; 
    		}
    	}
   
    	$this->view->form = $form;
    }

    public function logoutAction()
    {
		Zend_Auth::getInstance()->clearIdentity();
		
		return $this->_helper->redirector('login');
    }
	
    private function getLoginForm()
    {
    	$form = new Auth_Model_Form_Login(array(
    		'method' => 'post',
    		'action' => $this->_helper->url('login'),
    	));
    	    	
    	return $form;
    }
}
