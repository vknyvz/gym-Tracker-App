<?php
class MyAccountController extends vkNgine_Public_Controller
{
	public function init()
	{
		parent::init();
	}
	
	public function indexAction()
	{
		parent::ajaxEnabled();
		
		$formCalendar = self::getMyaccountSettingsForm();
		
		$populateData = array();
		
		$modelUsers = new Model_Users();
		
		if(Zend_Registry::get('mobile')){
			$formCalendar->setMobile();
			$populateData['calendarView'] = 'Monthly';
			$this->view->mobile = true;
		}
		else {
			$populateData['calendarView'] = $this->user['calendarView'];
		}
		
		$populateData['notifications'] = $this->user['notifications'];
		
		$formCalendar->populate($populateData);
		
		$request = $this->getRequest();
		
		if($this->_getParam('method')) {
			$what = null;
			if($this->_getParam('calendarview')) {
				$what = 'Calendar view';
				
				$data['calendarView'] = $this->_getParam('value');
					
				$modelUsers->update($this->user->getId(), $data);
			}
			elseif($this->_getParam('notifications')) {
				$what = 'Notifications';
				
				$data['notifications'] = $this->_getParam('value');
					
				$modelUsers->update($this->user->getId(), $data);
			}
			
			echo Zend_Json::encode(array('success' => 1,
										 'title'   => $this->t->_('Success Message'),
										 'message' => $this->t->_($what . ' was successfully updated')));
			exit;
		}
		
		$this->view->formSettings = $formCalendar;
	}
	
	public function myPlateAction()
	{
		$request = $this->getRequest();
						
		if($request->isGet()) {
			$food = $this->_getParam('food');
			$date = $this->_getParam('date');
			$foodSearch = $this->_getParam('foodsearch');
			
			if($food) {
				$modelFoods = new Model_Foods();
				
				header("Content-Type: application/json");
			
				$aResults = $modelFoods->fetchResults($foodSearch);
				
				echo "{\"results\": [";
				
				$arr = array();
				for ($i=0; $i<count($aResults); $i++)
				{
					$arr[] = '{"id": "' . $aResults[$i]['foodId'] . '", 
							   "value": "' . $aResults[$i]['name'] . '", 
							   "servingSize": "' . $aResults[$i]['servingSize'] .' ' . $aResults[$i]['servingSizeType'] . '",
							   "servingSizeType": "' . $aResults[$i]['servingSizeType'] . '",
							   "info": "' . $this->t->_('Calories') . ': '.$aResults[$i]['calories'].' | ' . $this->t->_('Protein') . ': '.$aResults[$i]['protein'].' | ' . $this->t->_('Fat') . ': '.$aResults[$i]['fat'].' | ' . $this->t->_('Sugar') . ': '.$aResults[$i]['sugar'].' | ' . $this->t->_('Carbs') . ': '.$aResults[$i]['carbs'].' | ' . $this->t->_('Sodium') . ': '.$aResults[$i]['sodium'].' | ' . $this->t->_('Fiber') . ': '.$aResults[$i]['fiber'].' | ' . $this->t->_('Cholesterol') . ': '.$aResults[$i]['cholesterol'].' "}';
				}
				
				echo implode(", ", $arr);
				echo "]}";
						
				exit;
			}
			elseif($date) {
				$mealId = $this->_getParam('mealId', 0);
				$mealId = (int) $mealId;
				
				$foodIds = $this->_getParam('foodIds', 0);

				$what = null;
				if($mealId){
					$what = 'Meal';
					
					$modelDailyIntake = new Public_Model_Daily_Intake();
					$modelDailyIntake->insert(array('userId' => $this->user->getId(),
												    'mealId' => $mealId,
													'date'   => $date));	
				}
				elseif($foodIds){
					$what = 'Food(s)';
					
					$foodIds = explode(',', $foodIds);
				
					foreach($foodIds as $foodId){
						$foodId = (int) $foodId;
						if($foodId) {
							$modelDailyIntake = new Public_Model_Daily_Intake();
							$modelDailyIntake->insert(array('userId' 	  => $this->user->getId(),
															'foodId' 	  => $foodId,
															'servingSize' => $this->_getParam('servingSize'),
															'servingSizes'=> $this->_getParam('servingSizes'),
															'date'   	  => $date));
						}
					}
				}
				
				echo Zend_Json::encode(array('success' => 1));
				exit;
			}
		}
		
