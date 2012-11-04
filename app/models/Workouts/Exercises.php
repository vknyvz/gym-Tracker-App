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
class Model_Workouts_Exercises extends vkNgine_DbTable_Abstract
{
    protected $_name = 'workouts_exercises';
	protected $_primary	= 'id';
	
	public function fetchAllPerDay($workoutId, $day)
	{
		$select = $this->select();
		$select->where('workoutId = ?', $workoutId);
		$select->where('day = ?', $day);
		$select->order('order');
		
		return $this->fetchAll($select);
	}
}