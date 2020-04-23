<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\ORM\TableRegistry;

class InstallCommand extends Command
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Administrators');
        $this->loadModel('Companies');
    }

    public function execute(Arguments $args, ConsoleIo $io)
    {
		$defaultAdminData = [
        	'first_name' 	=> "Admin",
        	'last_name' 	=> "Admin",
        	'password' 		=> "admin",
        	'email' 		=> "admin@admin.com",
        	'role' 			=> 1,
        	'status' 		=> 1
        ];

	    $this->createAdminstrator($defaultAdminData, $io);

	    $defaultCompanyData = [
        	'name'				=> "Company",
        	'address'			=> "Address",
        	'city'				=> "City",
        	'phone_number' 		=> "123456789",
        	'fax' 				=> '123456789',
        	'email' 			=> 'hello@company.com',
        	'web' 				=> 'company.com',
        	'contact_person'	=> 'John Doe',
        	'id_number' 		=> '123456789',
        	'tax_number' 		=> '987654321',
        	'lunch_break'		=> 30,
        	'start_working_time'=> '08:00',
        	'end_working_time'	=> '16:30'
        ];

	    $this->createCompany($defaultCompanyData, $io);
    }

    private function createAdminstrator($args = [], $io)
    {
    	$exists = $this->Administrators->exists(['email' => $args['email']]);

		if($exists == true)
		{
			$io->out("This value is already in use.");

			return false;
		}

        $administrator = $this->Administrators->newEntity();
        $administrator = $this->Administrators->patchEntity($administrator, $args);

        if(empty($administrator->getErrors())) 
	    {
	    	if($this->Administrators->save($administrator))
		    {
				$io->out("Administrator successfully created!");
		    } else {
				$io->out("Something went wrong, please try again!");
		    }	
	    } else {
	    	$io->out("Something went wrong. Check your inputs!");

			foreach ($administrator->getErrors() as $fieldName => $fieldErrors) 
			{
				foreach ($fieldErrors as $errorType => $message) 
				{
					$io->out($fieldName . ": <<" . $errorType . ">> " . $message);
				}
			}
	    }
    }

    private function createCompany($args = [], $io)
    {
		if($this->Companies->find()->count())
		{
			$io->out("Company already exist!");

			return false;
		}

        $company = $this->Companies->newEntity();
        $company = $this->Companies->patchEntity($company, $args);

        if(empty($company->getErrors())) 
	    {
	    	if($this->Companies->save($company))
		    {
				$io->out("Company successfully created!");
		    } else {
				$io->out("Something went wrong, please try again!");
		    }	
	    } else {
	    	$io->out("Something went wrong. Check your inputs!");

			foreach ($company->getErrors() as $fieldName => $fieldErrors) 
			{
				foreach ($fieldErrors as $errorType => $message) 
				{
					$io->out($fieldName . ": <<" . $errorType . ">> " . $message);
				}
			}
	    }
    }
}