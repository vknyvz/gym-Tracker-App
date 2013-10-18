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
class Admin_FoodsController extends vkNgine_Admin_Controller
{
	public function indexAction()
	{
		parent::init();
		parent::ajaxEnabled();
		
		$modelFoods = new Model_Foods();
		
		$page = $this->_getParam('page', 1);
		$orderBy = $this->_getParam('orderBy', 'name');
		$orderBySort = $this->_getParam('orderBySort', 'ASC');
			
		$this->view->foods = $modelFoods->fetchAllWithPagination($page, $orderBy, $orderBySort);
	}
	
	public function editAction()
	{
		parent::ajaxEnabled();
			
		$modelFoods = new Model_Foods();
		
		$form = self::getFoodsEditForm();
		
		$foodId = $this->_getParam('foodId');
		$foodId = (int) $foodId;
	
		if($foodId) {
			$populateData = array();
	
			$food = $modelFoods->fetch($foodId);
	
			if (count($food) > 0) {
				$populateData = $food->toArray();
			}
	
			$form->populate($populateData);
			$form->setHidden($foodId);
		}
	
		$request = $this->getRequest();
	
		if ($request->isPost()) {
			$post = $request->getPost();
	
			if ($form->isValid($post)) {
				$values = $form->getValues();
					
				$mode = null;
				if($foodId) {
					$modelFoods->update($foodId, $values);
					$insertId = $foodId;
	
					$mode = 'edit';
				}
				else {
					$insertId = $modelFoods->insert($values);
	
					$mode = 'add';
				}
	
				$foodInfo = $modelFoods->fetch($insertId);
	
				$dateFormat = new vkNgine_View_Helper_Dateformat();
				
				$newRow = array('mode'			=> $mode,
								'itemId'   		=> $insertId,
								'name'  		=> $foodInfo->name,
								'servingSize'   => $foodInfo->servingSize,
								'servingSizeType'   => $foodInfo->servingSizeType,
								'protein'		=> $foodInfo->protein,
								'calories'		=> $foodInfo->calories, 
								'carbs'			=> $foodInfo->carbs, 
								'fat'			=> $foodInfo->fat, 
								'sugar'			=> $foodInfo->sugar, 
								'sodium'		=> $foodInfo->sodium, 
								'fiber'			=> $foodInfo->fiber, 
								'cholesterol'	=> $foodInfo->cholesterol, 
								'rowId'	   		=> 'food-',
								'templateName' 	=> 'foodsTemplate',
								'Save'			=> $this->t->_('Save'),
								'Cancel'		=> $this->t->_('Cancel'),
								'Yes'			=> $this->t->_('Yes'),
								'No'			=> $this->t->_('No'),
								'Never'			=> $this->t->_('Never'),
								'href'			=> $this->_helper->url('edit', 'foods'),
								'title'			=> $this->t->_('Food is being edited'),
								'tagTitle'		=> $this->t->_('Edit this food'),
								'tagTitleDelete' => $this->t->_('Delete this food'),
				);
					
				echo Zend_Json::encode(array('success' => 1,
						'newRow'  => $newRow,
						'dialog'  => 'btn-editfood-dialog',
						'row'     => true,
						'title'   => $this->t->_('Success Message'),
						'message' => sprintf($this->t->_('%s was successfully added'), $values['name']),
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
		$modelFoods = new Model_Foods();
		
		$foodId = $this->_getParam('foodId');
			
		$foodInfo = $modelFoods->fetch($foodId);
	
		$modelFoods->delete($foodId);
	
		echo Zend_Json::encode(array('success' => 1,
									 'itemId'  => $foodId,
									 'rowId'   => 'food-',
									 'title'   => $this->t->_('Success Message'),
									 'message' => sprintf($this->t->_('%s was successfully deleted'), $foodInfo->name),
									 'icon'    => 'success'
		));
		exit;
	}
	
	private function getFoodsEditForm()
	{
		$form = new Admin_Model_Form_Foods_Edit(array(
				'method' => 'post',
				'action' => $this->_helper->url('edit', 'foods'),
		));
	
		return $form;
	}
}