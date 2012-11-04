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
class Admin_WorkoutsController extends vkNgine_Admin_Controller
{
	public function indexAction()
	{
		parent::init();
		parent::ajaxEnabled();
		
		$modelWorkouts = new Model_Workouts();
		
		$page = $this->_getParam('page', 1);
		$orderBy = $this->_getParam('orderBy', 'name');
		$orderBySort = $this->_getParam('orderBySort', 'ASC');
			
		$this->view->workouts = $modelWorkouts->fetchAllWithPagination($page, $orderBy, $orderBySort);
	}
	
	public function addExerciseAction()
	{
		parent::ajaxEnabled();
		
		$form = self::getWorkoutsExercisesEditForm();
		
		$modelWorkoutsExercises = new Model_Workouts_Exercises();
		$modelExercises = new Model_Exercises();
		
		$workoutId = $this->_getParam('workoutId');
		$workoutId = (int) $workoutId;
		
		if($workoutId) {
			$request = $this->getRequest();
			
			if ($request->isPost()) {				
				$post = $request->getPost();
			
				if($form->isValid($post)) {
					$values = $form->getValues();
					
					$modelWorkoutsExercises->insert($values);
					
					echo Zend_Json::encode(array('success' => 1,
											     'dialog'  => 'btn-addexercisetoworkout-dialog',
												 'title'   => $this->t->_('Success Message'),
												 'message' => $this->t->_('Exercise was successfully added'),
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
			
			$form->setHidden($workoutId);
			$form->setExercises($modelExercises->fetchAll()->toArray());
			$this->view->form = $form;
		}
		else {
			new vkNgine_Exception('`workoutId` must be provided');
		}
	}
	
	public function editAction()
	{
		parent::ajaxEnabled();
	
		$modelWorkouts = new Model_Workouts();
		$modelUsers = new Model_Users();
		
		$form = self::getWorkoutsEditForm();
		$form->setUsers($modelUsers->fetchAll()->toArray());
		
		$workoutId = $this->_getParam('workoutId');
		$workoutId = (int) $workoutId;
		
		if($workoutId) {
			$populateData = array();
	
			$workout = $modelWorkouts->fetch($workoutId);
	
			if (count($workout) > 0) {
				$populateData = $workout->toArray();
			}
	
			$form->populate($populateData);
			$form->setHidden($workoutId);
		}
	
		$request = $this->getRequest();
	
		if ($request->isPost()) {							
			$post = $request->getPost();
				
			if ($form->isValid($post)) {
				$values = $form->getValues();
					
				$mode = null;
				if($workoutId) {
					$modelWorkouts->update($workoutId, $values);
					$insertId = $workoutId;
						
					$mode = 'edit';
				}
				else {
					$insertId = $modelWorkouts->insert($values);
	
					$mode = 'add';
				}
	
				$workoutInfo = $modelWorkouts->fetch($insertId);
				
				$dateFormat = new vkNgine_View_Helper_Dateformat();
	
				$newRow = array('mode'			=> $mode,
								'itemId'   		=> $insertId,
								'name'  		=> $workoutInfo->name,
								'startDate'		=> $workoutInfo->startDate,
							    'startDateFormatted' => $dateFormat->dateFormat($workoutInfo->startDate, Zend_Date::DATE_FULL),
								'endDate'		=> $workoutInfo->endDate,
							    'endDateFormatted' => $dateFormat->dateFormat($workoutInfo->endDate, Zend_Date::DATE_FULL),
								'rowId'	   		=> 'workout-',
								'templateName' 	=> 'workoutsTemplate',
								'Save'			=> $this->t->_('Save'),
								'Cancel'		=> $this->t->_('Cancel'),
								'Yes'			=> $this->t->_('Yes'),
								'No'			=> $this->t->_('No'),
								'Never'			=> $this->t->_('Never'),
								'href'			=> $this->_helper->url('edit', 'workouts'),
								'title'			=> $this->t->_('Workout is being edited'),
								'tagTitle'		=> $this->t->_('Edit this workout'),
								'tagTitleDelete' => $this->t->_('Delete this workout'),
								'tagTitleAddExercise' => $this->t->_('Add Exercise to this Workout'),
				);
					
				echo Zend_Json::encode(array('success' => 1,
						'newRow'  => $newRow,
						'dialog'  => 'btn-editworkout-dialog',
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
		$modelWorkouts = new Model_Workouts();
		$modelWorkoutsExercises = new Model_Workouts_Exercises();
		
		$workoutId = $this->_getParam('workoutId');
			
		$workoutsInfo = $modelWorkouts->fetch($workoutId);
		
		$modelWorkouts->delete($workoutId);
		$modelWorkoutsExercises->delete(' workoutId = ' . $workoutId);
	
		echo Zend_Json::encode(array('success' => 1,
				'itemId'  => $workoutId,
				'rowId'   => 'workout-',
				'title'   => $this->t->_('Success Message'),
				'message' => sprintf($this->t->_('%s was successfully deleted'), $workoutsInfo->name),
				'icon'    => 'success'
		));
		exit;
	}
	
	private function getWorkoutsEditForm()
	{
		$form = new Admin_Model_Form_Workouts_Edit(array(
				'method' => 'post',
				'action' => $this->_helper->url('edit', 'workouts'),
		));
	
		return $form;
	}
	
	private function getWorkoutsExercisesEditForm()
	{
		$form = new Admin_Model_Form_Workouts_Exercises_Edit(array(
				'method' => 'post',
				'action' => $this->_helper->url('add-exercise', 'workouts'),
		));
		
		return $form;
	}
}