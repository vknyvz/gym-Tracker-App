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
class vkNgine_Email
{		
	/**
	 * sends a standard email
	 * 
	 * @param string $subject
	 * @param string $toName
	 * @param array $toEmails
	 * @param array $emailOptions
	 * @param string $fromName
	 * @param string $fromEmail
	 */
	public function send($subject, $toName, $toEmails = array(), $emailOptions = array(), $fromName = null, $fromEmail = null)
	{	
    	$logger = Zend_Registry::get('logger');
    	$config = vkNgine_Config::getSystemConfig()->mail;
    	
	 	if ($config->serverType == 'smtp') {
			$tr = new Zend_Mail_Transport_Smtp($config->server, $config->toArray());
	 	} 
	 	
		Zend_Mail::setDefaultTransport($tr);
		
		foreach ($toEmails as $email) {
			$mail = new Zend_Mail();
			
			if($emailOptions['type'] == 'html') {
				$mail->setBodyHtml($emailOptions['email']);
			}
			else {
				$mail->setBodyText($emailOptions['email']);
			}
			
			if(!$fromName || !$fromEmail) {
				$mail->setFrom($config->noreply, 'vkNgine3 Emailer');
			}
			else {
				$mail->setFrom($fromEmail, $fromName);
			}
			
			$mail->addTo($email, $toName);
			$mail->setSubject($subject);
				
			try {
				$mail->send();
			}
			catch (Zend_Mail_Protocol_Exception $e) {
    			$logger->log('MESSAGE_SEND_FAILED', 'Unable to send to ' . $email . ' - ' . $e->getMessage(), 1);
			}
		}
	}
	
	/**
	 *
	 * send email with a template
	 *
	 * @param string $type
	 * @param array $params
	 * @param string $toName
	 * @param array $toEmails
	 */
	public function sendWithTemplate($type, $params, $toName, $toEmails)
	{
		$view = new Zend_View();
		$view->setBasePath(APPLICATION_PATH . '/modules/public/views/');

		foreach($params as $key => $value) {
			$view->$key = $value;
		}
		
		if ($type == 'FORGOT_ADD_EXERCISE') {
			$htmlMessage = $view->render('emails/forgotAddExercise.phtml');
		}
		
		$emailOptions = array('type' => 'html', 'email' => $htmlMessage);
			
		$this->send($params['subject'], $toName, $toEmails, $emailOptions);
	}
}