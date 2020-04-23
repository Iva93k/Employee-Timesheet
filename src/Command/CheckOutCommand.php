<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\ORM\TableRegistry;
use Cake\ORM\Query;
use Cake\Log\Log;

class CheckOutCommand extends Command
{
	public function initialize()
    {
        parent::initialize();
        $this->loadModel('WorkDayLogs');
        $this->loadModel('Employees');
        $this->loadModel('Companies');
    }

    public function execute(Arguments $args, ConsoleIo $io)
    {
    	$date = date('Y-m-d');
        
        Log::info('*** CHECK OUT - START ***', 'checkOut');

    	$company = $this->Companies->find()->order(['id' => 'DESC'])->first();

        $activeEmployees = $this->Employees->find()
        	->select(['id', 'first_name', 'last_name', 'status'])
        	->where(['status' => true, 'contract_date <' => $date])
            ->limit(999)
        	->toArray();

        foreach ($activeEmployees as $activeEmployee) 
        {        	
        	$workDayLogExist = $this->WorkDayLogs->find()
                ->select(['id', 'check_out_time'])
                ->where(['work_day' => $date, 'employee_id' => $activeEmployee->id])
                ->first();

            if($workDayLogExist && date('H:i', strtotime($workDayLogExist->check_out_time)) == '00:00')
            {   
                $data = [
                    'check_out_time'    => date('H:i', strtotime($company->end_working_time))
                ];

                $workDayLog = $this->WorkDayLogs->patchEntity($workDayLogExist, $data);
                $this->WorkDayLogs->save($workDayLog);

                if(empty($workDayLog->getErrors())) 
                {
                    if($this->WorkDayLogs->save($workDayLog))
                    {
                        Log::info('(ID: '.$activeEmployee->id.')' . ' ' . $activeEmployee->full_name . ' => Work day log successfully updated! (wdl ID: ' . $workDayLog->id . ')', 'checkOut');
                    } else {
                        Log::alert('(ID: '.$activeEmployee->id.')' . ' ' . $activeEmployee->full_name . ' => Something went wrong, please try again!', 'checkOut');
                    }   
                } else {

                    foreach ($workDayLog->getErrors() as $fieldName => $fieldErrors) 
                    {
                        foreach ($fieldErrors as $errorType => $message) 
                        {
                            Log::error('(ID: '.$activeEmployee->id.')' . ' ' . $activeEmployee->full_name . ' => Something went wrong:  ' . $fieldName . ': <<' . $errorType . '>> ' . $message, 'checkOut');
                        }
                    }
                }   
            } else {
                Log::warning('(ID: '.$activeEmployee->id.')' . ' ' . $activeEmployee->full_name . ' => You are already checked out! (wdl ID: ' . $workDayLogExist->id . ')', 'checkOut');
            }
        }
        Log::info('*** CHECK OUT - END ***', 'checkOut');   
    }
}