<?php
class CalorieCalendarController extends vkNgine_Public_Controller
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
				
		$this->view->calendar = $calendar;
	}
}