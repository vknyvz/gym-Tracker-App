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
class vkNgine_Admin_Controller extends Zend_Controller_Action
{	
	private $acl;
	protected $user = null;
	
    public function init()
    {    	
    	$helper = new vkNgine_View_Helper_AdminUrl();    	
    	$this->view->registerHelper($helper, 'adminUrl');
    	
        $helper = new vkNgine_View_Helper_Dateformat();
        $this->view->registerHelper($helper, 'dateFormat');
        
        $helper = new vkNgine_View_Helper_FormDate();
        $this->view->registerHelper($helper, 'formDate');
        
        $helper = new vkNgine_View_Helper_Phoneformat();
        $this->view->registerHelper($helper, 'phoneFormat');
        
        $helper = new vkNgine_View_Helper_Breadcrumb();
        $this->view->registerHelper($helper, 'breadcrumb');
        
        $helper = new vkNgine_View_Helper_Plural();
        $this->view->registerHelper($helper, 'plural');
        
    	$view = Zend_Registry::get('view');
    	
    	$vkNgineVersion =  vkNgine_Version::VERSION;
    	$appTitle = sprintf(Zend_Registry::get('t')->_('%s Administrator Control Panel'), 'vkNgine' . $vkNgineVersion[0]);
    	$this->view->appTitle = $appTitle;
		$view->headTitle($appTitle, Zend_View_Helper_Placeholder_Container_Abstract::SET);
    	
		if (!vkNgine_Auth::isAuthenticated()) {
	       	$this->_redirect('/admin/auth/login');
        	exit;
		}	
			    
	    $user = vkNgine_Admin_Auth::revalidate();
	    
	    if(!$user) {
	    	$this->_redirect('/admin/auth/login');
        	exit;
	    }
	    
	    Zend_Registry::set('user', $user);
	    $this->view->assign('user', $user);
       		    
    	$this->user = Zend_Registry::get('user');		
		$this->config = vkNgine_Config::getSystemConfig();
		
		$modelTrafficLogins = new vkNgine_Log_Logins(); 
		$lastLoggedInInfo = $modelTrafficLogins->fetchLastLoggedInInfo($this->user);
		$this->view->assign('lastLoggedInInfo', $lastLoggedInInfo);
		
		$this->view->action = array (
			'controller' => $this->_request->controller,
			'action' 	 => $this->_request->action
		);
				
		$acl = new vkNgine_Admin_Acl();
		$this->acl = $acl;
		Zend_Registry::set('acl', $acl);
		
		$this->view->t = Zend_Registry::get('t');
		$this->t = Zend_Registry::get('t');
		
		parent::init();
    }
    
    public function ajaxEnabled()
    {
    	$this->_helper->layout->disableLayout();
    }
    
    /**
     * get all params in the query string
     */
    public function getQueryStringParams() 
    {
    	$params = $this->getRequest()->getParams();
    	unset($params['module']);
    	unset($params['controller']);
    	unset($params['action']);
    	
    	return $params;
    }
}