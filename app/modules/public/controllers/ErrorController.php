<?php
class ErrorController extends Zend_Controller_Action
{
	public function errorAction()
	{
		$errors = $this->_getParam('error_handler');
		
		$helper = new vkNgine_View_Helper_PublicUrl();
		$this->view->registerHelper($helper, 'publicUrl');
		
		$view = Zend_Registry::get('view');
		$appTitle = Zend_Registry::get('t')->_('GYM Tracker');
		$view->headTitle($appTitle, Zend_View_Helper_Placeholder_Container_Abstract::SET);
		
		$this->t = Zend_Registry::get('t');
		
		switch ($errors->type) {
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
				$this->getResponse()->setHttpResponseCode(404);
				$this->view->headTitle($this->t->_('404 Page not found'))->setSeparator(' - ');
				$this->view->message = 'Page not found';
				break;
			default:
				$this->getResponse()->setHttpResponseCode(500);
				$this->view->headTitle($this->t->_('500 Application Error'))->setSeparator(' - ');
				$this->view->message = 'Application Error';
				break;
		}
			
		$this->_helper->layout->setLayout('layout_error');

		$this->view->t = $this->t;
	    $this->view->exception = $errors->exception;
		$this->view->request = $errors->request;
	}
}