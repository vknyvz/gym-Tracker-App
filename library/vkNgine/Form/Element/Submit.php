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
class vkNgine_Form_Element_Submit extends Zend_Form_Element_Submit
{
    public function __construct($spec = null, $options = null)
    {
		parent::__construct($spec, $options);
    	
		$this->removeDecorator('DtDdWrapper')
			 ->setLabel($options['value'])
       		 ->setAttribs(array('class' => $options['class'], 
       		 				    'id'	=> null,
       		 					'type'  => (isset($options['type'])) ? $options['type'] : 'submit'));
       		 
		
		if(isset($options['removeDecorators'])){
			$this->removeDecorator('HtmlTag')
			     ->removeDecorator('Label');
		}
		else {
			$this->setDecorators(array(
		    		'viewHelper',
       		 		array(array('data' => 'htmlTag'),
       		 		array('tag' => 'li', 'class' => 'buttons')),
       		 		array(array('row' => 'HtmlTag'), array('tag' => 'ul'))));
		}
    }
}