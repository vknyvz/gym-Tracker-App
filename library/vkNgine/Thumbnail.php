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
class vkNgine_Thumbnail
{
	protected $_thumb = null;
	
	/**
	 * implementation construct for vkNgine
	 * 
	 * @param unknown_type $src
	 * @param unknown_type $pngPath
	 */
	public function __construct($src, $pngPath = null)
	{
		require_once 'Thumbnail/ThumbLib.inc.php';
		
		try
		{
			$this->_thumb = PhpThumbFactory::create($src);
			
			if ($pngPath){
				// convert to PNG before any manipulation
				$_src = $pngPath . DIRECTORY_SEPARATOR . uniqid();
				$this->_thumb->save($_src, 'PNG');
				
				$this->_thumb = PhpThumbFactory::create($_src);
			}
		}
		catch (Exception $e)
		{
			//
		}
	}
	
	/**
	 * resize method for given width and height
	 * 
	 * @param int $w
	 * @param int $h
	 */
	public function resize($w, $h)
	{
		return $this->_thumb->resize($w, $h);
	}
	
	/**
	 * adaptiveResize method for given width and height
	 * 
	 * @param int $w
	 * @param int $h
	 */
	public function adaptiveResize($w, $h)
	{
		return $this->_thumb->adaptiveResize($w, $h);
	}
	
	/**
	 * saves the processed file
	 * 
	 * @param unknown_type $target
	 * @param unknown_type $ext
	 */
	public function save($target, $ext = null)
	{
		return $this->_thumb->save($target, $ext);
	}
}