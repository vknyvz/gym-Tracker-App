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
class vkNgine_Public_Controller extends Zend_Controller_Action
{	
	protected $user = null;
	
	public function init()
    {    	
    	parent::init();
    	
		$helper = new vkNgine_View_Helper_PublicUrl();    	
    	$this->view->registerHelper($helper, 'publicUrl');
    	
    	$helper = new vkNgine_View_Helper_Seo();
    	$this->view->registerHelper($helper, 'seo');
    	
    	$helper = new vkNgine_View_Helper_AssetUrl();
    	$this->view->registerHelper($helper, 'assetUrl');
    	
    	$helper = new vkNgine_View_Helper_Dateformat();
    	$this->view->registerHelper($helper, 'dateFormat');
    	 
    	$searchForm = new Public_Model_Form_Search();
    	$this->view->searchForm = $searchForm;
    	
    	$view = Zend_Registry::get('view');
    	$appTitle = Zend_Registry::get('t')->_('GYM Tracker');
    	$view->headTitle($appTitle, Zend_View_Helper_Placeholder_Container_Abstract::SET);
    	
    	if (!vkNgine_Auth::isAuthenticated()) {
    		header("location:/auth/login");
    		exit;
    	}
    	
    	$modelExercises = new Model_Exercises();
    	$this->view->exercises = $modelExercises;
    	
    	$user = vkNgine_Public_Auth::revalidate();
    	
    	$this->view->params = $this->getAllParams();
    	
    	Zend_Registry::set('user', $user);
    	$this->view->assign('user', $user);
    	
    	$this->user = Zend_Registry::get('user');
    	
    	$this->view->t = Zend_Registry::get('t');
		$this->t = Zend_Registry::get('t');
    }
    
    public function ajaxEnabled()
    {
   		$this->_helper->layout->disableLayout();
    }
}