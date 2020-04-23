<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * WorkDayTypes Controller
 *
 *
 * @method \App\Model\Entity\WorkDayType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WorkDayTypesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->set('title', __('List work day types'));

        $workDayTypes = $this->paginate($this->WorkDayTypes);

        $this->set(compact('workDayTypes'));

    }

    /**
     * View method
     *
     * @param string|null $id Work Day Type id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->set('title', __('View'));

        $workDayType = $this->WorkDayTypes->get($id);

        $this->set('workDayType', $workDayType);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->set('title', __('Add'));

        $workDayType = $this->WorkDayTypes->newEntity();

        $requestData = $this->request->getData();

        if ($this->request->is('post')) 
        {
            $workDayType = $this->WorkDayTypes->patchEntity($workDayType, $requestData);

            //set default value
            if(empty($requestData['is_default']))
                $workDayType->is_default = false;

            $workDayTypeDefault = $this->WorkDayTypes->find()
                ->where(['is_default' => true])
                ->first();

            if(!$workDayTypeDefault)
                $workDayType->is_default = true;

            if(!empty($requestData['is_default']))
            {
                $query = $this->WorkDayTypes->query();
                $query->update()
                    ->set(['is_default' => false])
                    ->where(['id' => $workDayTypeDefault['id']])
                    ->execute();
                            
                $workDayType->is_default = true;
            }

            if(empty($requestData['is_weekend']))
                $workDayType->is_weekend = false;

            $workDayTypeWeekend = $this->WorkDayTypes->find()
                ->where(['is_weekend' => true])
                ->first();

            if(!empty($requestData['is_weekend']))
            {
                $query = $this->WorkDayTypes->query();
                $query->update()
                    ->set(['is_weekend' => false, 'weekend_days' => ''])
                    ->where(['id' => $workDayTypeWeekend['id']])
                    ->execute();
                            
                $workDayType->is_weekend = true;
            }

            if(isset($requestData['weekend_days']) && !empty($requestData['weekend_days']))
                $workDayType->weekend_days = json_encode($requestData['weekend_days']);

            if ($this->WorkDayTypes->save($workDayType)) 
            {
                $this->Flash->success(__('The work day type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The work day type could not be saved. Please, try again.'));
        }

        $this->set(compact('workDayType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Work Day Type id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->set('title', __('Edit'));

        $requestData = $this->request->getData();
        
        $workDayType = $this->WorkDayTypes->get($id);

        $weekendDays = $workDayType->getWeekendDays();

        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $workDayType = $this->WorkDayTypes->patchEntity($workDayType, $requestData);

            $workDayTypeWeekend = $this->WorkDayTypes->find()
                ->where(['is_weekend' => true])
                ->first();

            if(!empty($requestData['is_weekend']))
            {
                $query = $this->WorkDayTypes->query();
                $query->update()
                    ->set(['is_weekend' => false, 'weekend_days' => ''])
                    ->where(['id' => $workDayTypeWeekend['id']])
                    ->execute();
                            
                $workDayType->is_weekend = true;
            }

            if(isset($requestData['weekend_days']) && !empty($requestData['weekend_days']))
            {
                $workDayType->weekend_days = json_encode($requestData['weekend_days']);
            }
            
            if ($this->WorkDayTypes->save($workDayType)) {
                $this->Flash->success(__('The work day type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The work day type could not be saved. Please, try again.'));
        }

        $this->set(compact('workDayType', 'weekendDays'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Work Day Type id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $workDayType = $this->WorkDayTypes->get($id);

        $workDayLogsTable = TableRegistry::get('WorkDayLogs');
        $workDayLog = $workDayLogsTable->find()->where(['work_day_type_id' => $id])->first();

        if($workDayType->is_default)
        {
            $this->Flash->error(__('The work day type could not be deleted!'));
            return $this->redirect(['action' => 'index']);
        }

        if($workDayLog)
        {
            $this->Flash->error(__('The work day type could not be deleted because it is related to work day logs. Please, try again.'));
            return $this->redirect(['action' => 'index']);
        }
            
        if ($this->WorkDayTypes->delete($workDayType)) {
            $this->Flash->success(__('The work day type has been deleted.'));
        } else {
            $this->Flash->error(__('The work day type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function setDefault($id = null)
    {
        $workDayType = $this->WorkDayTypes->get($id);
        $workDayType->is_default = true;
        
        if ($this->WorkDayTypes->save($workDayType))
        {
            $query = $this->WorkDayTypes->query();
            $query->update()
                ->set(['is_default' => false])
                ->where(['id !=' => $id])
                ->execute();

            $this->Flash->success(__('The work day type has been set as default.')); 
        } else {
            $this->Flash->error(__('The work day type could not be set as default. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
