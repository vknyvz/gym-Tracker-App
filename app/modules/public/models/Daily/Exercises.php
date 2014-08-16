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
class Public_Model_Daily_Exercises extends vkNgine_DbTable_Abstract
{
    protected $_name = 'daily_exercises';
	protected $_primary	= 'id';
	
	protected $_saveInsertDate	= true;
	
	public function fetchByDate($date, Model_User $user) 
	{
		$select = $this->select($date);
		$select->where('date = ?', $date);
		$select->where('userId = ?', $user->getId());
			
		return $this->fetchAll($select)->toArray();		
	}
	
	public function fetchDaysWithOrWoutGym($date1, $date2, Model_User $user)
	{
		$select = "SELECT count(*) as total, date from `" . $this->_name . "`
						WHERE userId = " . $user->getId() . " 
							AND	date between '" . $date1. "' and '" . $date2 . "'
								GROUP BY date";
		
		$data = $this->_db->query($select)->fetchAll();
				
		$datesInBetween = array($date1);
		while(end($datesInBetween) < $date2) {
			$datesInBetween[] = date('Y-m-d', strtotime(end($datesInBetween).' +1 day'));
		}	
		
		$final['datesInBetween'] = implode(', ', $datesInBetween);
			
		$final['daysWithGym'] = null;
		foreach($datesInBetween as $dates) {
			foreach($data as $date) {
				if(in_array($dates, $date)) {
					$final['daysWithGym'][] = $date['date'];
				}
			}
			
			if(is_array($final['daysWithGym'])) {
				if(!in_array($dates, $final['daysWithGym'])) {
					$final['daysWithoutGym'][] = $dates;
				}
			}
		}
		
		$final['countDaysWithGym'] = count($final['daysWithGym']);
		$final['countDaysWithoutGym'] = count($final['daysWithoutGym']);

		return $final;
	}
}
