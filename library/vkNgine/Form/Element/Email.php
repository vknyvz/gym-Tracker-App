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
class vkNgine_Form_Element_Email extends vkNgine_Form_Element_Text
{	
	public function __construct($spec, $options, $required)
    {
    	parent::__construct($spec, $options, $required);
    	
    	$emailMessages = array(
			Zend_Validate_EmailAddress::INVALID => Zend_Registry::get('t')->_('Invalid e-mail address given'),
			Zend_Validate_EmailAddress::INVALID_FORMAT => Zend_Registry::get('t')->_('Invalid e-mail address given'),
			Zend_Validate_EmailAddress::INVALID_HOSTNAME => Zend_Registry::get('t')->_('Invalid e-mail address given'),
			Zend_Validate_EmailAddress::INVALID_MX_RECORD => Zend_Registry::get('t')->_('Invalid e-mail address given'),
			Zend_Validate_EmailAddress::DOT_ATOM => Zend_Registry::get('t')->_('Invalid e-mail address given'),
			Zend_Validate_EmailAddress::QUOTED_STRING => Zend_Registry::get('t')->_('Invalid e-mail address given'),
			Zend_Validate_EmailAddress::INVALID_LOCAL_PART => Zend_Registry::get('t')->_('Invalid e-mail address given'),
			Zend_Validate_EmailAddress::LENGTH_EXCEEDED => Zend_Registry::get('t')->_('Invalid e-mail address given'),
		);
    	
		$this->addValidator('StringLength', false, array(5, 25))
			 ->addValidator('NotEmpty', false, array('messages' => Zend_Registry::get('t')->_('Invalid e-mail address given')))
			 ->addValidator('EmailAddress', null, array('messages' => $emailMessages));			 
			 
		if(isset($options['validate'])){
			if($options['validate'] == 'user'){
				$this->addValidator(new vkNgine_Validate_User());
			}	
			elseif($options['validate'] == 'notuser'){
				$this->addValidator(new vkNgine_Validate_NotUser());
			} 
		}
		
		if(isset($options['removeDecorators'])){
			$this->removeDecorator('HtmlTag')
				 ->removeDecorator('Label');
		}
    }
}