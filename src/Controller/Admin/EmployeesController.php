<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Filesystem\Folder;
use Cake\ORM\TableRegistry;

/**
 * Employees Controller
 *
 *
 * @method \App\Model\Entity\Employee[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmployeesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->set('title', __('List employees'));

        $conditions = [];

        $query = $this->Employees->find();

        $statusList = $this->Employees->getStatuses();

        $queryParams = $this->request->getQueryParams();

        if(!empty($queryParams))
        {
            if(isset($queryParams['id']) && !empty($queryParams['id'])){
                $conditions['id'] = $queryParams['id'];
            }

            if(isset($queryParams['name']) && !empty($queryParams['name']))
            {
                $conditions['OR'] = [
                    'first_name LIKE'   =>  '%' . $queryParams['name'] . '%',
                    'last_name LIKE'    =>  '%' . $queryParams['name'] . '%'
                ];
            }

            if(isset($queryParams['title']) && !empty($queryParams['title']))
                $conditions['title LIKE'] = '%' . $queryParams['title'] . '%';

            if(isset($queryParams['email']) && !empty($queryParams['email']))
                $conditions['email LIKE'] = '%' . $queryParams['email'] . '%';

            if(isset($queryParams['status']) && $queryParams['status'] != "")
                $conditions['status'] = $queryParams['status'];
        }
            
        $query->where($conditions);

        $employees = $this->paginate($query);

        $this->set(compact('employees', 'statusList'));
    }

    /**
     * View method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->set('title', __('View'));

        $employee = $this->Employees->get($id, [
            'contain' => []
        ]);

        $this->set('employee', $employee);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->set('title', __('New employee'));

        $genderList = $this->Employees->getGender();

        $employee = $this->Employees->newEntity();
        if ($this->request->is('post')) 
        {
            $requestData = $this->request->getData();

            if(isset($requestData['birthdate']))
                $requestData['birthdate'] = date('Y-m-d', strtotime($this->request->getData('birthdate')));

            if(isset($requestData['contract_date']))
                $requestData['contract_date'] = date('Y-m-d', strtotime($this->request->getData('contract_date')));
            
            /*if(!empty($requestData['file']['name']))
            {
                $fileName = $requestData['file']['name'];
                $uploadPath = 'uploads/files/';
                $uploadFile = $uploadPath . $fileName;

                if(move_uploaded_file($requestData['file']['tmp_name'] ,$uploadFile))
                {
                    $employee->photo_name = $fileName;
                    $employee->photo_path = $uploadPath;
                }
            }*/
            
            $employee = $this->Employees->patchEntity($employee, $requestData);

            if ($this->Employees->save($employee)) 
            {
                $this->Flash->success(__('The employee has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The employee could not be saved. Please, try again.'));
        }
        $this->set(compact('employee', 'genderList'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->set('title', __('Edit'));

        $genderList = $this->Employees->getGender();

        $employee = $this->Employees->get($id);
        unset($employee->password);

        if ($this->request->is(['patch', 'post', 'put'])) 
        {    
            $requestData = $this->request->getData();

            if(isset($requestData['password']) && $requestData['password'] == '')
                unset($requestData['password']);

            if(isset($requestData['birthdate']))
                $requestData['birthdate'] = date('Y-m-d', strtotime($this->request->getData('birthdate')));

            if(isset($requestData['contract_date']))
                $requestData['contract_date'] = date('Y-m-d', strtotime($this->request->getData('contract_date')));
            
            /*if(!empty($requestData['file']['name']))
            {
                $fileName = $requestData['file']['name'];
                $uploadPath = 'uploads/files/';
                $uploadFile = $uploadPath . $fileName;

                if(move_uploaded_file($requestData['file']['tmp_name'] ,$uploadFile))
                {
                    $employee->photo_name = $fileName;
                    $employee->photo_path = $uploadPath;
                }
            }*/
            
            $employee = $this->Employees->patchEntity($employee, $requestData);
            
            if ($this->Employees->save($employee)) {
                $this->Flash->success(__('The employee has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee could not be saved. Please, try again.'));
        }
        $this->set(compact('employee', 'genderList'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $employee = $this->Employees->get($id);

        $workDayLogsTable = TableRegistry::get('WorkDayLogs');
        $workDayLog = $workDayLogsTable->find()->where(['employee_id' => $id])->first();

        if($workDayLog)
        {
            $this->Flash->error(__('Employee could not be deleted because it is related to work day logs. Please, try again.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->Employees->delete($employee)) {
            $this->Flash->success(__('The employee has been deleted.'));
        } else {
            $this->Flash->error(__('The employee could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
