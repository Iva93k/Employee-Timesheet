<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Companies Controller
 *
 *
 * @method \App\Model\Entity\Company[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CompaniesController extends AppController
{
    /**
     * View method
     *
     * @param string|null $id Company id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view()
    {
        $this->set('title', __('View company'));

        if(!$this->Companies->find()->count())
            return $this->redirect(['action' => 'add']);

        $company = $this->Companies->find()->order(['id' => 'DESC'])->first();

        $this->set('company', $company);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->set('title', __('Add company'));

        if($this->Companies->find()->count())
            return $this->redirect(['action' => 'view']);

        $company = $this->Companies->newEntity();
        if ($this->request->is('post')) 
        {
            $requestData = $this->request->getData();

            if(isset($requestData['start_working_time']))
                $requestData['start_working_time'] = date('H:i', strtotime($this->request->getData('start_working_time')));

            if(isset($requestData['end_working_time']))
                $requestData['end_working_time'] = date('H:i', strtotime($this->request->getData('end_working_time')));

            $company = $this->Companies->patchEntity($company, $requestData);

            if ($this->Companies->save($company)) 
            {
                $this->Flash->success(__('The company has been saved.'));

                return $this->redirect(['action' => 'view']);
            }
            $this->Flash->error(__('The company could not be saved. Please, try again.'));
        }

        $this->set(compact('company'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Company id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit()
    {
        $this->set('title', __('Update'));

        if(!$this->Companies->find()->count())
            return $this->redirect(['action' => 'add']);

        $company = $this->Companies->find()->order(['id' => 'DESC'])->first();
        
        if ($this->request->is(['patch', 'post', 'put'])) {

            $requestData = $this->request->getData();

            if(isset($requestData['start_working_time']))
                $requestData['start_working_time'] = date('H:i', strtotime($this->request->getData('start_working_time')));

            if(isset($requestData['end_working_time']))
                $requestData['end_working_time'] = date('H:i', strtotime($this->request->getData('end_working_time')));

            $company = $this->Companies->patchEntity($company, $requestData);
            
            if ($this->Companies->save($company)) {
                $this->Flash->success(__('The company has been saved.'));

                return $this->redirect(['action' => 'view']);
            }
            $this->Flash->error(__('The company could not be saved. Please, try again.'));
        }

        if(!empty($company->start_working_time) && is_object($company->start_working_time))
            $company->start_working_time = $company->start_working_time->format('H:i');

        if(!empty($company->end_working_time) && is_object($company->end_working_time))
            $company->end_working_time = $company->end_working_time->format('H:i');

        $this->set(compact('company'));
    }
}
