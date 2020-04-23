<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\I18n\FrozenTime;
use Cake\I18n\FrozenDate;

/**
 * Application Controller
 */
class AppController extends Controller
{
    protected $appConfData = null;
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');

        FrozenTime::setJsonEncodeFormat('HH:mm');
        FrozenDate::setJsonEncodeFormat('dd.MM.yyyy');
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->appConfData = Configure::read('AppConf');
        $this->set('appConfData', $this->appConfData);
        
        if ($this->request->getParam('prefix') == 'admin') 
        {
            $this->viewBuilder()->setLayout('admin');
            
            $this->loadComponent('Auth', [
                'authenticate' => [
                    'Form' => [
                        'userModel' => 'Administrators',
                        'fields' => [
                            'username'  => 'email',
                            'password'  => 'password'
                        ]
                    ],
                ],
                'loginAction' => [
                    'controller'    => 'Administrators',
                    'action'        => 'login'
                ],
                'loginRedirect' => [
                    'controller'    => 'Dashboard',
                    'action'        => 'index'
                ],
                'logoutRedirect' => [
                    'controller'    => 'Administrators',
                    'action'        => 'login',
                ],
                'storage' => [
                    'className'     => 'Session',
                    'key'           => 'Auth.Admin',               
                ],
                'unauthorizedRedirect' => $this->referer(),
                //'unauthorizedRedirect' => false,
                'authorize' => ['Controller'],
            ]);
            
            $this->set('authUserData', $this->Auth->user());
        }
        else if ($this->request->getParam('prefix') == 'api') 
        {
            $this->viewBuilder()->setLayout('ajax');

            $this->loadComponent('Auth', [
                'authenticate' => [
                    'Basic' => [
                        'fields'    => ['username' => 'email', 'password' => 'password'],
                        'userModel' => 'Employees'
                    ],
                ],
                'storage'               => 'Memory',
                'unauthorizedRedirect'  => false,
                'authorize' => ['Controller']
            ]);
        }
        else
        {
            $this->viewBuilder()->setLayout('home_layout');
        }
    }

    /*public function beforeRender(\Cake\Event\Event $event) 
    {
            
    }*/

    public function isAuthorized($user = null)
    {
        //Any registered user can accesss public functions
        if(empty($this->request->getParam('prefix')))
        {
            return true;
        }
        
        //Only admins can access admin functions
        if($this->request->getParam('prefix') === 'admin')
        {
            if($user['status'] != 1)
                return false;

            if($this->request->getParam('action') == 'logout')
                return true;

            switch ($user['role']) {
                case 1:
                    return true;
                    break;
                
                case 2:
                    if($this->request->getParam('action') == 'delete') {
                        return false;
                    } else {
                        return true;
                    }
                    break;

                case 3:
                    if($this->request->getParam('controller') == 'Administrators' && $this->request->getParam('action') != 'profile')
                    {
                        return false;
                    } 
                    elseif($this->request->getParam('action') == 'delete' || $this->request->getParam('action') == 'edit')
                    {
                        return false;
                    }

                    return true;                   
                    break;

                default:
                    return false;
                    break;
            }
            /*
            if($user['status'] != 1)
                return false;

            if(Router::getRequest()->getParam('action') == 'logout')
                return true;
              
            if($user['role'] == 1)
            {
                return true;
            }
            elseif ($user['role'] == 2)
            {
                if(Router::getRequest()->getParam('action') == 'delete')
                {
                    return false;
                }

                return true;
            }
            elseif ($user['role'] == 3)
            {
                if(Router::getRequest()->getParam('controller') == 'Administrators' && Router::getRequest()->getParam('action') != 'profile')
                {
                    return false;
                } 
                elseif(Router::getRequest()->getParam('action') == 'delete' || Router::getRequest()->getParam('action') == 'edit')
                {
                    return false;
                }

                return true;                    
            }*/          
        }

        //Only API can access API endpoints functions
        if($this->request->getParam('prefix') === 'api')
        {
            if($user['status'] != 1)
                return false;

            /*
            if($user['uid'] == UID from header request)
            {
                return false;
            }
            also, check if update uid is enabled, please store one from header request
            also, uid in header request should be presented!
            */

            return true;
        }


        
        //Default deny
        return false;
    }
}
