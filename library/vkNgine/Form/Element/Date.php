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
class vkNgine_Form_Element_Date extends Zend_Form_Element_Xhtml
{
	public $helper = 'formDate';
	
    public function __construct($spec, $options = null)
    {
    	parent::__construct($spec, $options);
    }
	
	public function setValueToToday()
	{
		return $this->setValue(date('Y-n-j'));
	}
	
	static function getDatestring($value, $format = 'yyyy-mm-dd')
	{		
		if (is_array($value)){
			$search = array('yyyy', 'yy', 'mm', 'dd');
			$replace = array(
				@$value['y'] ? $value['y'] : '0000', // yyyy
				@$value['y'] ? $value['y'] : '0000', // yy
				@$value['m'] ? sprintf('%02d', $value['m']) : '00', // mm
				@$value['d'] ? sprintf('%02d', $value['d']) : '00', // dd
			);
			
			$value = str_replace($search, $replace, $format);
		}
		
		return is_string($value) ? $value : '';
	}
}

?>