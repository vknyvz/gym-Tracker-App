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
class vkNgine_View_Helper_Breadcrumb extends Zend_View_Helper_Abstract
{
	protected $_adapter = null;
	protected $_seperator = '';
	protected $_data = array();
	protected $_frontController = null;
	protected $_module = '';
	protected $_controller = '';
	protected $_action = '';
	protected $_baseUrl = '/';
	
	const MODULE = 0;
	const CONTROLLER = 1;
	const ACTION = 2;
	
	public function __construct()
	{
		$this->_frontController	= Zend_Controller_Front::getInstance();
		$this->_module		= $this->_frontController->getRequest()->getModuleName();
		$this->_action		= $this->_frontController->getRequest()->getActionName();
		$this->_controller	= $this->_frontController->getRequest()->getControllerName();
		$this->_baseUrl		= $this->_frontController->getBaseUrl() . '/admin';
	}

	public function breadcrumb($adapter='MVC', $replacement=null, $seperator='>')
	{
		if($this->_module == 'default' && $this->_controller == 'index' && $this->_action =='index') {
			return null;
		} elseif($this->_controller == 'error') {
			return null;
		}
		
		if(is_array($adapter)) {
			$this->setData($adapter);
			$this->setSeperator($seperator);
			return $this->render();
		}

		$adapterName = __CLASS__ . '_' . ucfirst($adapter);
		$this->_adapter = new $adapterName;

		if (!$this->_adapter instanceof vkNgine_View_Helper_Breadcrumb_Interface) {
			throw new Exception('Adapter name is invalid');
		}

		$this->_adapter->setSeperator($seperator);
		$this->_adapter->prepare();
		if(!is_null($replacement)) {
			$this->_adapter->replace($replacement);
		}
		return $this->_adapter->render();
	}

	protected function setSeperator($seperator)
	{
		$this->_seperator = $seperator;
		return $this;
	}

	protected function setData($data)
	{
		$this->_data = $data;
		return $this;
	}

	protected function replace(array $replacement)
	{
		foreach($replacement as $section => $data) {
			if(is_array($data)) {
				foreach($data as $key => $value) {
					$this->_data[$section][$key] = $value;
				}	
			} else {
				$this->_data[$section] = $data;
			}
		}
		return $this;
	}
	
	protected function render()
	{
		ksort($this->_data);

		$breadcrumb = '<div class="breadcrumb"><a href="' . $this->_baseUrl . '">' . Zend_Registry::get('t')->_('Home') .'</a> > ';
		
		foreach($this->_data as $key => $value) {
			$breadcrumb .= $this->renderItem($key);
		}

		$breadcrumb .= '</div>';
		return $breadcrumb;
	}

	private function renderItem($type)
	{
		$breadcrumb = '';
		if(isset($this->_data[$type])) {
			if(isset($this->_data[$type]['url'])) {
				$breadcrumb .= '<a href="javascript:void(0);" >' . $this->_data[$type]['title'] . '</a>';
				$breadcrumb .= ' > ';
				
			} elseif(isset($this->_data[$type]['title'])) {
				$breadcrumb .= '<span>' .  Zend_Registry::get('t')->_($this->_data[$type]['title']). '</span>';
			}
		}

		return $breadcrumb;
	}
}