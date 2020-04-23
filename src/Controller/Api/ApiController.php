<?php
namespace App\Controller\Api;

use App\Controller\AppController;

class ApiController extends AppController
{
	public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    protected function checkRequestMethod($methods = "get")
    {
    	if(empty($methods))
    		$methods = "get";

    	if(is_string($methods))
    		$methods = [$methods];

    	if ($this->request->is($methods))
    		return true;

    	return false;
    }
}