<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\ORM\TableRegistry;

class TestDataCommand extends Command
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
    	$company = $this->Companies->find()->order(['id' => 'DESC'])->first();

    	$workDayTypeDefault = $this->WorkDayTypes->find()
            ->select(['id'])
            ->where(['is_default' => true])
            ->first();
			
		$workDayTypeWeekend = $this->WorkDayTypes->find()
            ->select(['id', 'is_weekend', 'weekend_days'])
            ->where(['is_weekend' => true])
            ->first();

        $employees = $this->Employees->find()
			->select(['id'])
			->where(['status' => true, 'contract_date <' => date('Y-m-d')])
			->toArray();

        foreach ($employees as $employee) 
        {
        	$startDate = date('Y-m-01');

        	if(strtotime($startDate) == strtotime(date('Y-m-d')))
        		$startDate = date('Y-m-d', strtotime('-1 month'));

			$period = new \DatePeriod(
				new \DateTime($startDate),
				new \DateInterval('P1D'),
				new \DateTime(date('Y-m-d'))
			);
			
			foreach($period as $date)
			{
				$workDayLogExist = $this->WorkDayLogs->exists(['work_day' => $date->format('Y-m-d'), 'employee_id' => $employee->id]);
				
				if($workDayLogExist)
					continue;
				
				$workDayTypeID = $workDayTypeDefault->id;
				
				if($workDayTypeWeekend)
				{
					$weekendDays = $workDayTypeWeekend->getWeekendDays();

					$dayOfWeek = date('N', strtotime($date->format('Y-m-d')));

					if(isset($weekendDays[$dayOfWeek]))
						$workDayTypeID = $workDayTypeWeekend->id;
				}

				$workDayLogEntity = $this->WorkDayLogs->newEntity();

				$data = [
					'work_day'      	=> $date->format('Y-m-d'),
					'check_in_time' 	=> date('H:i', strtotime($company->start_working_time)),
					'check_out_time'	=> date('H:i', strtotime($company->end_working_time)),
					'employee_id'		=> $employee->id,
					'work_day_type_id' 	=> $workDayTypeID
				];

				$workDayLog = $this->WorkDayLogs->patchEntity($workDayLogEntity, $data);

				$this->WorkDayLogs->save($workDayLog);
			}
        }     
    }
}