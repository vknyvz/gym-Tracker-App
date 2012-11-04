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
abstract class vkNgine_Form_Abstract extends Zend_Form
{
	const SELECT_DEFAULT_LABEL = '%s';
	const SELECT_DEFAULT_VALUE = 'NONE';

	/**
	 * Enter description here ...
	 * 
	 * @param Zend_Form_Element $field
	 * @param unknown_type $label
	 */
	public function setSelectDefaultOption(Zend_Form_Element $field, $label = null)
	{
		return $field->addMultiOption(
		self::SELECT_DEFAULT_VALUE,
		sprintf(self::SELECT_DEFAULT_LABEL, $label ? $label : $field->getLabel())
		);
	}	
	
	/**
	 * Enter description here ...
	 * 
	 * @param string $value
	 * @param string $format
	 * @return Ambigous <string, mixed>
	 */
	public function getDateValue($value, $format = 'yyyy-mm-dd')
	{
		return vkNgine_Form_Element_Date::getDatestring($value, $format);
	}

	/**
	 * Enter description here ...
	 * 
	 * @param array|object $data
	 * @param string $name
	 * @param int $max
	 * @param array $checkboxes
	 * @return NULL|Ambigous <multitype:, boolean, mixed>
	 */
	public function getArrayFormItems($data, $name, $max, $checkboxes = array())
	{
		if (is_object($data) && method_exists($data, 'toArray'))
		{
			$data = $data->toArray();
		}
		if (!is_array($data))
		{
			return null;
		}
		 
		reset($data);
		$return = array();
		for ($i = 1; $i <= $max; $i++, next($data))
		{
			$item = current($data);
			if (false !== $item)
			{
				foreach ($checkboxes as $ch)
				{
					if (isset($item[$ch]))
					{
						$item[$ch] = (bool)($item[$ch] == 'Y');
					}
				}
				$return[$name . $i] = $item;
			}
		}
		
		return $return;
	}

	/**
	 * Enter description here ...
	 * 
	 * @param array $data
	 * @param string $name
	 * @param int $max
	 * @param unknown_type $requiredField
	 * @return Ambigous <multitype:, unknown>
	 */
	public function getFormItemsArray($data, $name, $max, $requiredField)
	{
		$items = array();
		for ($i = 1; $i < $max; $i++)
		{
			if (!empty($data[$name . $i]) && !empty($data[$name . $i][$requiredField]))
			{
				$items[$i] = $data[$name . $i];
			}
		}
		
		return $items;
	}
	
	/**
	 * on form element handle turkish characters
	 * 
	 * @param string $text
	 * @return string
	 */
	public function convertText2Turkish($text)
	{
		return html_entity_decode($text, ENT_COMPAT, 'UTF-8');
	}
	
	/**
	 * Enter description here ...
	 * 
	 * @return array elements' errors decorator
	 */	
	public function returnErrors()
	{
		$errors = array();
		foreach($this->getElements() as $element) {
			if ($element->hasErrors()) {
				$errors[$element->getId()] = $element->getDecorator('Errors')->setElement($element)->render('');
			}
		}
		
		return $errors;
	}
	
	/**
	 * get all errors on the form
	 * 
	  * @return array
	 */
	public function errors()
	{
		$errors = array();

		foreach($this->getMessages() as $elementKey => $message) {
				
			$element = $this->getElement($elementKey);
			$element->removeDecorator('Errors');
			
			if (is_array($message)) {
				foreach ($message as $errorKey => $errorMessage) {
					if (empty($errors[$elementKey])) {
						$errors[$elementKey] = array('message' => $errorMessage);
					}
				}
			}

		}
		
		return $errors;
	}
}