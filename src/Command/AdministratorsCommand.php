<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\ORM\TableRegistry;

class AdministratorsCommand extends Command
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Administrators');
    }

    protected function buildOptionParser(ConsoleOptionParser $parser)
    {
        $parser
            ->addArgument('first_name', [
                'help' => 'What is your name', 'required' => true
            ])
            ->addArgument('last_name', [
                'help' => 'What is your last name', 'required' => true
            ])
            ->addArgument('password', ['required' => true])
            ->addArgument('email', ['required' => true])
			->addArgument('role')
			->addArgument('status');

        return $parser;
    }

    public function execute(Arguments $args, ConsoleIo $io)
    {
    	$role = 1;
    	if($args->getArgument('role') != null)
    		$role = (int)$args->getArgument('role');

    	$status = 1;
    	if($args->getArgument('status') != null)
    		$status = (int)$args->getArgument('status');
    	
    	$data = [
        	'first_name'=> $args->getArgument('first_name'),
        	'last_name' => $args->getArgument('last_name'),
        	'password' 	=> $args->getArgument('password'),
        	'email' 	=> $args->getArgument('email'),
        	'role' 		=> $role,
        	'status' 	=> $status
	    ];

    	$exists = $this->Administrators->exists(['email' => $args->getArgument('email')]);

    	if($exists == true)
			$io->out("This value is already in use.");

		$administrator = $this->Administrators->newEntity();
	    $administrator = $this->Administrators->patchEntity($administrator, $data);

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
}

   