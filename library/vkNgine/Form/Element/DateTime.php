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
class vkNgine_Form_Element_DateTime extends Zend_Form_Element_Select
{	
    public function __construct($spec = null, $options = null)
    {
		parent::__construct($spec, $options);
		
		if($options == 'everyFifteen') {			
			self::_buildTimeforEveryFifteen();			
		}
		
		return $this;
	}
	
	/**
	 * builds times with 15 minutes of incremental values
	 * 
	 * @return vkNgine_Form_Element_DateTime
	 */
	private function _buildTimeforEveryFifteen()
    {
		$this->addFilter('StringTrim')
			 ->addFilter('StripTags')
			 ->removeDecorator('HtmlTag')	
			 ->removeDecorator('Label');
		
		$startHr = 0; 
		$count = 97;
		
		$today = mktime($startHr, 0, 0, date('m'), date('d'), date('Y'));
		$hour = '';
		$hours = array();
		
		for ($i=1; $i<$count; $i++) {
			$ushour = date('h:i A', $today); 	
			$euhour = date('H:i', $today); 		
			$this->addMultiOption($euhour, $ushour);    	
			$today += 60 * 15;
		}
		
		return $this;					
	}
}
		