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
class Admin_Model_Form_Users_Edit extends vkNgine_Form_AjaxDesign
{	
    public function init()
    {
    	parent::init('adminFormUsersEdit');
    	
    	$userId = new vkNgine_Form_Element_Hidden('userId');
		$email = new vkNgine_Form_Element_Email('email', 
						array('label' 	=> Zend_Registry::get('t')->_('Email'),
							  'class' 	=> 'field text medium',
							  'validate'=> 'notuser'), 	
				   		true);
    	$firstName = new vkNgine_Form_Element_Text('firstName', 
						array('label' => Zend_Registry::get('t')->_('First Name'),
							  'class' => 'field text medium'), 	
				   		true);
		$lastName = new vkNgine_Form_Element_Text('lastName', 
						array('label' => Zend_Registry::get('t')->_('Last Name'),
							  'class' => 'field text medium'), 	
				   		true);
		$password = new vkNgine_Form_Element_Password('password', 
						array('label' => Zend_Registry::get('t')->_('Password'),
							  'class' => 'field text medium'), 	
				   		true);	
		$level = new vkNgine_Form_Element_Select('level', 
						array('label' => Zend_Registry::get('t')->_('Level'),
							  'class' => 'field text medium',
							  'desc'  => null), 	
						array(''      => Zend_Registry::get('t')->_('Select One'),
							  'STANDARD' => Zend_Registry::get('t')->_('Standard'),
							  'ADMIN'    => Zend_Registry::get('t')->_('Admin')),
				   		true);   		
    	
		$this->addElements(array(
			$userId, $email, $firstName, $lastName, $password, $level,	
		));

		$this->addDisplayGroup(array(
        	'email', 'firstName', 'lastName', 'password', 'level',
        ), 'general', array('legend' => Zend_Registry::get('t')->_('General Information')));
        
        $general = $this->getDisplayGroup('general');
        $general->setDecorators(array(
	  		'FormElements',
          	'Fieldset',
            array('HtmlTag',array('tag'=>'div','style' => 'float:left;width:400px;'))
        ));
        
        $companyName = new vkNgine_Form_Element_Text('companyName', 
						array('label' => Zend_Registry::get('t')->_('Company Name'),
							  'class' => 'field text medium'), 	
				   		false);
				   		
		$mailingAddress = new vkNgine_Form_Element_Text('mailingAddress', 
						array('label' => Zend_Registry::get('t')->_('Mailing Address'),
							  'class' => 'field text medium'), 	
				   		false);
				   				   		
		$phone = new vkNgine_Form_Element_Text('phone', 
						array('label' => Zend_Registry::get('t')->_('Phone'),
							  'class' => 'field text medium'), 	
				   		false);

		$city = new vkNgine_Form_Element_Text('city', 
						array('label' => Zend_Registry::get('t')->_('City'),
							  'class' => 'field text medium'), 	
				   		false);
				   				   		
		$state = new vkNgine_Form_Element_Select('state', 
						array('label' => Zend_Registry::get('t')->_('State'),
							  'desc'  => null,
							  'class' => 'field text medium'), 	
						array(),
				   		false);
		
		$zip = new vkNgine_Form_Element_Text('zip', 
						array('label' => Zend_Registry::get('t')->_('Zip'),
							  'class' => 'field text medium'), 	
				   		false);
				   						   		
		$this->addElements(array(
			$companyName, $mailingAddress, $phone, $city, $state, $zip,
		));

		$this->addDisplayGroup(array(
        	'companyName', 'mailingAddress', 'phone', 'city', 'state', 'zip'
        ), 'additional_information', array('legend' => Zend_Registry::get('t')->_('Additional Information')));
        
        $additional_information = $this->getDisplayGroup('additional_information');
        $additional_information->setDecorators(array(
	  		'FormElements',
          	'Fieldset',
            array('HtmlTag',array('tag'=>'div','style' => 'float:left;width:400px;'))
        ));
    }
    
	public function adminMode($email)
    {
     	$this->getElement('password')->setRequired(false);
     	$this->getElement('password')->setDescription(Zend_Registry::get('t')->_('Only fill in if you would like to change the password of the user'));
    
     	$this->getElement('email')->removeValidator('vkNgine_Validate_NotUser');
     	$this->getElement('email')->addValidator(new vkNgine_Validate_NotUser($email), false);
     	$this->getElement('email')->setDescription(Zend_Registry::get('t')->_('If you change the email of the user, and he is currently logged in, he will be logged out'));
    }
    
	public function setStates()
    {
     	$element = $this->getElement('state');
		$element->addMultiOption(null, Zend_Registry::get('t')->_('Select One'));

	    foreach(vkNgine_States::getStates() as $abbr => $name) {
	    	$element->addMultiOption($abbr, $name);
	    }
    }		
    
	public function setHidden($value)
    {
     $this->getElement('userId')->setValue($value);
    }
}