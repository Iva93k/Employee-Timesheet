<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Mailer\Email;

/**
 * Administrators Controller
 *
 *
 * @method \App\Model\Entity\Administrator[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AdministratorsController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        
        $this->Auth->allow('forgotPassword');
        $this->Auth->allow('reset');

    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->set('title', __('List administrators'));

        $conditions = [];

        $query = $this->Administrators->find();

        $roleList = $this->Administrators->getRoles();
        
        $statusList = $this->Administrators->getStatuses();

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

            if(isset($queryParams['email']) && !empty($queryParams['email']))
                $conditions['email LIKE'] = '%' . $queryParams['email'] . '%';

            if(isset($queryParams['role']) && !empty($queryParams['role']))
                $conditions['role'] = $queryParams['role'];

            if(isset($queryParams['status']) && $queryParams['status'] != "")
                $conditions['status'] = $queryParams['status'];
        }
            
        $query->where($conditions);


        $administrators = $this->paginate($query);

        $this->set(compact('administrators', 'roleList', 'statusList'));
    }

    /**
     * View method
     *
     * @param string|null $id Administrator id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->set('title', __('View'));

        $administrator = $this->Administrators->get($id);

        $this->set('administrator', $administrator);
    }

    public function profile()
    {
        $this->set('title', __('Profile'));

        $authAdministrator = $this->Auth->user();
        
        $administrator = $this->Administrators->get($authAdministrator['id']);

        $this->set('administrator', $administrator);

    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->set('title', __('New administrator'));

        $roleList = $this->Administrators->getRoles();

        $administrator = $this->Administrators->newEntity();

        if ($this->request->is('post')) 
        {
            $administrator = $this->Administrators->patchEntity($administrator, $this->request->getData());
            if ($this->Administrators->save($administrator)) {
                $this->Flash->success(__('The administrator has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The administrator could not be saved. Please, try again.'));
           
        }

        $this->set(compact('administrator', 'roleList'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Administrator id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->set('title', __('Edit'));

        $roleList = $this->Administrators->getRoles();

        $administrator = $this->Administrators->get($id);
        unset($administrator->password);

        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $requestData = $this->request->getData();
            if(isset($requestData['password']) && $requestData['password'] == '')
                unset($requestData['password']);

            $administrator = $this->Administrators->patchEntity($administrator, $requestData);
            if ($this->Administrators->save($administrator)) 
            {
                $this->Flash->success(__('The administrator has been updated.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The administrator could not be saved. Please, try again.'));
        }

        $this->set(compact('administrator', 'roleList'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Administrator id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $authAdministrator = $this->Auth->user();

        $this->request->allowMethod(['post', 'delete']);

        $administrator = $this->Administrators->get($id);

        if($administrator['id'] == $authAdministrator['id'])
        {
            $this->Flash->error(__('User can not be deleted! This is currently logged user!'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->Administrators->delete($administrator)) {
            $this->Flash->success(__('The administrator has been deleted.'));
        } else {
            $this->Flash->error(__('The administrator could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login() 
    {
        $this->set('title', __('Login'));

        $this->viewBuilder()->setLayout('admin_login');

        if ($this->request->is('post')) 
        {
            $user = $this->Auth->identify();

            if ($user) 
            {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password.'));
        }
    }

    public function logout() 
    {
        return $this->redirect($this->Auth->logout());
    }

    public function forgotPassword() 
    {
        $this->set('title', __('Forgot password'));

        $this->viewBuilder()->setLayout('admin_login');

        /*$passkey = uniqid();

        $token = [
            'passkey'   => uniqid(),
            'timestamp' => time()
        ];

        $test = json_encode($token);

        $test2 = base64_encode($test);

        debug($token);
        debug($test);
        debug($test2);
        
        $json = base64_decode($test2);

        $array = json_decode($json);

        debug($json);
        debug($array);
        die();*/

        $passwordResetToken = [
            'passkey' => uniqid(),
            'timeout' => time() + DAY
        ];

        if ($this->request->is('post')) 
        {
            $query = $this->Administrators->findByEmail($this->request->getData(['email']));
            $administrator = $query->first();
            if (is_null($administrator)) {
                $this->Flash->error(__('Email address does not exist. Please try again'));
            } else {
                $url = Router::Url(['controller' => 'Administrators', 'action' => 'reset'], true) . '/' . base64_encode(json_encode($passwordResetToken));
                //$timeout = time() + DAY;
                if ($this->Administrators->updateAll(['password_reset_token' => base64_encode(json_encode($passwordResetToken))], ['id' => $administrator->id]))
                {
                    $this->sendResetEmail($url, $administrator);
                    $this->redirect(['action' => 'login']);
                } else {
                    $this->Flash->error(__('Error saving password reset token.'));
                }
            }
        }
    }

    private function sendResetEmail($url, $administrator) 
    {
        $email = new Email('default');
        $email->viewBuilder()->setTemplate('default');
        //$email->setEmailFormat('both');
        $email->setFrom('internship@example.com');
        $email->setTo($administrator->email, $administrator->full_name);
        $email->setSubject('Reset your password');
        $email->setViewVars(['url' => $url, 'username' => $administrator->email]);

        if ($email->send(/*"sta inas"*/)) {
            $this->Flash->success(__('Check your email for your reset password link'));
        } else {
            $this->Flash->error(__('Error sending email: ') . $email->smtpError);
        }
    }

    public function reset($passwordResetToken = null) 
    {    
        $this->set('title', __('Reset password'));

        $this->viewBuilder()->setLayout('admin_login');

        if(empty($passwordResetToken))
        {
            $this->Flash->error(__('Password reset token is empty!'));
            $this->redirect(['action' => 'forgotPassword']);
        }

        $decodePasswordResetToken = json_decode(base64_decode($passwordResetToken));

        if($decodePasswordResetToken->timeout < time())
        {
            $this->Flash->error(__('Invalid or expired passkey. Please check your email or try again'));
            $this->redirect(['action' => 'forgotPassword']);
        }

        $query = $this->Administrators->find('all', ['conditions' => ['password_reset_token' => $passwordResetToken]]);
        $administrator = $query->first();

        if(!$administrator)
        {
            $this->Flash->error(__('Invalid or expired passkey. Please check your email or try again'));
            $this->redirect(['action' => 'forgotPassword']);
        }
        
        if (!empty($this->request->getData())) 
        {
            // Clear passkey and timeout
            $administrator['password_reset_token'] = null;
            
            if($this->request->getData(['password']) != $this->request->getData(['confirm_password']))
            {
                $this->Flash->error(__('Please, confirm password!'));

                //return $this->redirect(['action' => 'reset']);
            } else {

                $administrator = $this->Administrators->patchEntity($administrator, $this->request->getData());

                if ($this->Administrators->save($administrator)) {
                    $this->Flash->success(__('Your password has been updated.'));
                    return $this->redirect(['action' => 'login']);
                } else {
                    $this->Flash->error(__('The password could not be updated. Please, try again.'));
                }
            }
        }

        unset($administrator->password);
        $this->set(compact('administrator'));
    }
}
