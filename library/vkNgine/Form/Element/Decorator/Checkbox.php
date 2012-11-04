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
class vkNgine_Form_Element_Decorator_Checkbox extends Zend_Form_Decorator_Abstract 
{
	protected $_placement;
	protected $_labelClass;
	
	public function __construct($options = null)
	{	
		$this->_placement = $options['placement'];
		$this->_labelClass = $options['labelClass'];
	}
	
	public function buildLabel()
    {
        $element = $this->getElement();
        $label = $element->getLabel();
        if ($translator = $element->getTranslator()) {
            $label = $translator->translate($label);
        }
        
        $class = null;
        if('empty' == $this->_labelClass) {
        	$class = 'prepend';
        }        
        if ($element->isRequired()) {
            $class .= ' required'; //$label .= '(*)';
        }
        
        return $element->getView()
                       ->formLabel($element->getName(), $label, array('class' => $class));
    }
	
	public function buildInput() 
	{
        $element = $this->getElement();
        $helper  = $element->helper;
        
        return $element->getView()->$helper(
            $element->getName(),
            $element->getValue(),
            $element->getAttribs(),
            $element->options
        );
	}	
	
	public function buildDescription()
	{
        $element = $this->getElement();
        $desc    = $element->getDescription();
        if (empty($desc)) {
            return '';
        }
        return '<div>' . $desc . '</div';
	}
	
	public function render($content)
    {
    	$element = $this->getElement();
        
        if (!$element instanceof Zend_Form_Element) {
            return $content;
        }
        if (null === $element->getView()) {
            return $content;
        }
        
        $placement = $this->getPlacement();
        $label     = $this->buildLabel();
        $input     = $this->buildInput();
        $desc 	   = $this->buildDescription();
        
        $output = '
					<p>
				  ';
      
       	if($placement && $placement == 'PREPEND') {
       		$output .= $label . $input . $desc;
       	}
       	else {
       		$output .= $input . $label . $desc;
       	}
        
        $output .= '
					</p>			   
				   ';
        
    	return $output;
    }
}
	