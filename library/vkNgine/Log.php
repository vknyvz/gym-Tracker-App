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
class vkNgine_Log extends Zend_Log
{  
	const EMERG   = 0;  // Emergency: system is unusable
	const ALERT   = 1;  // Alert: action must be taken immediately
	const CRIT    = 2;  // Critical: critical conditions
	const ERR     = 3;  // Error: error conditions
	const WARN    = 4;  // Warning: warning conditions
	const NOTICE  = 5;  // Notice: normal but significant condition
	const INFO    = 6;  // Informational: informational messages
	const DEBUG   = 7;  // Debug: debug messages

    /**
     * Log a message at a priority
     *
     * @param  string   $message   Message to log
     * @param  integer  $priority  Priority of message
     * @return void
     * @throws Zend_Log_Exception
     */
    public function log($message, $info, $priority, $userId = null)
    {
        // sanity checks
        if (empty($this->_writers)) {
            throw new Zend_Log_Exception('No writers were added');
        }

        if (! isset($this->_priorities[$priority])) {
            throw new Zend_Log_Exception('Bad log priority');
        }

        if (empty($_SERVER["HTTP_REFERER"])) {
        	$_SERVER["HTTP_REFERER"] = '';
        }
         
        if (strlen($_SERVER["HTTP_USER_AGENT"])>0) {
        	$userAgent = $_SERVER["HTTP_USER_AGENT"]; 
        } else {
        	$_SERVER["HTTP_USER_AGENT"] = 'CRONJOB';
        }
        
        // pack into event required by filters and writers
        $event = array_merge(array('dateInserted'   => date('Y-m-d H:i:s'),
        						   'timestamp'		=> time(),
                                   'message'   	 	=> $message,
                                   'info'      	 	=> $info,
                                   'priority'  	 	=> $priority,        							
        						   'userId'   		=> $userId,
        						   'userAgent' 	 	=> $_SERVER["HTTP_USER_AGENT"],
        						   'url' 		    => $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"],
        						   'referrer' 		=> $_SERVER["HTTP_REFERER"],
                              $this->_extras));

        // abort if rejected by the global filters
        foreach ($this->_filters as $filter) {
            if (! $filter->accept($event)) {
                return;
            }
        }

        // send to each writer
        foreach ($this->_writers as $writer) {
            $writer->write($event);
        }
    }

}