		$modelMeals = new Model_Meals();
		
		$formMeals = self::getMyaccountMealsForm();
		$formMeals->setMeals($modelMeals->fetchAll('userId = ' . $this->user->getId())->toArray());
		
		$formFoods = self::getMyaccountFoodsForm();
		
		$modelDailyIntake = new Public_Model_Daily_Intake();
				
		$this->view->dailyIntake = $modelDailyIntake->fetchAll("date = '" . date('Y-m-d') . "' and userId = " . (int) $this->user->getId() . "")->toArray();
		$this->view->formMeals = $formMeals;
		$this->view->formFoods = $formFoods;		
	}
	
	public function myWorkoutsAction()
	{
		$modelWorkouts = new Model_Workouts();
		$this->view->workouts = $modelWorkouts->fetchAll('userId = ' . $this->user->getId())->toArray();
	}

	public function myMeasurementsAction()
	{
		$modelMeasurements = new Public_Model_Measurements();
		$this->view->measurements = $modelMeasurements->fetchAll('userId = ' . $this->user->getId())->toArray();
	}
	
	public function languageAction()
	{
		$lang = $this->_getParam('lang');
	
		$language = new Zend_Session_Namespace('language');
	
		if($lang) {
			$language->lang = $lang;
			$language->session = true;
			$language->config = false;
		}
	
		echo Zend_Json::encode(array('success' => 1));
		exit;
	}
	
	public function editSetfieldAction()
	{
		$id = $this->_getParam('id');
		$field = $this->_getParam('field');
		$value = $this->_getParam('value');
		
		$result = array('success' => 0);
		
		if($id and $field and $value) {
			$modelWorkoutsExercises = new Model_Workouts_Exercises();
			$modelWorkoutsExercises->update(array($field => $value), 'id = ' . $id);
			
			$result = array('success' => 1);
		}
		
		echo Zend_Json::encode($result);
		exit;
	}
	
	public function editWorkoutAction()
	{
		parent::ajaxEnabled(true);
		
		$id = $this->_getParam('workoutId');
		
		$form = self::getEditWorkoutForm();
		
		$modelWorkouts = new Model_Workouts();
		
		if($id) {
			$populateData = array();

			$workout = $modelWorkouts->fetch($id);
						
			if (count($workout) > 0) {
				$populateData = $workout->toArray();
				$populateData['startDate'] = ($workout->startDate == '0000-00-00') ? '' : $workout->startDate;				
				$populateData['endDate'] = ($workout->endDate == '0000-00-00') ? '' : $workout->endDate;				
			}
			
			$form->populate($populateData);
			$form->setHidden($id);
		}
		
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$post = $request->getPost();
				
			if ($form->isValid($post)) {
				$values = $form->getValues();

				if($id) {
					$modelWorkouts->update($id, $values);
				}
				else {
					$values['userId'] = $this->user->getId();
					$id = $modelWorkouts->insert($values);
				}
				
				echo Zend_Json::encode(array('success' => 1,
											 'href'    => '/my-account/my-workouts',
											 'dialog'  => 'btn_edit_workout_dialog',
											 'title'   => $this->t->_('Success Message'),
											 'message' => $this->t->_('Workout was successfully edited'),
											 'icon'    => 'success'
				));
				exit;
			}
			else {
				echo Zend_Json::encode(array('title'   => $this->t->_('Error Message'),
											 'message' => $this->t->_('At least one field must be filled'),
											 'icon'    => 'error' ));
				exit;
			}
		}
		
		$this->view->form = $form;
	}
	
	public function editMeasurementAction()
	{
		parent::ajaxEnabled(true);
		
		$form = self::getEditMeasurementsForm();
		
		$modelMeasurements = new Public_Model_Measurements();
		
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$post = $request->getPost();
		
			if ($form->isValid($post)) {
				$values = $form->getValues();
				
				$values['userId'] = $this->user->getId();
				$id = $modelMeasurements->insert($values);
				
				echo Zend_Json::encode(array('success' => 1,
											 'href'    => '/my-account',
											 'dialog'  => 'btn_edit_measurements_dialog',
											 'title'   => $this->t->_('Success Message'),
											 'message' => $this->t->_('Measurement data was successfully inserted'),
											 'icon'    => 'success'
				));
				exit;
			}
			else {
				echo Zend_Json::encode(array('title'   => $this->t->_('Error Message'),
											 'message' => $this->t->_('Please fill out all required fields'),
											 'icon'    => 'error' ));
				exit;
			}
		}
		
		$this->view->form = $form;
	}
	
	public function manageWorkoutAction()
	{
		parent::ajaxEnabled(true);
		
		$id = (int) $this->_getParam('id');
		
		$modelWorkouts = new Model_Workouts();
		$modelExercises = new Model_Exercises();
		$modelWorkoutsExercises = new Model_Workouts_Exercises();
		
		$form = self::getManageWorkoutForm();
		
		$exerciseDetail = array();
		foreach($modelExercises->fetchAll() as $exercise){
			$exerciseDetail[$exercise['exerciseId']] = $exercise['name'];
		}
		
		$this->view->exerciseDetail = $exerciseDetail;
		$this->view->workout = $modelWorkouts->fetch($id);
		$this->view->exercises = $modelWorkoutsExercises;
		$this->view->form = $form;
	}
	
	public function viewWorkoutAction()
	{
		$id = (int) $this->_getParam('id');
		
		$modelWorkouts = new Model_Workouts();
		$modelExercises = new Model_Exercises();
		$modelWorkoutsExercises = new Model_Workouts_Exercises();
		
		$exerciseDetail = array();
		foreach($modelExercises->fetchAll() as $exercise){
			$exerciseDetail[$exercise['exerciseId']] = $exercise['name'];
		}
		
		$this->view->exerciseDetail = $exerciseDetail;
		$this->view->exercises = $modelWorkoutsExercises;
		$this->view->workout = $modelWorkouts->fetchAll('workoutId = ' . $id)->current();
	}
	
	public function deleteWorkoutAction()
	{
		$id = $this->_getParam('id');
	
		$modelWorkouts = new Model_Workouts();
		$modelWorkoutsExercises = new Model_Workouts_Exercises();
	
		$modelWorkouts->delete($id);
		$modelWorkoutsExercises->delete(' workoutId = ' . $id);
	
		exit;
	}
	
	public function deleteMeasurementAction()
	{
		$id = $this->_getParam('id');
	
		$modelMeasurements = new Public_Model_Measurements();
		$modelMeasurements->delete($id);
	
		exit;
	}
	
	private function getMyaccountSettingsForm()
	{
		$form = new Public_Model_Form_Myaccount_Settings(array(
			'method' => 'post',
			'action' => $this->_helper->url('index', 'my-account'),
		));
	
		return $form;
	}
	
	private function getMyaccountMealsForm()
	{
		$form = new Public_Model_Form_Myaccount_Meals(array(
			'method' => 'post',
			'action' => $this->_helper->url('my-plate', 'my-account'),
		));
		
		return $form;
	}
	
	private function getMyaccountFoodsForm()
	{
		$form = new Public_Model_Form_Myaccount_Foods(array(
			'method' => 'post',
			'action' => $this->_helper->url('my-plate', 'my-account'),
		));
	
		return $form;
	}
	
	private function getEditWorkoutForm()
	{
		$form = new Public_Model_Form_Workout_Edit(array(
			'method' => 'post',
			'action' => $this->_helper->url('edit-workout', 'my-account'),
		));
	
		return $form;
	}
	
	private function getManageWorkoutForm()
	{
		$form = new Public_Model_Form_Workout_Manage(array(
			'method' => 'post',
			'action' => $this->_helper->url('manage-workout', 'my-account'),
		));
		
		return $form;
	}
	
	private function getEditMeasurementsForm()
	{
		$form = new Public_Model_Form_Measurements_Edit(array(
			'method' => 'post',
			'action' => $this->_helper->url('edit-measurement', 'my-account'),
		));
	
		return $form;
	}
}