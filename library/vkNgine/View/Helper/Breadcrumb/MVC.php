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
class vkNgine_View_Helper_Breadcrumb_MVC extends vkNgine_View_Helper_Breadcrumb implements vkNgine_View_Helper_Breadcrumb_Interface
{
    protected function getTitle($string)
    {
        $string = str_replace('-' , ' ' , $string);
        $string = ucfirst($string);     

        return Zend_Registry::get('t')->_($string);
    }
        
    protected function inAdminModule()
    {
    	$data = array();                

    	if($this->_action == 'index' && $this->_controller == 'index') {
        	$this->_data = $data;
            return;
		}
		
        if($this->_action == 'index') {
        	$data[self::CONTROLLER]['title'] =  $this->_controller == 'index'? 'home' : $this->getTitle($this->_controller);
			$this->_data = $data;
        }
        else {
            $data[self::CONTROLLER]['url'] = $this->_baseUrl . $this->_controller;                        
            $data[self::CONTROLLER]['title'] = $this->getTitle($this->_controller);
            $data[self::ACTION]['title'] = $this->_action == 'index'? 'home' : $this->getTitle(Zend_Registry::get('t')->_($this->_action));
            $this->_data = $data;
        }
    }        
    
    protected function inCustomModule()
    {
    	$data = array();
        $data[self::MODULE]['url'] = $this->_baseUrl . '/' . $this->_action;                
        $data[self::MODULE]['title'] =  $this->getTitle($this->_module);
                        
        if($this->_controller == 'index') {
        	unset($data[self::MODULE]['url']);
            $data[self::CONTROLLER]['url'] = $this->_baseUrl . $this->_module . '/'.  $this->_controller;
            $data[self::CONTROLLER]['title'] =  $this->getTitle($this->_controller);
                
            if($this->_action == 'index') {
            	unset($data[self::CONTROLLER]['url']);                        
            }
            else {
            	$data[self::ACTION]['title']   = $this->getTitle($this->_action);
            }
        }
             
      	$this->_data = $data;
    }
        
    public function prepare()
    {
    	if($this->_module == 'admin') {
        	$this->inAdminModule();
        }
     	else {
        	$this->inCustomModule();       
        }
    }
}