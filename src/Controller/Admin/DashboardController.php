<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class DashboardController extends AppController
{
    public function index()
    {
    	$this->set('title', __('Dashboard'));

    	$employees = TableRegistry::get('Employees');
    	$administrators = TableRegistry::get('Administrators');
        $workDayLogs = TableRegistry::get('WorkDayLogs');
        $companiesTable = TableRegistry::get('Companies');

        $company = $companiesTable->find()->order(['id' => 'DESC'])->first();

    	$countEmployees = $employees->find()->count();
    	$countAdministrators = $administrators->find()->count();

        $employeeBirthDay = $employees->find()
            ->where(['MONTH(birthdate)' => date('m'), 'DAY(birthdate) >' => date('d')])
            ->toArray();

        $employeeContractDay = $employees->find()
            ->where(['MONTH(contract_date)' => date('m'), 'DAY(contract_date) >' => date('d')])
            ->toArray();

        $firstWorkDayLog = $workDayLogs->find()
            ->select('work_day')
            ->order(['work_day' => 'ASC'])
            ->first();

        $lastWorkDayLog = $workDayLogs->find()
            ->select('work_day')
            ->order(['work_day' => 'DESC'])
            ->first();

        $firstWorkDayTime = date('d.m.Y');
        if(!empty($firstWorkDayLog->work_day))
            $firstWorkDayTime = $firstWorkDayLog->work_day->format('d.m.Y');

        $lastWorkDayTime = date('d.m.Y');
        if(!empty($lastWorkDayLog->work_day))
            $lastWorkDayTime = $lastWorkDayLog->work_day->format('d.m.Y');

    	$this->set(compact('countEmployees', 'countAdministrators', 'employeeBirthDay', 'employeeContractDay', 'firstWorkDayTime', 'lastWorkDayTime', 'company'));
    }

    public function readCheckInLog()
    {
        $this->set('title', __('Check in log'));

        /*$dir = new Folder('..\logs');
        $checkInLog = $dir->find('checkIn.log');
        $checkInLog = new File($dir->pwd() . DS . $checkInLog[0]);*/

        if(file_exists(LOGS . 'checkIn.log'))
        {
            $checkInLog = LOGS . 'checkIn.log';
            $checkInContent = trim(implode("", array_slice(file($checkInLog), -500)));
        } else {
            $this->Flash->error(__("Log file doesn't exist."));
            $this->redirect(['action' => 'index']);
        }

        //read whole file:
        //$content = $file->read();

        $this->set(compact('checkInContent'));
    }

    public function readCheckOutLog()
    {
        $this->set('title', __('Check out log'));

        /*$dir = new Folder('C:\Projects\employee_timesheet\logs');
        $checkOutLog = $dir->find('checkOut.log');
        $checkOutLog = new File($dir->pwd() . DS . $checkOutLog[0]);*/

        if(file_exists(LOGS . 'checkOut.log'))
        {
            $checkOutLog = LOGS . 'checkOut.log';
            $checkOutContent = trim(implode("", array_slice(file($checkOutLog), -500)));
        } else {
            $this->Flash->error(__("Log file doesn't exist."));
            $this->redirect(['action' => 'index']);
        }

        //read whole file:
        //$content = $file->read();

        $this->set(compact('checkOutContent'));
    }

    public function hello()
    {
        die("kraj");
    }
}
