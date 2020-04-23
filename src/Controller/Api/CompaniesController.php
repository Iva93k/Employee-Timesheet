<?php
namespace App\Controller\Api;

use App\Controller\Api\ApiController;
use Cake\Event\Event;

class CompaniesController extends ApiController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        
        $this->Auth->allow('index');
    }

    public function index()
    {
        $message = 'OK';

        return $this->response->withType('application/json')->withStatus(200)->withStringBody(json_encode(['message' => $message, 'data' => []]));

        /*$this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);*/
    }

    public function view()
    {
        $company = $this->Companies->find()->order(['id' => 'DESC'])->first();

        unset($company['id']);
        unset($company['created']);
        unset($company['modified']);

        $this->set([
            'data'      => $company,
            'message'   => "OK",
            '_serialize'=> ['message', 'data']
        ]);
    }
}