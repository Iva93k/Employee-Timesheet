<?php 
namespace App\Controller\Api;

use App\Controller\Api\ApiController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\I18n\Time;

class WorkDayLogsController extends ApiController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function checkIn()
    {
        //check request method
        if(!$this->checkRequestMethod("post"))
            return $this->response->withType('application/json')
                ->withStatus(400)
                ->withStringBody(json_encode(['message' => __d("api", "Method is not supported!"), 'data' => []]));

        $company = TableRegistry::get('Companies')->find()->select('lunch_break')->order(['id' => 'DESC'])->first();

        $authEmployee = $this->Auth->user();
        
        $date = date('Y-m-d');

        $workDayLogExist = $this->WorkDayLogs->find()
            ->select(['work_day_type_id', 'work_day', 'check_in_time', 'check_out_time'])
            ->where(['work_day' => $date, 'employee_id' => $authEmployee['id']])
            ->first();

        $responseData = [
            'message'   => 'OK',
            'data'      => [],
            '_serialize'=> ['message', 'data']
        ];

        if($workDayLogExist)
        {
            $workDayLogExist['year']         = $workDayLogExist->work_day->format('Y');
            $workDayLogExist['month']        = $workDayLogExist->work_day->format('n');
            $workDayLogExist['day']          = $workDayLogExist->work_day->format('j');
            $workDayLogExist['month_name']   = $workDayLogExist->work_day->format('F');
            $workDayLogExist['time_spent']   = $workDayLogExist->getTotalWorkTime();

            $responseData['data'] = $workDayLogExist;
            $responseData['message'] = __d("api", "Work day log already exists!");
        } else {
            $workDayLogEntity = $this->WorkDayLogs->newEntity();

            $data = [
                'work_day'      => $date,
                'employee_id'   => $authEmployee['id'],
                'check_in_time' => new Time(),
                'check_out_time'=> new Time('00:00'),
                'auto_logged'   => false
            ];

            $requestData = $this->request->getData();

            if(!isset($requestData['work_day_type_id']))
            {
                $workDayType = TableRegistry::get('WorkDayTypes')->find()
                ->where(['is_default' => true])
                ->select(['id'])
                ->first();
                
                if($workDayType)
                    $data['work_day_type_id'] = $workDayType->id;
            }

            $workDayLog = $this->WorkDayLogs->patchEntity($workDayLogEntity, $data);

            if ($this->WorkDayLogs->save($workDayLog)) 
            {   
                $workDayLog['year']         = $workDayLog->work_day->format('Y');
                $workDayLog['month']        = $workDayLog->work_day->format('n');
                $workDayLog['day']          = $workDayLog->work_day->format('j');
                $workDayLog['month_name']   = $workDayLog->work_day->format('F');
                $workDayLog['time_spent']   = $workDayLog->getTotalWorkTime();
                $workDayLog['check_in_time']  = $workDayLog->check_in_time->format('H:i');
                $workDayLog['check_out_time'] = $workDayLog->check_out_time->format('H:i');

                unset($workDayLog['employee_id']);
                unset($workDayLog['auto_logged']);
                unset($workDayLog['created']);
                unset($workDayLog['modified']);
                unset($workDayLog['id']);

                $responseData['data'] = $workDayLog;
                $responseData['message'] = __d("api", "Log successfully added!");
            } else {
                $this->response = $this->response->withStatus(400);
                $responseData['message'] = __d("api", "Please check your input data!");
                $responseData['error']  = $workDayLog->getErrors();
                $responseData['_serialize']  = ['message', 'data', 'error'];
            }
        }

        $this->set($responseData);
        
    }

    public function checkOut()
    {
        //check request method
        if(!$this->checkRequestMethod("post"))
            return $this->response->withType('application/json')
                ->withStatus(400)
                ->withStringBody(json_encode(['message' => __d("api", "Method is not supported!"), 'data' => []]));

        $company = TableRegistry::get('Companies')->find()->select('lunch_break')->order(['id' => 'DESC'])->first();

        $authEmployee = $this->Auth->user();   

        $date = date('Y-m-d');

        $workDayLogExist = $this->WorkDayLogs->find()
            ->select(['id', 'work_day_type_id', 'work_day', 'check_in_time', 'check_out_time'])
            ->where(['work_day' => $date, 'employee_id' => $authEmployee['id']])
            ->first();

        $responseData = [
            'message'   => 'OK',
            'data'      => [],
            '_serialize'=> ['message', 'data']
        ];
        
        if(!$workDayLogExist)
        {
            $responseData['data'] = $workDayLogExist;
            $responseData['message'] = __d("api", "Please, check in first!");
        } else {
            
            if(date('H:i', strtotime($workDayLogExist->check_out_time)) == '00:00')
            {
                $data = [
                    'check_out_time'=> new Time(),
                    'auto_logged'   => false
                ];

                $workDayLog = $this->WorkDayLogs->patchEntity($workDayLogExist, $data);

                if ($this->WorkDayLogs->save($workDayLog)) 
                {
                    $workDayLog['year']         = $workDayLog->work_day->format('Y');
                    $workDayLog['month']        = $workDayLog->work_day->format('n');
                    $workDayLog['day']          = $workDayLog->work_day->format('j');
                    $workDayLog['month_name']   = $workDayLog->work_day->format('F');
                    $workDayLog['time_spent']   = $workDayLog->getTotalWorkTime();
                    $workDayLog['check_in_time']  = $workDayLog->check_in_time->format('H:i');
                    $workDayLog['check_out_time'] = $workDayLog->check_out_time->format('H:i');


                    unset($workDayLogExist['id']);
                    unset($workDayLogExist['auto_logged']);
                    unset($workDayLogExist['modified']);

                    $responseData['data'] = $workDayLog;
                    $responseData['message'] = __d("api", "Log successfully updated!");
                } else {
                    $this->response = $this->response->withStatus(400);
                    $responseData['message'] = __d("api", "Please check your input data!");
                    $responseData['error']  = $workDayLog->getErrors();
                    $responseData['_serialize']  = ['message', 'data', 'error'];
                }
            } else {
                $workDayLogExist['year']         = $workDayLogExist->work_day->format('Y');
                $workDayLogExist['month']        = $workDayLogExist->work_day->format('n');
                $workDayLogExist['day']          = $workDayLogExist->work_day->format('j');
                $workDayLogExist['month_name']   = $workDayLogExist->work_day->format('F');
                $workDayLogExist['time_spent']   = $workDayLogExist->getTotalWorkTime();
                
                unset($workDayLogExist['id']);

                $responseData['message'] = __d("api", "You are already checked out!");
                $responseData['data'] = $workDayLogExist;
            }
        }
        $this->set($responseData);
    } 

    public function list()
    {
        $authEmployee = $this->Auth->user();

        $workDayLogs = $this->WorkDayLogs->find()
            ->select(['work_day_type_id', 'work_day', 'check_in_time', 'check_out_time']);

        $company = TableRegistry::get('Companies')->find()->select('lunch_break')->order(['id' => 'DESC'])->first();

        $queryParams = $this->request->getQueryParams();
        
        $conditions = [
            'employee_id'       => $authEmployee['id'],
            'MONTH(work_day)'   => date('n'),
            'YEAR(work_day)'    => date('Y')
        ];

        if(!empty($queryParams))
        {
            if(isset($queryParams['month']))
                $conditions['MONTH(work_day)'] = $queryParams['month'];

            if(isset($queryParams['year']))
                $conditions['YEAR(work_day)'] = $queryParams['year'];
        }

        $workDayLogs = $workDayLogs->where($conditions)
            ->order(['work_day' => 'ASC'])
            ->toArray();

        foreach ($workDayLogs as $workDayLog) 
        {
            $workDayLog['year']         = $workDayLog->work_day->format('Y');
            $workDayLog['month']        = $workDayLog->work_day->format('n');
            $workDayLog['day']          = $workDayLog->work_day->format('j');
            $workDayLog['month_name']   = $workDayLog->work_day->format('F');
            $workDayLog['time_spent']   = $workDayLog->getTotalWorkTime($company->lunch_break);
        }

        $this->set([
            'data'      => $workDayLogs,
            'message'   => "OK",
            '_serialize'=> ['message', 'data']
        ]);
    }

    public function dailyChecker()
    {
        $authEmployee = $this->Auth->user();

        $workDayLog = $this->WorkDayLogs->find()
            ->where(['employee_id' => $authEmployee['id'], 'work_day' => date('Y-m-d')])
            ->select(['work_day_type_id', 'work_day', 'check_in_time', 'check_out_time'])
            ->first();

        if($workDayLog)
        {
            $workDayLog['year']         = $workDayLog->work_day->format('Y');
            $workDayLog['month']        = $workDayLog->work_day->format('n');
            $workDayLog['day']          = $workDayLog->work_day->format('j');
            $workDayLog['month_name']   = $workDayLog->work_day->format('F');
            $workDayLog['time_spent']   = $workDayLog->getTotalWorkTime();
        }

        $this->set([
            'data'      => $workDayLog,
            'message'   => "OK",
            '_serialize'=> ['message', 'data']
        ]);
    } 
}
