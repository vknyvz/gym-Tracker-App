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
class vkNgine_Cache
{
    /** 
	 * various cache keys
	 * 
	 * @var const
	 */
	const USER = 'user_';
    
	private $_cacheObject = null;
	
	const FILE = 'file';
	const MEMCACHED = 'memcached';
		
	public function __construct($useCache = null, $cacheType = null, $frontendName = 'Core')
	{
		if(!isset($useCache)) {
			$useCache = false;
		}
		
		if(!isset($cacheType)) {
			$cacheType = 'file';
		}
			
		$automaticSerialization = true;
		
		if($cacheType == self::FILE) {
			
		    $config = vkNgine_Config::getSystemConfig();
		    
			$cacheDir = $config->cache->dir;
			
			if(!file_exists($cacheDir)) 
				mkdir($cacheDir);
				
			$backendName = $cacheType;
			$backendOptions = array('cache_dir' => $cacheDir);
			$frontendOptions = array('caching' => $useCache, 'lifetime' => $config->cache->lifetime, 'automatic_serialization' => $automaticSerialization);
			
			$this->_cacheObject = Zend_Cache::factory($frontendName, $backendName, $frontendOptions, $backendOptions);
			
		} 
		elseif($cacheType == self::MEMCACHED) {
			
			$backendName = $cacheType;
			$backendOptions = array('servers' => array(array('host' => '127.0.0.1', 'port' => '11211')), 'compression' => true);
			$frontendOptions = array('caching' => $useCache, 'write_control' => true, 'automatic_serialization' => $automaticSerialization, 'ignore_user_abort' => true );
			
			$this->_cacheObject = Zend_Cache::factory($frontendName, $backendName, $frontendOptions, $backendOptions);
			
		}
		else {
			throw new Exception($cacheType.' - cache type is not supported');
		}
	}
	
	public function save($value, $key)
	{
	    return $this->_cacheObject->save($value, $key);
	}
	
	public function load($key)
	{
		$value = $this->_cacheObject->load($key);
		return $value;
	}
	
	public function remove($key)
	{
		return $this->_cacheObject->remove($key);
	}
	
	public function cleanCache($all = null)
	{
	    $mode = $all ? Zend_Cache::CLEANING_MODE_ALL : Zend_Cache::CLEANING_MODE_OLD;
	    
	    return $this->_cacheObject->clean($mode);
	}
	
	public function getCacheObject()
	{	
		return $this->_cacheObject;
	}	
}