<?php
class AssetsController extends vkNgine_Public_Controller
{
	public function init()
	{
		parent::init();
	}
	
	public function viewAction() 
    {
    	if($this->_getParam('assetType') == 'picture') {
    		$path = '/images/exercises';
    	}
    	
    	if($this->_getParam('type') == 'thumb'){
    		$type = '/thumb'; 
    	}
    	elseif($this->_getParam('type') == 'full'){
    		$type = '/full'; 
    	}
    	
    	if($this->_getParam('kind')){
    		switch($this->_getParam('kind')){
    			case 'glutes, hamstrings, quadriceps':
    			case 'glutes':
    			case 'hamstrings':
    			case 'quadriceps':
    				$kind = '/legs';
    				break;
    			case 'abs':
    				$kind = '/abdominals';
    				break;
    			case 'back':
    				$kind = '/back';
    				break;
    			case 'biceps':
    				$kind = '/biceps';
    				break;
    			case 'calves':
    				$kind = '/calves';
    				break;
    			case 'chest':
	    			$kind = '/chest';
	    			break;
    			case 'shoulders':
    				$kind = '/shoulders';
    				break;
    			case 'back':
	    			$kind = '/back';
	    			break;
    			case 'forearms':
    				$kind = '/forearms';
	    			break;
    			case 'traps':
    				$kind = '/traps';
    				break;
    			case 'triceps':
	    			$kind = '/triceps';
	    			break;
    		}
    	}
    	
    	$file = '/'. $this->_getParam('file');
    	
    	$file = vkNgine_Config::getSystemConfig()->assets->path . $path . $type . $kind . $file;
    	
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->view->layout()->disableLayout();
    	 
        $image = readfile($file);
        
        header('Content-Type: image/jpg');
        
        $modified = new Zend_Date(filemtime($file));
        
        $this->getResponse()
             ->setHeader('Last-Modified', $modified->toString(Zend_Date::RFC_1123))
             ->setHeader('Content-Type', 'image/jpg')
             ->setHeader('Expires', '', true)
             ->setHeader('Cache-Control', 'public', true)
             ->setHeader('Cache-Control', 'max-age=3800')
             ->setHeader('Pragma', '', true);
        
        echo $image;
    }
}