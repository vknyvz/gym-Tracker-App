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
class Public_Model_Daily_Intake extends vkNgine_DbTable_Abstract
{
    protected $_name = 'daily_intake';
	protected $_primary	= 'id';
	
	protected $_saveInsertDate	= true;
	
	public function fetchByDate($date, Model_User $user) 
	{
		$sql = "	
			SELECT *
				FROM `" . $this->_name . "` di, `foods` f 
					WHERE di.date = '" . $date . "' AND di.userId = '" . $user->getId() . "' and f.foodId = di.foodId
		";
		
		return $this->_db->query($sql);
	}
	
	public function fetchDailyTotalFoodIntake($date, Model_User $user) 
	{
		$sql = "
			SELECT *, di.servingSize as dailyServingSize
				FROM `" . $this->_name . "` di, `foods` f
					WHERE di.date = '" . $date . "' AND di.userId = '" . $user->getId() . "' and f.foodId = di.foodId
		";
		
		$query = $this->_db->fetchAll($sql);
		
		if(0 < count($query)) { 
			$dailyValues = array();
			foreach($query as $data) {
				$dailyValues['calories'][] = $data['calories'] * $data['dailyServingSize'] ;
				$dailyValues['fat'][] = $data['fat'] * $data['dailyServingSize'];
				$dailyValues['cholesterol'][] = $data['cholesterol'] * $data['dailyServingSize'];
				$dailyValues['sodium'][] = $data['sodium'] * $data['dailyServingSize'];
				$dailyValues['carbs'][] = $data['carbs'] * $data['dailyServingSize'];
				$dailyValues['fiber'][] = $data['fiber'] * $data['dailyServingSize'];
				$dailyValues['protein'][] = $data['protein'] * $data['dailyServingSize'];
				$dailyValues['sugar'][] = $data['sugar'] * $data['dailyServingSize'];
			}
			
			$foodTotals = array(
				'calories'    => array_sum($dailyValues['calories']),
				'fat' 		  => array_sum($dailyValues['fat']),
				'cholesterol' => array_sum($dailyValues['cholesterol']),
				'sodium'      => array_sum($dailyValues['sodium']),
				'carbs' 	  => array_sum($dailyValues['carbs']),
				'fiber' 	  => array_sum($dailyValues['fiber']),
				'protein'     => array_sum($dailyValues['protein']),
				'sugar'       => array_sum($dailyValues['sugar']),
			);
		}
		
		$sql = "
			SELECT *, mf.servingSize as servingSizeMealFood
				FROM `" . $this->_name . "` di, `meals_foods` mf, `foods` f
					WHERE di.date = '" . $date . "' AND di.userId = '" . $user->getId() . "' and di.mealId = mf.mealId and mf.foodId = f.foodId
		";
		
		$query = $this->_db->fetchAll($sql);
		
		if(0 < count($query)) {
			$dailyMealValues = array();
			foreach($query as $data){
				$dailyMealValues['calories'][] = $data['calories'] * $data['servingSizeMealFood'];
				$dailyMealValues['fat'][] = $data['fat'] * $data['servingSizeMealFood'];
				$dailyMealValues['cholesterol'][] = $data['cholesterol'] * $data['servingSizeMealFood'];
				$dailyMealValues['sodium'][] = $data['sodium'] * $data['servingSizeMealFood'];
				$dailyMealValues['carbs'][] = $data['carbs'] * $data['servingSizeMealFood'];
				$dailyMealValues['fiber'][] = $data['fiber'] * $data['servingSizeMealFood'];
				$dailyMealValues['protein'][] = $data['protein'] * $data['servingSizeMealFood'];
				$dailyMealValues['sugar'][] = $data['sugar'] * $data['servingSizeMealFood'];
			}
			
			$mealTotals = array(
				'calories'    => array_sum($dailyMealValues['calories']),
				'fat' 		  => array_sum($dailyMealValues['fat']),
				'cholesterol' => array_sum($dailyMealValues['cholesterol']),
				'sodium'      => array_sum($dailyMealValues['sodium']),
				'carbs' 	  => array_sum($dailyMealValues['carbs']),
				'fiber' 	  => array_sum($dailyMealValues['fiber']),
				'protein'     => array_sum($dailyMealValues['protein']),
				'sugar'       => array_sum($dailyMealValues['sugar']),
			);
		}
		
		if(isset($foodTotals) || isset($mealTotals)){
			return array(   
				'calories'    => (isset($mealTotals['calories']) ? $mealTotals['calories'] : 0) + (isset($foodTotals['calories']) ? $foodTotals['calories'] : 0),
				'fat' 		  => (isset($mealTotals['fat']) ? $mealTotals['fat'] : 0) + (isset($foodTotals['fat']) ? $foodTotals['fat'] : 0),
				'cholesterol' => (isset($mealTotals['cholesterol']) ? $mealTotals['cholesterol'] : 0) + (isset($foodTotals['cholesterol']) ? $foodTotals['cholesterol'] : 0),
				'sodium'      => (isset($mealTotals['sodium']) ? $mealTotals['sodium'] : 0) + (isset($foodTotals['sodium']) ? $foodTotals['sodium'] : 0),
				'carbs' 	  => (isset($mealTotals['carbs']) ? $mealTotals['carbs'] : 0) + (isset($foodTotals['carbs']) ? $foodTotals['carbs'] : 0),
				'fiber' 	  => (isset($mealTotals['fiber']) ? $mealTotals['fiber'] : 0) + (isset($foodTotals['fiber']) ? $foodTotals['fiber'] : 0),
				'protein'     => (isset($mealTotals['protein']) ? $mealTotals['protein'] : 0) + (isset($foodTotals['protein']) ? $foodTotals['protein'] : 0),
				'sugar'       => (isset($mealTotals['sugar']) ? $mealTotals['sugar'] : 0) + (isset($foodTotals['sugar']) ? $foodTotals['sugar'] : 0),
			);
		}
		else {
			return false;
		}
	}
	
	public function fetchTotalMealValues($date, Model_User $user) 
	{
		$sql = "
			SELECT *
				FROM `" . $this->_name . "` di, `meals_foods` mf, `meals` m
					WHERE di.date = '" . $date . "' AND di.userId = '" . $user->getId() . "' and mf.mealId = di.mealId and mf.mealId = m.mealId
		";
		
		return $this->_db->fetchAll($sql);
	}
}
