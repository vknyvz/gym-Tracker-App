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
class Admin_MealsController extends vkNgine_Admin_Controller
{
	public function indexAction()
	{
		parent::init();
		parent::ajaxEnabled();
		
		$modelMeals = new Model_Meals();
		
		$page = $this->_getParam('page', 1);
		$orderBy = $this->_getParam('orderBy', 'title');
		$orderBySort = $this->_getParam('orderBySort', 'ASC');
			
		$this->view->meals = $modelMeals->fetchAllWithPagination($page, $orderBy, $orderBySort);
	}
	
	public function addFoodAction()
	{
		parent::ajaxEnabled();
	
		$form = self::getFoodsMealsEditForm();
	
		$modelMealsFoods = new Model_Meals_Foods();
		$modelFoods = new Model_Foods();
	
		$mealId = $this->_getParam('mealId');
		$mealId = (int) $mealId;
	
		if($mealId) {
			$request = $this->getRequest();
				
			if ($request->isPost()) {
				$post = $request->getPost();
					
				if($form->isValid($post)) {
					$values = $form->getValues();
						
					$modelMealsFoods->insert($values);
						
					echo Zend_Json::encode(array('success' => 1,
							'dialog'  => 'btn-addfoodstomeals-dialog',
							'title'   => $this->t->_('Success Message'),
							'message' => $this->t->_('Food was successfully added'),
							'icon'    => 'success'
					));
					exit;
				}
				else {
					$error = $form->getErrors();
						
					echo Zend_Json::encode(array('title'   => $this->t->_('Error Message'),
							'message' => $this->t->_('Please fill out all required fields'),
							'icon'    => 'error'
					));
					exit;
				}
			}
				
			$form->setHidden($mealId);
			$form->setFoods($modelFoods->fetchAll()->toArray());
			$this->view->form = $form;
		}
		else {
			new vkNgine_Exception('`mealId` must be provided');
		}
	}
	
	public function editAction()
	{
		parent::ajaxEnabled();
	
		$modelMeals = new Model_Meals();
		$modelUsers = new Model_Users();
	
		$form = self::getMealsEditForm();
		$form->setUsers($modelUsers->fetchAll()->toArray());
	
		$mealId = $this->_getParam('mealId');
		$mealId = (int) $mealId;
	
		if($mealId) {
			$populateData = array();
	
			$meal = $modelMeals->fetch($mealId);
	
			if (count($meal) > 0) {
				$populateData = $meal->toArray();
			}
	
			$form->populate($populateData);
			$form->setHidden($mealId);
		}
	
		$request = $this->getRequest();
	
		if ($request->isPost()) {
			$post = $request->getPost();
	
			if ($form->isValid($post)) {
				$values = $form->getValues();
					
				$mode = null;
				if($mealId) {
					
					$modelMeals->update($mealId, $values);
					$insertId = $mealId;
	
					$mode = 'edit';
				}
				else {
					$insertId = $modelMeals->insert($values);
	
					$mode = 'add';
				}
	
				$mealInfo = $modelMeals->fetch($insertId);
	
				$dateFormat = new vkNgine_View_Helper_Dateformat();
	
				$newRow = array('mode'			=> $mode,
								'itemId'   		=> $insertId,
								'titlee'  		=> $mealInfo->title,
								'rowId'	   		=> 'meal-',
								'templateName' 	=> 'mealsTemplate',
								'Save'			=> $this->t->_('Save'),
								'Cancel'		=> $this->t->_('Cancel'),
								'Yes'			=> $this->t->_('Yes'),
								'No'			=> $this->t->_('No'),
								'Never'			=> $this->t->_('Never'),
								'href'			=> $this->_helper->url('edit', 'meals'),
								'href2'			=> $this->_helper->url('add-food', 'meals'),
								'title'			=> $this->t->_('Meal is being edited'),
								'tagTitleFood'  => $this->t->_('Add Food to this Meal'),
								'tagTitle'		=> $this->t->_('Edit this meal'),
								'tagTitleDelete' => $this->t->_('Delete this meal'),
				);
					
				echo Zend_Json::encode(array('success' => 1,
						'newRow'  => $newRow,
						'dialog'  => 'btn-editmeal-dialog',
						'row'     => true,
						'title'   => $this->t->_('Success Message'),
						'message' => sprintf($this->t->_('%s was successfully added'), $values['title']),
						'icon'    => 'success'
				));
				exit;
			}
			else {
				$error = $form->getErrors();
					
				echo Zend_Json::encode(array('title'   => $this->t->_('Error Message'),
						'message' => $this->t->_('Please fill out all required fields'),
						'icon'    => 'error' ));
				exit;
			}
		}
	
		$this->view->form = $form;
	}
	
	public function deleteAction()
	{
		$modelMeals = new Model_Meals();
		$modelMealsFoods = new Model_Meals_Foods();
	
		$mealId = $this->_getParam('mealId');
			
		$mealInfo = $modelMeals->fetch($mealId);
	
		$modelMeals->delete($mealId);
		$modelMealsFoods->delete(' mealId = ' . $mealId);
	
		echo Zend_Json::encode(array('success' => 1,
									 'itemId'  => $mealId,
									 'rowId'   => 'meal-',
									 'title'   => $this->t->_('Success Message'),
									 'message' => sprintf($this->t->_('%s was successfully deleted'), $mealInfo->title),
									 'icon'    => 'success'
		));
		exit;
	}
	
	private function getMealsEditForm()
	{
		$form = new Admin_Model_Form_Meals_Edit(array(
			'method' => 'post',
			'action' => $this->_helper->url('edit', 'meals'),
		));
	
		return $form;
	}
	
	private function getFoodsMealsEditForm()
	{
		$form = new Admin_Model_Form_Meals_Foods_Edit(array(
				'method' => 'post',
				'action' => $this->_helper->url('add-food', 'meals'),
		));
	
		return $form;
	}
}