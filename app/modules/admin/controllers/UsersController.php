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
class Admin_UsersController extends vkNgine_Admin_Controller
{
	public function indexAction()
	{
		parent::init();
		parent::ajaxEnabled();
		
		$modelUsers = new Admin_Model_Users();
		
		$page = $this->_getParam('page', 1);
		$orderBy = $this->_getParam('orderBy', $modelUsers->getPrimary());
    	$orderBySort = $this->_getParam('orderBySort', 'ASC');
    	
		$level = array();
		foreach ($modelUsers->fetchAll() as $user) {
			$userInfo = $modelUsers->fetch($user['userId']);
			$level[$user['userId']] = $userInfo->level;			
		}
		
		$this->view->level = $level;
		$this->view->users = $modelUsers->fetchAllWithPagination($page, $orderBy, $orderBySort);
	}
	
	public function editAction()
	{	
		parent::ajaxEnabled();
				
		$form = self::getUsersEditForm();
		
		$modelAdminUsers = new Admin_Model_Users();
		
		$userId = $this->_getParam('userId');
		$userId = (int) $userId;
		
		if($userId) {
			$populateData = array();

			$user = $modelAdminUsers->fetch($userId);
			
			$helper = new vkNgine_View_Helper_PhoneFormat();
			
			if (count($user) > 0) {
				$populateData = $user->toArray();
				$populateData['password'] = null;
				$populateData['level'] = $user->level;
				$populateData['phone'] = $helper->phoneFormat($user->phone);
			}
			
			$form->adminMode($user['email']);
			$form->populate($populateData);
			
			$form->setHidden($userId);
		}
		
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$post = $request->getPost();
			
			if ($form->isValid($post)) {
				$values = $form->getValues();
				
				$mode = null;
				if($userId) {
					if($values['password'] == false) {
						unset($values['password']);
					}
					
					$values['phone'] = str_replace('(', '', $values['phone']);
					$values['phone'] = str_replace(')', '', $values['phone']);
					$values['phone'] = str_replace('-', '', $values['phone']);
					
					$modelAdminUsers->update($userId, $values);
					$insertId = $userId;
					
					$mode = 'edit';
				}
				else {
					$insertId = $modelAdminUsers->insert($values);
					
					$mode = 'add';
				}
				
				if($values['email'] != $this->user->email) {
					$href = '/admin/auth/logout';
				}
				else {
					$href = '/admin/';
				}
				
				$userInfo = $modelAdminUsers->fetch($insertId);
				
				$dateFormat = new vkNgine_View_Helper_Dateformat();
				
				$newRow= array('mode'			=> $mode,
							   'itemId'    		=> $insertId,
							   'fullName'  		=> $userInfo->firstName . ' ' . $userInfo->lastName,
							   'email'	   		=> $userInfo->email,
							   'level'	   		=> $this->t->_(ucfirst(strtolower($userInfo->level))),
							   'active'	   		=> $this->t->_($userInfo->active),
							   'lastLogin' 		=> ($userInfo->lastLogin != '0000-00-00 00:00:00') ? $dateFormat->dateFormat($userInfo->lastLogin, Zend_Date::DATETIME) : $this->t->_('Never'),
							   'rowId'	   		=> 'user-',
							   'masterUser'		=> (vkNgine_Config::getSystemConfig()->master->user == $userInfo->userId) ? 'yes' : 'no',
							   'templateName' 	=> 'usersTemplate',
							   'Save'			=> $this->t->_('Save'),
							   'Cancel'			=> $this->t->_('Cancel'),
							   'Yes'			=> $this->t->_('Yes'),
							   'No'				=> $this->t->_('No'),
							   'href'			=> $this->_helper->url('edit', 'users'),
							   'title'			=> $this->t->_('User is being edited'),
							   'tagTitle'		=> $this->t->_('Edit this user'),
							   'tagTitleDelete' => $this->t->_('Delete this user'),
				);
				
				echo Zend_Json::encode(array('success' => 1, 
											 'newRow'  => $newRow,
											 'dialog'  => 'btn-edituser-dialog',
											 'row'     => true,
											 'title'   => $this->t->_('Success Message'),
										     'message' => sprintf($this->t->_('%s was successfully added'), $values['firstName'] . ' ' . $values['lastName']),
											 'icon'    => 'success'
				));
				exit;
			}
			else {
				$error = $form->getErrors();
				
				if(!empty($error['email'][0]) & (@$error['email'][0] == 'Email already registered')){
					$message = 'Email already registered';
				}
				else {
					$message = 'Please fill out all required fields';
				}
				
				echo Zend_Json::encode(array('title'   => $this->t->_('Error Message'), 
										 	 'message' => $this->t->_($message),
											 'icon'    => 'error' ));
				exit;	
			}
    		
		}
		
		$this->view->form = $form;
	}	
	
	public function deleteAction()
	{
		$modelUsers = new Model_Users();
		$modelAdminUsers = new Admin_Model_Users();
		
	    $userId = $this->_getParam('userId');
	    
	    if(vkNgine_Config::getSystemConfig()->master->user == $userId) {
	    	return new vkNgine_Exception('This user can\'t be deleted');
	    }
	    
		$userInfo = $modelUsers->fetch($userId);
		$modelUsers->delete($userId);
		$modelAdminUsers->delete($userId);
		
		echo Zend_Json::encode(array('success' => 1,
									 'itemId'  => $userId,
									 'rowId'   => 'user-',
									 'title'   => $this->t->_('Success Message'),
								     'message' => sprintf($this->t->_('%s was successfully deleted'), $userInfo->getFullName()),
									 'icon'    => 'success'
		));
		exit;
    }	
    
	private function getUsersEditForm()
	{
		$form = new Admin_Model_Form_Users_Edit(array(
			'method' => 'post',
			'action' => $this->_helper->url('edit', 'users'),
		));		
    	
		$form->setStates();
		
		return $form;
	}
}