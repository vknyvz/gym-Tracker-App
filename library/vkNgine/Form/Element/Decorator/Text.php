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
class vkNgine_Form_Element_Decorator_Text extends Zend_Form_Decorator_Abstract 
{	
	public function buildLabel()
    {
        $element = $this->getElement();
        $label = $element->getLabel();
        if ($translator = $element->getTranslator()) {
            $label = $translator->translate($label);
        }
        $class = 'vkNgineLabel';
        if ($element->isRequired()) {
            //$label .= '(*)';
            $class .= ' required';
        }
        
        //$label .= ':';
        
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
        return '<div>' . $desc . '</div>';
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
        
        $label     = $this->buildLabel();
        $input     = $this->buildInput();
        $desc      = $this->buildDescription();
        
        $output = '
						' . $label . '
						' . $input . '
						' . $desc . '
					';
        
    	return $output;
    }
}
	