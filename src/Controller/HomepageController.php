<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class HomepageController extends AppController
{
	public function home()
	{
		$this->set('title', __('Home'));

		$companiesTable = TableRegistry::get('Companies');
		$employees = TableRegistry::get('Employees');
		$company = $companiesTable->find()->order(['id' => 'DESC'])->first();
		$countEmployees = $employees->find()->count();

		$this->set(compact('company', 'countEmployees'));
	}
}
