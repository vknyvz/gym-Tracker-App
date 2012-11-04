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
class Admin_SystemController extends vkNgine_Admin_Controller
{
	public function indexAction()
	{
		parent::init();
		parent::ajaxEnabled();
		
		$form = $this->getAdminSystemSettingsForm();
		
		$oldConfig = vkNgine_Config::getSystemConfig();
	    $oldValues = $oldConfig->toArray();
	    
		$populateData = array();
		$populateData['app_description'] = $oldValues['meta']['appDescription'];
		$populateData['app_keywords'] = $oldValues['meta']['appKeywords'];
		$populateData['language'] = $oldValues['language']['locale'];
	    $populateData['timezone'] = $oldValues['phpSettings']['date']['timezone'];
	    $populateData['login_remember'] = $oldValues['settings']['login']['remember'];
	    $populateData['per_page'] = $oldValues['pagination']['perPage'];
	    $populateData['cache_enabled'] = $oldValues['cache']['use'];
	    $populateData['cache_type'] = $oldValues['cache']['type'];
	    $populateData['cache_dir'] = $oldValues['cache']['dir'];
	    $populateData['cache_lifetime'] = $oldValues['cache']['lifetime'];
	    $populateData['default_module'] = $oldValues['resources']['frontController']['defaultModule'];
	    $populateData['debug_enabled'] = $oldValues['settings']['debug']['enabled'];
	    $populateData['ga_enabled'] = $oldValues['settings']['ga']['enabled'];
	    $populateData['ga_code'] = $oldValues['settings']['ga']['code'];
	    $populateData['form_expiration_time'] = $oldValues['settings']['formexpiretime'];
	    $populateData['mail_server'] = $oldValues['mail']['server'];
	    $populateData['mail_type'] = $oldValues['mail']['serverType'];
	    $populateData['mail_port'] = $oldValues['mail']['port'];
	    $populateData['mail_username'] = $oldValues['mail']['username'];
	    $populateData['mail_noreply'] = $oldValues['mail']['noreply'];
	    $populateData['mail_password'] = $oldValues['mail']['password'];
	    $populateData['live_db_host'] = vkNgine_Config::getConfigByEnvironment('production')->resources->db->params->host;
	    $populateData['live_db_user'] = vkNgine_Config::getConfigByEnvironment('production')->resources->db->params->username;
	    $populateData['live_db_pass'] = vkNgine_Config::getConfigByEnvironment('production')->resources->db->params->password;
	    $populateData['live_dbname'] = vkNgine_Config::getConfigByEnvironment('production')->resources->db->params->dbname;
	    $populateData['dev_db_host'] = vkNgine_Config::getConfigByEnvironment('development')->resources->db->params->host;
	    $populateData['dev_db_user'] = vkNgine_Config::getConfigByEnvironment('development')->resources->db->params->username;
	    $populateData['dev_db_pass'] = vkNgine_Config::getConfigByEnvironment('development')->resources->db->params->password;
	    $populateData['dev_dbname'] = vkNgine_Config::getConfigByEnvironment('development')->resources->db->params->dbname;
	    
		$form->populate($populateData);
		
		$request = $this->getRequest();
		
    	if($request->isPost()){
    		$post = $request->getPost();
    		    		
				if($form->isValid($post)){
		    		$values = $form->getValues();
		    		
		    		$realValues = array();
		    		foreach($values as $formName => $field) {
		    			$realValues = $field;
		    		}
		    		
			        $oldValues = self::array_htmlspecialchars($oldValues);
			        
			        $settings = array(
			        	"global" => array(
			    	        "autoloaderNamespaces" => array(
			        	        "vkNgine" => $oldValues['autoloaderNamespaces']['vkNgine'],
			            	    "Thumbnail" => $oldValues['autoloaderNamespaces']['Thumbnail'],
			        			"Calendar" => $oldValues['autoloaderNamespaces']['Calendar'],
			                	"zfdebug" => $oldValues['autoloaderNamespaces']['zfdebug'],
			                ),
			                "bootstrap" => array(
			       	            "path" => $oldValues['bootstrap']['path'],
			                    "class" => $oldValues['bootstrap']['class'],
			                ),
			                
			                "cache" => array(
			       	            "use" => $realValues['Cache_Settings']['cache_enabled'],
			                    "type" => $realValues['Cache_Settings']['cache_type'],
			                	"dir" => $realValues['Cache_Settings']['cache_dir'],
			                	"lifetime" => $realValues['Cache_Settings']['cache_lifetime'],
			                ),
			        		"assets" => array(
			        			 "path" => $oldValues['assets']['path'],
			        		),
			                "language" => array(
			                	"locale" => $realValues['Language_Settings']['language'],
				                "file" => array(
				                	"en" => array(
    									"name" => $oldValues['language']['file']['en']['name'],
    									"master" => $oldValues['language']['file']['en']['master'],
    									"app" => $oldValues['language']['file']['en']['app'],
						 		    ),
									"tr" => array(
    									"name" => $oldValues['language']['file']['tr']['name'],
    									"master" => $oldValues['language']['file']['tr']['master'],
    									"app" => $oldValues['language']['file']['tr']['app'],
						 		    ),
						 		),
			                ),
			                "phpSettings" => array(
			                    "date" => array(
			  						"timezone" => $realValues['Date_and_Time_Settings']['timezone'],
			               		),
			          		),
			          		"mail" => array(
			                    "serverType" => $realValues['Email_Settings']['mail_type'],
			  					"server" => $realValues['Email_Settings']['mail_server'],
			          			"port" => $realValues['Email_Settings']['mail_port'],
			          			"username" => $realValues['Email_Settings']['mail_username'],
			          			"auth" => "login",
			          			"noreply"  => $realValues['Email_Settings']['mail_noreply'],
			          			"password" => $realValues['Email_Settings']['mail_password'],
			          			),	
			          		"settings" => array(
			          			"ga" => array(
			       	            	"enabled" => $realValues['Google_Analytics_Settings']['ga_enabled'],
			          				"code" => $realValues['Google_Analytics_Settings']['ga_code'],
			                	),
			          			"formexpiretime" => $realValues['General_Settings']['form_expiration_time'],
			          			"login" => array(
			       	            	"remember" => $realValues['General_Settings']['login_remember'],
			                	),
			                    "debug" => $realValues['General_Settings']['debug_enabled'],
			          			),
			          		"meta" => array(
			                    "appDescription" => $realValues['General_Settings']['app_description'],
			  					"appKeywords" => $realValues['General_Settings']['app_keywords'],
			          			),	
			          		"master" => array(
			                    "user" => 1,
			          			),
			          		"pagination" => array(
			          			"perPage" => $realValues['General_Settings']['per_page'],
			          			),
			          		"resources" => array(
				                "modules" => $realValues['General_Settings']['default_module'],
			          			"locale" => $realValues['Language_Settings']['language'],
				                "frontController" => array(
				                	"defaultModule" => $oldValues['resources']['frontController']['defaultModule'],
				                    "controllerDirectory" => $oldValues['resources']['frontController']['controllerDirectory'],
			          				"moduleDirectory" => $oldValues['resources']['frontController']['moduleDirectory'],
					 		    ),
				                "view" => array(
				        			"helperPath" => $oldValues['resources']['view']['helperPath'],
				     			),
				     			"layout" => array(
				        			"layoutPath" => $oldValues['resources']['layout']['layoutPath'],
				     			),
				     			"locale" => array(
				        			"default" => $oldValues['resources']['locale']['default'],
				     			),
			                ),
			        	)
			        );
			        
					$production = array(
		    	        "phpSettings" => array(
		        	        "display_startup_errors" => 0,
		            	    "display_errors" => 0,
		                ),
		            	"resources" => array(
		        	        "db" => array(
		        	        	"adapter" => 'pdo_mysql',
		            	    	"params" => array(
		        	        		"host" => $realValues['Application_Environment_Settings_for_Production']['live_db_host'],
		                			"username" => $realValues['Application_Environment_Settings_for_Production']['live_db_user'],
		                			"password" => $realValues['Application_Environment_Settings_for_Production']['live_db_pass'],
		                			"dbname" => $realValues['Application_Environment_Settings_for_Production']['live_dbname'],
		                		),      
		                	),
		                ),
			        );
			        
			        $development = array(        	
		    	        "phpSettings" => array(
		        	        "display_startup_errors" => 1,
		            	    "display_errors" => 1,
		                ),
		                "settings" => array(
		                    "debug" => $realValues['General_Settings']['debug_enabled'],
		          			),
		            	"resources" => array(
		          			"frontController" => array(
			                    "disableOutputBuffering" => 1,
				                	"params" => array(
				                		"displayExceptions" => 1,
				                	),
		          			),
		        	        "db" => array(
		        	        	"adapter" => 'pdo_mysql',
		            	    	"params" => array(
		        	        		"host" => $realValues['Application_Environment_Settings_for_Development']['dev_db_host'],
		                			"username" => $realValues['Application_Environment_Settings_for_Development']['dev_db_user'],
		                			"password" => $realValues['Application_Environment_Settings_for_Development']['dev_db_pass'],
		                			"dbname" => $realValues['Application_Environment_Settings_for_Development']['dev_dbname'],
		            	    		"unix_socket" => '/usr/local/zend/mysql/tmp/mysql.sock',
		                		),      
		                	),
		                ),
			        );
					
			        $config = new Zend_Config($settings, true);
			        
					$config->production = $production;
					$config->development = $development;
					
					$config->setExtend('production', 'global');
					$config->setExtend('development', 'production');
					
					$writer = new Zend_Config_Writer_Xml(array(
				        "config" => $config,
			            "filename" => APPLICATION_PATH . '/configs/config.xml'
			        ));
			        $writer->write();
			        
			        echo Zend_Json::encode(array('success' => 1, 
												 'title'   => $this->t->_('Success Message'),
											     'message' => $this->t->_('System Settings were updated'),
												 'icon'    => 'success'
					));
					exit;
		    	}
		    	else {
		    		echo Zend_Json::encode(array('title'   => $this->t->_('Error Message'), 
											 	 'message' => $this->t->_('Please fill out all required fields'),
												 'icon'    => 'error' ));
					exit;
		    	}
    		
    	}
        $this->view->form = $form;
	}
	
	public function truncateCacheAction()
	{
	    $config = new vkNgine_Cache();
	    if($config->cleanCache(true)) {
	        echo Zend_Json::encode(array('success' => 1,
						    		     'title'   => $this->t->_('Success Message'),
						    		     'message' => $this->t->_('Cache database was truncated successfully'),
						    		     'icon'    => 'success'
			));
	    }
	    else {
	        echo Zend_Json::encode(array('success' => 0,
						        		 'title'   => $this->t->_('Error Message'),
						        		 'message' => $this->t->_('Cache database was not truncated'),
						        		 'icon'    => 'error'
	        ));
	    }
	    exit;
	}
	
	private function getAdminSystemSettingsForm()
	{
		$form = new Admin_Model_Form_SystemSettings(array(
			'method' => 'post',
			'action' => 'yare yare',
		));		
    	
		return $form;
	}
	
	private function array_htmlspecialchars ($array)
	{
	    foreach ($array as $key => $value) {
	        if(is_string($value) || is_numeric($value)) {
	            $array[$key] = htmlspecialchars($value,ENT_COMPAT,"UTF-8");
	        } 
	        else if (is_array($value)) {
	            $array[$key] = self::array_htmlspecialchars($value);
	        }
	    }

    	return $array;
	}
}


