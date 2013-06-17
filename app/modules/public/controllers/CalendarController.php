<?php
class CalendarController extends vkNgine_Public_Controller
{
	public function init()
	{
		parent::init();
	}
	
	public function indexAction()
	{
		$this->_forward('monthly');
	}
	
	public function monthlyAction()
	{
		parent::ajaxEnabled();
		
		$options = array('month' => $this->_getParam('month'),
						 'year'  => $this->_getParam('year'),
						 'day'   => $this->_getParam('day')
		);
		$calendar = vkNgine_Calendar::buildMonthly($options);
		
		$modelWorkouts = new Model_Workouts();
			
		$workoutDetail = array();
		foreach($modelWorkouts->fetchAll() as $workout){
			$workoutDetail[$workout['workoutId']] = $workout['name'];
		}
		
		$this->view->workoutDetail = $workoutDetail;
		$this->view->links = array('next' => $calendar->nextMonth('object'), 'prev' => $calendar->prevMonth('object'));
		$this->view->calendar = $calendar;
			
		$start = date('Y-m-d', $calendar->getTimeStamp());
		$end = strtotime(date("Y-m-d", strtotime($start)) . " +1 month");
		$end = date('Y-m-d', $end);
			
		$modelMeasurements = new Public_Model_Measurements();
			
		$this->view->param = $this->_getAllParams();
		
		$this->view->otherdata = $modelMeasurements->fetchAll("userId = '" . $this->user->getId() . "' and date >= '" . $start . "' and date < '" . $end . "' ")->toArray();
	}
	
	public function weeklyAction()
	{
		parent::ajaxEnabled();
		
		$options = array('month' => $this->_getParam('month'),
						 'year'  => $this->_getParam('year'),
						 'day'   => $this->_getParam('day')
		);
		$calendar = vkNgine_Calendar::buildWeekly($options);
		
		$modelWorkouts = new Model_Workouts();
			
		$workoutDetail = array();
		foreach($modelWorkouts->fetchAll() as $workout){
			$workoutDetail[$workout['workoutId']] = $workout['name'];
		}

		$this->view->param = $this->_getAllParams();
		$this->view->workoutDetail = $workoutDetail;
		$this->view->calendar = $calendar;
	}
	
