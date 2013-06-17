<?php
class vkNgine_Auth_Controller extends Zend_Controller_Action
{
    public function init()
    {    	
        $view = Zend_Registry::get('view');
		
		$helper = new vkNgine_View_Helper_PublicUrl();    	
    	$this->view->registerHelper($helper, 'publicUrl');
    	
    	$this->view->t = Zend_Registry::get('t');
    	$this->t = Zend_Registry::get('t');
    	
    	parent::init();
    }
}