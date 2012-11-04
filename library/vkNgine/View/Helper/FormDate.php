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
class vkNgine_View_Helper_FormDate extends Zend_View_Helper_FormElement
{
	static $LABELS = array(
		'month'	=> '- Month -',
		'day'	=> '- Day -',
		'year'	=> '- Year -',
	);
	
	public function formDate($name, $value = null, $attribs = null, $options = null, $listsep = "<br />\n")
	{
		$info = $this->_getInfo($name, $value, $attribs, $options, $listsep);
		extract($info); // name, id, value, attribs, options, listsep, disable
		
		// fix value to array (month,day,year)
		if (is_string($value))
		{
			$_value = array();
			
			if (preg_match('/(\d{4})\-(\d{2})\-(\d{2})/', $value, $match))
			{
				$_value['y'] = (int)$match[1];
				$_value['m'] = (int)$match[2];
				$_value['d'] = (int)$match[3];
			}
			else
			{
				$time = strtotime($value);
				$_value['m'] = (int)date('n', $time);
				$_value['d'] = (int)date('j', $time);
				$_value['y'] = (int)date('Y', $time);
			}
			
			$value = $_value;
		}
		$value = is_array($value) ? $value : array('m' => 0, 'd' => 0, 'y' => 0);
		
		// options
		if (empty($attribs['yearEnd']))
		{
			$attribs['yearEnd'] = (int) date('Y') + 10;
		}
		if (empty($attribs['yearStart']))
		{
			$attribs['yearStart'] = $attribs['yearEnd'] - 100;
		}
				
		// Build the surrounding select element first.
		$_select = sprintf(
						'<select name="%s[]" id="%s"',
						$this->view->escape($name),
						$this->view->escape($id)
					)
					. ((bool)$disable ? ' disabled="disabled"' : '')
					. $this->_htmlAttribs($attribs)
					. ">\n";
		
		$_attribs = $this->_htmlAttribs($attribs);
		if ($disable)
		{
			$_attribs.= ' disabled="disabled"';
		}

		// build the list of options

		$month = array();
		$month[] = $this->_build(null, self::$LABELS['month']);
		
		for ($i = 1; $i<= 12; $i++)
		{
			$m = date('F', mktime(0, 0, 0, $i));
			$month[] = $this->_build($i, $m, ((int)$i == $value['m']));
		}
		
		$day = array();
		$day[] = $this->_build(null, self::$LABELS['day']);
		for ($i = 1; $i<=31; $i++)
		{
			$day[] = $this->_build($i, $i, ((int)$i == $value['d']));
		}
		
		$year = array();
		$year[] = $this->_build(null, self::$LABELS['year']);
		for ($i = $attribs['yearEnd']; $i > $attribs['yearStart']; $i--)
		{
			$year[] = $this->_build($i, $i, ((int)$i == $value['y']));
		}
		
		// add the options to the xhtml and close the select
		$month	= $this->_select($name, 'm', $id, $_attribs) . implode("\n\t", $month) . "\n</select>";
		$day	= $this->_select($name, 'd', $id, $_attribs) . implode("\n\t", $day)	. "\n</select>";
		$year	= $this->_select($name, 'y', $id, $_attribs) . implode("\n\t", $year)	. "\n</select>";;
		
		return $month . $day . $year;
		
	}
	
	protected function _select($name, $part, $id, $attribs)
	{
		$name	= $this->view->escape($name);
		$part	= $this->view->escape($part);
		$id		= $this->view->escape($id);
		
		return sprintf('<select name="%s[%s]" id="%s" %s>',
					$name, $part, $id . '_' . $part, $attribs) . "\n";
	}
	
	protected function _build($value, $label, $selected = false)
	{
		return sprintf('<option value="%s" label="%s" %s>%s</option>',
			$this->view->escape($value),
			$this->view->escape($label),
			((bool) $selected ? 'selected="selected"' : null),
			$this->view->escape($label));
	}
	
}
