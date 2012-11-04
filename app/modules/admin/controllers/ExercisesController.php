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
class Admin_ExercisesController extends vkNgine_Admin_Controller
{
	public function indexAction()
	{
		parent::init();
		parent::ajaxEnabled();
	
		$modelExercises = new Model_Exercises();
	
		$page = $this->_getParam('page', 1);
		$orderBy = $this->_getParam('orderBy', 'name');
		$orderBySort = $this->_getParam('orderBySort', 'ASC');
		 
		$this->view->exercises = $modelExercises->fetchAllWithPagination($page, $orderBy, $orderBySort);
	}
	
	public function editAction()
	{
		parent::ajaxEnabled();
		
		$form = self::getExercisesEditForm();
		
		$modelExercises = new Model_Exercises();
		
		$exerciseId = $this->_getParam('exerciseId');
		$exerciseId = (int) $exerciseId;
		
		if($exerciseId) {
			$populateData = array();
		
			$exercise = $modelExercises->fetch($exerciseId);
								
			if (count($exercise) > 0) {
				$populateData = $exercise->toArray();
			}
				
			$form->populate($populateData);				
			$form->setHidden($exerciseId);
		}
		
		$request = $this->getRequest();
		
		if ($request->isPost()) {						
			$post = $request->getPost();
			
			if ($form->isValid($post)) {
				$values = $form->getValues();
					
				$mode = null;
				if($exerciseId) {
					$modelExercises->update($exerciseId, $values);
					$insertId = $exerciseId;
					
					$mode = 'edit';
				}
				else {
					$insertId = $modelExercises->insert($values);
				
					$mode = 'add';
				}
				
				$exerciseInfo = $modelExercises->fetch($insertId);
				
				$newRow= array('mode'			=> $mode,
							   'itemId'    		=> $insertId,
							   'name'  			=> $exerciseInfo->name,
							   'instructions'	=> $exerciseInfo->instructions,
							   'primaryMuscle'	=> $exerciseInfo->primaryMuscle,
							   'secondaryMuscle'=> $exerciseInfo->secondaryMuscle,
							   'rowId'	   		=> 'exercise-',
							   'mechanics'		=> $exerciseInfo->mechanics,
							   'equipmentUsed'  => $exerciseInfo->equipmentUsed,
							   'templateName' 	=> 'exercisesTemplate',
							   'Save'			=> $this->t->_('Save'),
							   'Cancel'			=> $this->t->_('Cancel'),
							   'Yes'			=> $this->t->_('Yes'),
							   'No'				=> $this->t->_('No'),
							   'View'		    => $this->t->_('View'),
							   'href'			=> $this->_helper->url('edit', 'exercises'),
							   'title'			=> $this->t->_('Exercise is being edited'),
							   'tagTitle'		=> $this->t->_('Edit this exercise'),
							   'tagTitleDelete' => $this->t->_('Delete this exercise'),
				);
					
				echo Zend_Json::encode(array('success' => 1,
						'newRow'  => $newRow,
						'dialog'  => 'btn-editexercise-dialog',
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
	
	public function showDetailAction()
	{
		parent::ajaxEnabled();
	
		$field = $this->_getParam('field');
		$id = $this->_getParam('id');
	
		$modelExercises = new Model_Exercises();
		$exercise = $modelExercises->fetch($id);
	
		$instructions = str_replace('Tips:', '<br><br><b>Tips:</b></br></br>', $exercise[$field]);
		echo $instructions;
     	exit;
	}
	
	public function deleteAction()
	{
		$modelExercises = new Model_Exercises();
		
		$exerciseId = $this->_getParam('exerciseId');
		 
		$exerciseInfo = $modelExercises->fetch($exerciseId);
		$modelExercises->delete($exerciseId);
		
		echo Zend_Json::encode(array('success' => 1,
				'itemId'  => $exerciseId,
				'rowId'   => 'exercise-',
				'title'   => $this->t->_('Success Message'),
				'message' => sprintf($this->t->_('%s was successfully deleted'), $exerciseInfo->name),
				'icon'    => 'success'
		));
		exit;
	}
	
	private function getExercisesEditForm()
	{
		$form = new Admin_Model_Form_Exercises_Edit(array(
				'method' => 'post',
				'action' => $this->_helper->url('edit', 'exercises'),
		));
		 	
		return $form;
	}
}