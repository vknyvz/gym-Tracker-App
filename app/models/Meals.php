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
class Model_Meals extends vkNgine_DbTable_Abstract
{
    protected $_name = 'meals';
	protected $_primary	= 'mealId';
	
	protected $_saveInsertDate	= true;
	protected $_saveUpdateDate	= true;
	
	/**
	 * fetch a meal
	 *
	 * @param int $mealId
	 */
	public function fetch($mealId)
	{
		$select = $this->select();
		$select->where('mealId = ?', $mealId);
	
		return $this->fetchRow($select);
	}
	
	/**
	 * update a meal
	 *
	 * @param int $mealId
	 * @param array $data
	 */
	public function update($mealId, $data)
	{
		$where = $this->getAdapter()->quoteInto('mealId = ?', (int) $mealId);
		parent::update($data, $where);
	}
	
	/**
	 * fetch meal totals 
	 * 
	 * @param int $mealId 
	 * 
	 */
	public function fetchMealTotal($mealId)
	{
		$sql = "
			SELECT *
				FROM `" . $this->_name . "` m 
					 LEFT JOIN meals_foods ON m.mealId = meals_foods.mealId
					 LEFT JOIN foods ON meals_foods.foodId = foods.foodId
						WHERE m.mealId = " . (int) $mealId . " 
		";
		
		$query = $this->_db->fetchAll($sql);
		
		if(0 < count($query)) {
			$totalValues = array();
			foreach($query as $data) {
				$totalValues['calories'][] = $data['calories'];
				$totalValues['fat'][] = $data['fat'];
				$totalValues['cholesterol'][] = $data['cholesterol'];
				$totalValues['sodium'][] = $data['sodium'];
				$totalValues['carbs'][] = $data['carbs'];
				$totalValues['fiber'][] = $data['fiber'];
				$totalValues['protein'][] = $data['protein'];
				$totalValues['sugar'][] = $data['sugar'];
			}
			
			return array(
				'title'		  => $query[0]['title'],
				'calories'    => array_sum($totalValues['calories']),
				'fat' 		  => array_sum($totalValues['fat']),
				'cholesterol' => array_sum($totalValues['cholesterol']),
				'sodium'      => array_sum($totalValues['sodium']),
				'carbs' 	  => array_sum($totalValues['carbs']),
				'fiber' 	  => array_sum($totalValues['fiber']),
				'protein'     => array_sum($totalValues['protein']),
				'sugar'       => array_sum($totalValues['sugar']),
			);
		}
		
		return false;
	}
	
	/**
	 * fetch all meals with pagination support
	 *
	 * @param int $page
	 * @param string $orderBy
	 * @param string $orderBySort
	 * @param array $searchParams
	 * @return Zend_Paginator
	 */
	public function fetchAllWithPagination($page, $orderBy = 'title', $orderBySort = 'ASC')
	{
		$select = $this->select();
		$select->order($orderBy . ' ' . $orderBySort);
	
		$paginator = Zend_Paginator::factory($select);
	
		if ($page != 'ALL') {
			$paginator->setItemCountPerPage(vkNgine_Config::getSystemConfig()->pagination->perPage)->setCurrentPageNumber($page);
		} else {
			$paginator->setItemCountPerPage(9999);
		}
	
		return $paginator;
	}
}