	public function addDailyAction()
	{
		parent::ajaxEnabled(true);
		 
		$date = $this->_getParam('date');
	
		$form = self::getDailyExercisesForm();
				 
		$modelWorkouts = new Model_Workouts();
		$modelDailyExcercises = new Public_Model_Daily_Exercises();
		 
		$request = $this->getRequest();
		 
		if ($request->isPost()) {
			$post = $request->getPost();
	
			if($form->isValid($post)) {
				$values = $form->getValues();
				if(!$values['workoutId'] and !$values['activity'] and !$values['type']) {
					echo Zend_Json::encode(array('title'   => $this->t->_('Error Message'),
												 'message' => $this->t->_('At least one field must be filled'),
												 'icon'    => 'error' ));
					exit;
				}
				 
				$values['userId'] = $this->user->getId();
				
				$forward = $values['forward'];
				unset( $values['forward']);
	
				$modelDailyExcercises->insert($values);
				
				echo Zend_Json::encode(array('success' => 1,
					'href'    => '/calendar/' . $forward,
					'dialog'  => 'lnk-addexercise-dialog',
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
		 
		$form->setWorkouts($modelWorkouts->fetchAll('userId = ' . $this->user->getId())->toArray());
		$form->setHidden($date, $this->_getParam('forward'));

		$this->view->param = $this->_getAllParams();
		$this->view->form = $form;
	}
	
	public function markDayAction()
	{
		parent::ajaxEnabled();
		
		$date = $this->_getParam('date');
		$mode = $this->_getParam('mode');
		
		$modelDailyDetails = new Public_Model_Daily_Details();
		$dailyDetails = $modelDailyDetails->fetchOneByDate($date, $this->user);
		
		if($mode == 'off'){
			$values['value'] = 'LightSlateGray';
		}
		else {
			$values['value'] = null;
		}
		
		$values['date'] = $date;
		$values['userId'] = $this->user->getId();
		
		if($dailyDetails){
			$modelDailyDetails->update($values, 'id = ' . $dailyDetails['id']);
		}
		else {
			$modelDailyDetails->insert($values);
		}	
		
		echo Zend_Json::encode(array('success'  => 1,
									 'loadThis' => '/calendar/',
									 'loadOn'	=> 'content',
									 'title'    => $this->t->_('Success Message'),
									 'message'  => $this->t->_('Day was successfully marked'),
									 'icon'     => 'success'
		));
		
		exit;
	}
	
	public function viewDayAction()
	{
		parent::ajaxEnabled();
		
		$date = $this->_getParam('date');
		
		$modelDailyExercises = new Public_Model_Daily_Exercises();
		$modelWorkouts = new Model_Workouts();
		$modelWorkoutsExercises = new Model_Workouts_Exercises();
		$modelDailyDetails = new Public_Model_Daily_Details();
		
		$workoutDetail = array();
		foreach($modelWorkouts->fetchAll() as $workout){
			$workoutDetail[$workout['workoutId']] = $workout['name'];
		}
					
		$this->view->dailyDetails = $modelDailyDetails->fetchAll("date = '" . $date . "' and userId = " . $this->user->getId() ." and type = 'SUPPLEMENT' ")->toArray();
		$this->view->workoutExercises = $modelWorkoutsExercises;
		$this->view->workoutDetail = $workoutDetail;
		$this->view->detail = $modelDailyExercises->fetchAll("date = '" . $date . "' and workoutId != 0 and userId = " . $this->user->getId())->toArray();
		$this->view->detail2 = $modelDailyExercises->fetchAll("date = '" . $date . "' and workoutId = 0 and userId = " . $this->user->getId())->toArray();
		$this->view->param = $this->_getAllParams();
	}
	
	public function dailyDetailAction()
	{
		parent::ajaxEnabled(true);
		 
		$date = $this->_getParam('date');
		 
		$form = self::getDailyDetailsForm();
	
		$modelDailyDetails = new Public_Model_Daily_Details();
	
		$request = $this->getRequest();
	
		if ($request->isPost()) {
			$post = $request->getPost();
	
			if($post['type']) {
				if(empty($post['color']) and empty($post['value'])) {
					echo Zend_Json::encode(array('title'   => $this->t->_('Error Message'),
							'message' => $this->t->_('Please fill out all required fields'),
							'icon'    => 'error'
					));
					exit;
				}
			}
	
			if($form->isValid($post)) {
				$values = $form->getValues();
				 
				if($values['color']) {
					$values['value'] = $values['color'];
				}
				unset($values['color']);
	
				$values['userId'] = $this->user->getId();
				
				$forward = $values['forward'];
				unset( $values['forward']);
				 
				$modelDailyDetails->insert($values);
				 
				echo Zend_Json::encode(array('success' => 1,
						'href'	   => '/calendar/' . $forward,
						'dialog'  => 'lnk-dailyDetails-dialog',
						'title'   => $this->t->_('Success Message'),
						'message' => $this->t->_('Day details was successfully added'),
						'icon'    => 'success'
				));
				exit;
			}
			else {
				echo Zend_Json::encode(array('title'   => $this->t->_('Error Message'),
						'message' => $this->t->_('Please fill out all required fields'),
						'icon'    => 'error'
				));
				exit;
			}
		}
		 
		$form->setHidden($date, $this->_getParam('forward'));
		
		$this->view->form = $form;
	}
	
	public function setWorkoutDayAction()
	{
		$id = $this->_getParam('id');
			
		$modelWorkouts = new Model_Workouts();
		$day = $modelWorkouts->fetch($id);
			
		$form = self::getDailyExercisesForm();
		$form->setDay($day['day']);
			
		echo $form->workoutDay->render();
		exit;
	}
	
	public function viewDetailAction()
	{
		parent::ajaxEnabled(true);
			
		$id = $this->_getParam('id');
			
		$modelDailyExercises = new Public_Model_Daily_Exercises();
		$modelWorkouts = new Model_Workouts();
		$modelWorkoutsExercises = new Model_Workouts_Exercises();
		$modelExercises = new Model_Exercises();
			
		$detail = $modelDailyExercises->fetchRow('id = ' . $id)->toArray();
			
		$this->view->workoutExercises = $modelWorkoutsExercises->fetchAll('workoutId = ' . $detail['workoutId'] . ' and day = ' . $detail['workoutDay'], 'order ASC')->toArray();
		$this->view->workoutDetail = $modelWorkouts->fetch($detail['workoutId']);
		$this->view->exercises = $modelExercises;
		$this->view->detail = $detail;
	}
	
	public function viewDayDetailAction()
	{
		parent::ajaxEnabled(true);
	
		$id = $this->_getParam('id');
			
		$modelDailyDetails = new Public_Model_Daily_Details();
			
		$this->view->details = $modelDailyDetails->fetchRow('id = ' . $id);
	}
	
	public function deleteDailyLogAction()
	{
		$modelDailyExercises = new Public_Model_Daily_Exercises();
	
		$id = $this->_getParam('id');
		 
		$modelDailyExercises->delete($id);
		 
		exit;
	}
	
	public function deleteDayDetailAction()
	{
		$modelDailyDetails = new Public_Model_Daily_Details();
	
		$id = $this->_getParam('id');
	
		$modelDailyDetails->delete($id);
	
		exit;
	}
	
	private function getDailyExercisesForm()
	{
		$form = new Public_Model_Form_Daily_Exercises(array(
				'method' => 'post',
				'action' => $this->_helper->url('add-daily', 'calendar'),
		));
	
		return $form;
	}
	
	private function getDailyDetailsForm()
	{
		$form = new Public_Model_Form_Daily_Details(array(
				'method' => 'post',
				'action' => $this->_helper->url('daily-detail', 'calendar'),
		));
		 
		return $form;
	}
}