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
class Admin_LogsController extends vkNgine_Admin_Controller
{
	public function init()
	{
		parent::init();
	}
	
	public function indexAction()
	{	
		parent::ajaxEnabled();
		
		$modelLogs = new vkNgine_Log_Log();
		
		$page = $this->_getParam('page', 1);
	    $orderBy = $this->_getParam('orderBy', 'dateInserted');
	    $orderBySort = $this->_getParam('orderBySort', 'DESC');
	     
	    $this->view->userInfo = self::userDetails();
		$this->view->logs = $modelLogs->fetchAllWithPagination($page, $orderBy, $orderBySort);
	}
	
	public function activityAction()
	{
		parent::ajaxEnabled();
		
		$modelActivityLogs = new vkNgine_Log_Activity();
		
		$page = $this->_getParam('page', 1);
	    $orderBy = $this->_getParam('orderBy', 'date');
	    $orderBySort = $this->_getParam('orderBySort', 'DESC');
	     
	    $this->view->userInfo = self::userDetails();
		$this->view->logs = $modelActivityLogs->fetchAllWithPagination($page, $orderBy, $orderBySort);
	}
	
	public function loginsAction()
	{
		parent::ajaxEnabled();
		
		$modelLoginLogs = new vkNgine_Log_Logins();
		
		$page = $this->_getParam('page', 1);
	    $orderBy = $this->_getParam('orderBy', 'dateInserted');
	    $orderBySort = $this->_getParam('orderBySort', 'DESC');
	    
	    $this->view->userInfo = self::userDetails();
	    $this->view->logs = $modelLoginLogs->fetchAllWithPagination($page, $orderBy, $orderBySort);
	}
	
	public function showDetailAction()
    {
     	parent::ajaxEnabled();
     	
    	$field = $this->_getParam('field');
     	$id = $this->_getParam('id');
    
     	$modelLogs = new vkNgine_Log_Log();
     	$logs = $modelLogs->fetch($id);
    
     	echo $logs[$field];
     	exit;
    }
    
    public function deleteAction()
    {
    	$mode = $this->_getParam('mode');
    	switch($mode){
    		case 'log':
    			$modelLogs = new vkNgine_Log_Log();
    			break;
    		case 'logins':
    			$modelLogs = new vkNgine_Log_Logins();
    			break;
    		case 'activity':
    			$modelLogs = new vkNgine_Log_Activity();
    			break;
    	}
    	
    	$ids = $this->_getParam('ids');
    
     	$idsArray = explode(',', $ids);
     	
     	foreach($idsArray as $id) {
     		if($id) {
				$modelLogs->delete($id);
			}
		} 
		
		echo Zend_Json::encode(array('id' => $ids));
		exit;
    }
    
	private function userDetails()
	{
		$modelUsers = new Admin_Model_Users();
		
		$userInfo = array();
		foreach ($modelUsers->fetchAll() as $user) {
			$_userInfo = $modelUsers->fetch($user['userId']);
			$userInfo[$user['userId']] = '#' . $_userInfo->getId() . ' [' . $_userInfo->getEmail() . ']';	
		}
		
		return $userInfo;
	}
}