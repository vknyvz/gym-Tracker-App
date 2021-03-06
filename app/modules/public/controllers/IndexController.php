<?php
class IndexController extends vkNgine_Public_Controller
{
	public function init()
	{
		parent::init();
	}
	
    public function indexAction()
    {
    	$modelWorkouts = new Model_Workouts();
    	$modelDailyDetails = new Public_Model_Daily_Details();
    	$modelDailyExercises = new Public_Model_Daily_Exercises();
    	$modelMeasurements = new Public_Model_Measurements();
    	
    	$statistics = array();
    	for($i=1; $i<=4; $i++){
    		$statistics['workouts'] = count($modelWorkouts->fetchAll('userId = ' . $this->user->getId()));
    		$statistics['dailydetails'] = count($modelDailyDetails->fetchAll('userId = ' . $this->user->getId()));
    		$statistics['dailyexercises'] = count($modelDailyExercises->fetchAll('userId = ' . $this->user->getId()));
       		$statistics['measurements'] = count($modelMeasurements->fetchAll('userId = ' . $this->user->getId()));
    	}
    	
    	$today = date('Y-m-d');
    	
    	$milesRan = $modelDailyExercises->fetchAll("type = 'Running' and date = '" . $today . "' and userId =  " . $this->user->getId())->toArray();
    	
    	$totalMiles = null;
    	foreach($milesRan as $data) {
    		if($data['miles']) {
    			$totalMiles += $data['miles'];
    		}
    	}
    	
    	$statistics['milesRan'] = $totalMiles;
    	
    	$dailyIntake = new Public_Model_Daily_Intake;
    	$dataDailyIntake = $dailyIntake->fetchMacros($today, $this->user);
    	
    	if($dataDailyIntake) {
    		$statistics['caloriesConsumed'] = $dataDailyIntake[$today]['totalCalories'];
    	}
    	
    	$this->view->statistics = $statistics;
    }
    
    public function refreshDashboardAction()
    {
    	$mode = $this->_getParam('mode');
    	
    	$today = date('Y-m-d');
    	
    	switch($mode) {
    		case 'today':
    			$date = $today;
    			break;
    		case 'yesterday':
    			$date = date('Y-m-d', strtotime($today. '-1 day'));
    			break;
    		case 'tomorrow':
    			$date = date('Y-m-d', strtotime($today. '+1 day'));
    			break;
    		case 'last7days':
    			$date1 = date('Y-m-d', strtotime($today. '-7 days'));
    			$date2 = $today;
    			break;
    		case 'last30days':
    			$date1 = date('Y-m-d', strtotime($today. '-30 days'));
    			$date2 = $today;
    			break;
    		case 'thismonth':
    			$date = null;
    			break;
    		case 'lastmonth':
    			$date = null;
    			break;
    	}
    	
    	$modelDailyExercises = new Public_Model_Daily_Exercises();
    	$dailyIntake = new Public_Model_Daily_Intake;
    	
    	if(isset($date1) && isset($date2)) {
    		$milesRan = $modelDailyExercises->fetchAll("type = 'Running' and date between '" . $date1 . "' and '" . $date2 . "' and userId =  " . $this->user->getId())->toArray();
    		$daysWithGym = $modelDailyExercises->fetchDaysWithOrWoutGym($date1, $date2, $this->user);
    	}
    	else {
    		$dataDailyIntake = $dailyIntake->fetchMacros($date, $this->user);
    		$milesRan = $modelDailyExercises->fetchAll("type = 'Running' and date = '" . $date . "' and userId =  " . $this->user->getId())->toArray();
    		
    		if(isset($dataDailyIntake[$date]['totalCalories'])) {
	    		$statistics['caloriesConsumed'] = $dataDailyIntake[$date]['totalCalories'];
    		}
    	}
    		 
    	$totalMiles = null;
    	foreach($milesRan as $data) {
    		if($data['miles']) {
    			$totalMiles += $data['miles'];
    		}
    	}
    	  
    	$statistics['milesRan'] = $totalMiles;    	
    	
    	$this->view->statistics = $statistics;

    	$this->_helper->layout->disableLayout();
    }
    
    public function aboutAction()
    {
    	
    }
    
    public function exercisesAction()
    {  
    }
    
    public function setDayAction()
    {
    	$id = $this->_getParam('id');
    		
    	$modelWorkouts = new Model_Workouts();
    	$day = $modelWorkouts->fetch($id);
    		
    	$form = self::getAddSelectedExercisesForm();
    	$form->setDay($day['day']);
    		
    	echo $form->day->render();
    	
    	exit;
    }
    
    public function searchAction()
    {
    	$form = new Public_Model_Form_Search();
    	 
    	$request = $this->getRequest();
    	$this->view->error = false;
    	
    	if ($request->isGet()) {
    		$info = $form->getValues();

    		$q = $this->_getParam('query');
    		if($q) {
    			$modelExercise = new Model_Exercises();
    			$exercises = $modelExercise->search($q);

    			$this->view->q = $q;
    			$this->view->results = $exercises;
    		}
    	}
    }
    
    public function viewAction()
    {
    	$ajax = $this->_getParam('ajax', false);
    	
   		if($ajax){
    		parent::ajaxEnabled();
    	}
    	
    	$url = $this->_getParam('url');
    	    	
    	$modelExercises = new Model_Exercises();
    	$modelExercisesAssets = new Model_Exercises_Assets();
    	
    	$exercise = $modelExercises->fetchByUrl($url);
    	$exerciseAssets = $modelExercisesAssets->fetchAll("exerciseId = '" . $exercise->getId() . "' and type = 'PICTURE'")->toArray();
    	
    	$this->view->ajax = $ajax;
    	$this->view->param = $this->_getAllParams();
    	$this->view->exercise = $exercise;
    	$this->view->exerciseAssets = $exerciseAssets;	
    }
    
    public function addSelectedExercisesAction()
    {
    	parent::ajaxEnabled(true);
    	
    	$exerciseIds = $this->_getParam('exerciseIds');
    	
    	$modelWorkouts = new Model_Workouts();
    	$modelWorkoutsExercises = new Model_Workouts_Exercises();
    	
    	$form = self::getAddSelectedExercisesForm();
    	
    	$request = $this->getRequest();
    	 
    	if ($request->isPost()) {
    		$post = $request->getPost();
    	
    		if($form->isValid($post)) {
    			$values = $form->getValues();
    			
    			$exerciseIdsArray = explode(',', $exerciseIds);
    			
    			unset($values['exerciseIds']);
    			
    			foreach($exerciseIdsArray as $exerciseId) {
					$values['exerciseId'] = $exerciseId;
    				
    				$modelWorkoutsExercises->insert($values);
       			}
    			
    			echo Zend_Json::encode(array('success' => 1));
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
    	
    	$form->setWorkouts($modelWorkouts->fetchAll('userId = ' . $this->user->getId())->toArray());
    	$form->setHidden($exerciseIds);
    	
    	$this->view->form = $form;
    }
    
    private function getAddSelectedExercisesForm()
    {
    	$form = new Public_Model_Form_Add_Selected_Exercises(array(
    			'method' => 'post',
    			'action' => $this->_helper->url('add-selected-exercises', 'index'),
    	));
    
    	return $form;
    }
}