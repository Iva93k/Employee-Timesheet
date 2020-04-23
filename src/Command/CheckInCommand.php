<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

class CheckInCommand extends Command
{
	public function initialize()
    {
        parent::initialize();
        $this->loadModel('WorkDayLogs');
        $this->loadModel('WorkDayTypes');
        $this->loadModel('Employees');
        $this->loadModel('Companies');
    }

    public function execute(Arguments $args, ConsoleIo $io)
    {
    	$date = date('Y-m-d');

        Log::info('*** CHECK IN - START ***', 'checkIn');
        //$this->log('*** CHECK IN - START ***', 'info');

    	$company = $this->Companies->find()->order(['id' => 'DESC'])->first();

    	$workDayTypeDefault = $this->WorkDayTypes->find()
            ->select(['id'])
            ->where(['is_default' => true])
            ->first();
		
		$workDayTypeWeekend = $this->WorkDayTypes->find()
            ->select(['id', 'weekend_days'])
            ->where(['is_weekend' => true])
            ->first();

        $activeEmployees = $this->Employees->find()
        	->select(['id', 'first_name', 'last_name', 'status'])
        	->where(['status' => true, 'contract_date <' => $date])
        	->toArray();

        foreach ($activeEmployees as $activeEmployee) 
        {
            //$workDayLogExist = $this->WorkDayLogs->exists(['work_day' => $date, 'employee_id' => $activeEmployee->id]);

            $workDayLogExist = $this->WorkDayLogs->find()
                ->where(['work_day' => $date, 'employee_id' => $activeEmployee->id])
                ->first();

            if($workDayLogExist)
            {
                Log::warning('(ID: '.$activeEmployee->id.')' . ' ' . $activeEmployee->full_name . ' => already exists! (wdl ID: ' . $workDayLogExist->id . ')', 'checkIn');
                
                continue;
            }
			
			$workDayTypeID = $workDayTypeDefault->id;
				
			if($workDayTypeWeekend)
			{
                $weekendDays = $workDayTypeWeekend->getWeekendDays();
                
				$dayOfWeek = date("N");

				if(isset($weekendDays[$dayOfWeek]))
					$workDayTypeID = $workDayTypeWeekend->id;
			}

        	$workDayLogEntity = $this->WorkDayLogs->newEntity();

            $data = [
                'work_day'      	=> $date,
                'check_in_time' 	=> date('H:i', strtotime($company->start_working_time)),
                'check_out_time'	=> '00:00',
                'auto_logged'       => true,
                'employee_id'		=> $activeEmployee->id,
                'work_day_type_id' 	=> $workDayTypeID
            ];

            $workDayLog = $this->WorkDayLogs->patchEntity($workDayLogEntity, $data);

            $this->WorkDayLogs->save($workDayLog);

            if(empty($workDayLog->getErrors())) 
		    {
		    	if($this->WorkDayLogs->save($workDayLog))
			    {
                    Log::info('(ID: '.$activeEmployee->id.')' . ' ' . $activeEmployee->full_name . ' => Work day log successfully created! (wdl ID: ' . $workDayLog->id . ')', 'checkIn');                  
			    } else {
                    Log::alert('(ID: '.$activeEmployee->id.')' . ' ' . $activeEmployee->full_name . ' => Something went wrong, please try again!', 'checkIn');
			    }	
		    } else {

				foreach ($workDayLog->getErrors() as $fieldName => $fieldErrors) 
				{
					foreach ($fieldErrors as $errorType => $message) 
					{
                        Log::error('(ID: '.$activeEmployee->id.')' . ' ' . $activeEmployee->full_name . ' => Something went wrong:  ' . $fieldName . ': <<' . $errorType . '>> ' . $message, 'checkIn');
					}
				}
	    	}
        }
        Log::info('*** CHECK IN - END ***', 'checkIn');
        //$this->log('*** CHECK IN - END ***', 'info'); 
    }
}