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
	
	/**
	 * calculate macros
	 * 
	 * @param string $where
	 * @return array
	 */
	public function fetchMacros($date, Model_User $user)
	{
		$select = $this->select();
		$select->where('date = ?', $date);
		$select->where('userId = ?', $user->getId());
		
		$data = $this->fetchAll($select)->toArray();
		
		$totalCalories = $mealTotalCalories = $foodTotalCalories = $calories = $protein = $fat = $carbs = $sodium = $sugar = $fiber = $cholesterol = 0;
		
		$macros[$date] = array();
		if(0 < count($data)) {
			foreach($data as $intake) {
				if($intake['mealId']){
					$modelMeals = new Model_Meals();
			
					$meal = $modelMeals->fetchMealTotal($intake['mealId']);
					
					$calories += $meal['macros']['calories'];
					$protein += $meal['macros']['protein'];
					$fat += $meal['macros']['fat'];
					$sodium += $meal['macros']['sodium'];
					$cholesterol += $meal['macros']['cholesterol'];
					$carbs += $meal['macros']['carbs'];
					$sugar += $meal['macros']['sugar'];
					$fiber += $meal['macros']['fiber'];
					
					$mealTotalCalories += $meal['mealTotalCalories'];
				}
				else {
					$modelFoods = new Model_Foods();
					$food = $modelFoods->fetch($intake['foodId'])->toArray();
					
					$calories += $modelFoods->calculateMacros($food['calories'], $food['servingSize'], $intake['servingSize'], '0');
					$protein += $modelFoods->calculateMacros($food['protein'], $food['servingSize'], $intake['servingSize'], '0');
					$fat += $modelFoods->calculateMacros($food['fat'], $food['servingSize'], $intake['servingSize'], '0');
					$sodium += $modelFoods->calculateMacros($food['sodium'], $food['servingSize'], $intake['servingSize'], '0');
					$cholesterol += $modelFoods->calculateMacros($food['cholesterol'], $food['servingSize'], $intake['servingSize'], '0');
					$carbs += $modelFoods->calculateMacros($food['carbs'], $food['servingSize'], $intake['servingSize'], '0');
					$sugar += $modelFoods->calculateMacros($food['sugar'], $food['servingSize'], $intake['servingSize'], '0');
					$fiber += $modelFoods->calculateMacros($food['fiber'], $food['servingSize'], $intake['servingSize'], '0');
				}
			}
		
			$values = array('calories'    => $calories, 
							'protein'     => $protein, 
							'fat' 		  => $fat, 
							'sodium'      => $sodium,
							'cholesterol' => $cholesterol,
							'carbs'       => $carbs,
							'sugar'       => $sugar,
							'fiber'       => $fiber
			);
			
			$macros[$date]['totalCalories'] = array_sum($values);
			$macros[$date]['foodTotalCalories'] = $macros[$date]['totalCalories'] - $mealTotalCalories;
			$macros[$date]['mealTotalCalories'] = $mealTotalCalories;
			$macros[$date]['macros'] = $values;
		}
		
		return $macros;
	}
}