<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

class DocsController extends AppController
{
   public function clientApi()
   {
   		$this->set('title', __('Client API'));
       	$parsedown = new \Parsedown();
       	$text = $parsedown->text(file_get_contents(ROOT.DS."src".DS."Docs".DS."client-api.md"));
       
       	$this->set(compact('text'));
   }
}