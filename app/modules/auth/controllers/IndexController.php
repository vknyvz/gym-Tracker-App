<?php

class Auth_IndexController extends vkNgine_Auth_Controller
{
    public function indexAction()
    {
        $this->_redirect("/auth/login");
    }	 
}