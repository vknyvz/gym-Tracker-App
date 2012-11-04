<?php
class vkNgine_Calendar
{
	/**
	 * Builds calendar
	 * 
	 * @param array $options
	 */
	public static function buildWeekly(array $options = array())
    {
    	if (!isset($options['year'])) { 
    		$options['year'] = date('Y');
    	}
    	else {
    		$options['year'] = $options['year'];
    	}
    	
    	if (!isset($options['month'])) {
    		$options['month'] = date('m');
    	}
    	else {
    		$options['month'] = $options['month'];
    	}
    	
    	if (!isset($options['day'])) {
    		$options['day'] = date('d');
    	}
    	else {
    		$options['day'] = $options['day'];
    	}
    	
    	$week = new Calendar_Week($options['year'], $options['month'], $options['day']);
    	
    	return $week;
    }
	
	/**
	 * Builds monhtly calendar
	 * 
	 * @param array $options
	 */
	public static function buildMonthly(array $options = array())
	{
		if (!isset($options['year'])) { 
    		$options['year'] = date('Y');
    	}
    	else {
    		$options['year'] = $options['year'];
    	}
    	
    	if (!isset($options['month'])) {
    		$options['month'] = date('m');
    	}
    	else {
    		$options['month'] = $options['month'];
    	}
    	
    	if (!isset($options['day'])) {
    		$options['day'] = date('d');
    	}
    	else {
    		$options['day'] = $options['day'];
    	}
		
		$monthWeekdays = new Calendar_Month_Weekdays($options['year'], $options['month']);
		
		$selectedDays = array (
				new Calendar_Day($options['year'], $options['month'], $options['day']),
		);
		 
		$monthWeekdays->build($selectedDays);
		
		return $monthWeekdays;
	}
}