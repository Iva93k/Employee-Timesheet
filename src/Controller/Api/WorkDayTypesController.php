<?php 
namespace App\Controller\Api;

use App\Controller\Api\ApiController;

class WorkDayTypesController extends ApiController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function index()
    {
        $workDayTypes = $this->WorkDayTypes
            ->find()
            ->select(['id', 'code', 'title', 'check_in_enabled', 'description', 'color', 'payed'])
            ->limit(100);

        $conditions = [];
        $queryParams = $this->request->getQueryParams();

        if(!empty($queryParams))
        {
            if(isset($queryParams['check_in_enabled']))
                $conditions['check_in_enabled'] = (bool)$queryParams['check_in_enabled'];
        }

        $workDayTypes->where($conditions);

        $this->set([
            'data'      => $workDayTypes,
            'message'   => "OK",
            '_serialize'=> ['message', 'data']
        ]);
    }
}
  