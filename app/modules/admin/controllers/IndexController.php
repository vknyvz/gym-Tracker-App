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
class Admin_IndexController extends vkNgine_Admin_Controller
{
	public function indexAction()
	{
		parent::init();
		
		$view = Zend_Registry::get('view');
		$view->headTitle($this->t->_('Dashboard'));
		
		$modelUsers = new Model_Users();		
		$modelExercises = new Model_Exercises();
		$modelWorkouts = new Model_Workouts();
		
		$this->view->users = count($modelUsers->fetchAll());
		$this->view->exercises = count($modelExercises->fetchAll());
		$this->view->workouts = count($modelWorkouts->fetchAll());
	}
	
	public function refreshAction()
	{
		$this->_forward('index');
		
		$this->_helper->layout->disableLayout();
	}
	
	public function searchAction()
	{
		$q = $this->_getParam('q');
		
		if($q) { 
			$modelUsers = new Model_Users();
			$users = $modelUsers->search($q);
			
			$this->view->users = $users;
			$this->view->q = $q;
			$this->view->usersFound = count($users);
		}	
		else {
			$this->view->usersFound = 0;
		}	
		
		$this->_helper->layout->disableLayout();
	}
	
	public function myaccountAction()
	{
		$form = self::getMyAccountForm();
		
		$request = $this->getRequest();
		
		if ($request->isPost()) {		
			$post = $request->getPost();
			
			if ($form->isValid($post)) {
				$values = $form->getValues();

				if($this->user->type == 'ADMIN') {
					$modelAdminUsers = new Admin_Model_Users();
					$modelAdminUsers->update($this->user->userId, array('password' => $values['password']));
				}
				
				echo Zend_Json::encode(array('success' => 1, 
											 'dialog'  => 'btn-myaccount-dialog',
											 'title'   => $this->t->_('Success Message'),
										     'message' => $this->t->_('Password was changed successfully'),
											 'icon'    => 'success'
				));
				exit;
			}
			else {
				echo Zend_Json::encode(array('title'   => $this->t->_('Error Message'), 
										 	 'message' => $this->t->_('Please fill out all required fields'),
											 'icon'    => 'error'));
				exit;	
			}
    		
		}
		
		$this->view->form = $form;
		$this->_helper->layout->disableLayout();
	}
	
	private function getMyAccountForm()
	{
		$form = new Admin_Model_Form_MyAccount(array(
			'method' => 'post',
			'action' => $this->_helper->url('myaccount', 'index'),
		));		
    	
		return $form;
	}
}