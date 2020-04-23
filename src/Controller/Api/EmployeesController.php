<?php
namespace App\Controller\Api;

use App\Controller\Api\ApiController;
use Cake\Mailer\Email;
use Cake\Event\Event;

class EmployeesController extends ApiController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        
        $this->Auth->allow('forgotPassword');
    }

    public function profile()
    {
        $authEmployee = $this->Auth->user();
        $employee = $this->Employees->get($authEmployee['id']);
        //$employee = $employee->toArray();
        $employee['gender'] = $employee->getGenderName();
        //set photo
        $employee['photos'] = [
            'small' => $employee->getPhotoFullPath(),
            'medium'=> $employee->getPhotoFullPath('medium')
        ];

        unset($employee['password']);
        unset($employee['allow_uid_access']);
        unset($employee['status']);
        unset($employee['created']);
        unset($employee['modified']);
        unset($employee['photo_name']);
        unset($employee['photo_path']);

        $this->set([
            'data'      => $employee,
            //'message'   => __d("api", "OK"),
            'message'   => "OK",
            '_serialize'=> ['message', 'data']
        ]);
    }

    public function update()
    {
        //check request method
        if(!$this->checkRequestMethod(['post', 'put']))
            return $this->response->withType('application/json')
                ->withStatus(400)
                ->withStringBody(json_encode(['message' => __d("api", "Method is not supported!"), 'data' => []]));

        $authEmployee = $this->Auth->user();   
        $employee = $this->Employees->get($authEmployee['id']);

        $responseData = [
            'message'   => 'OK',
            'data'      => $employee,
            '_serialize'=> ['message', 'data']
        ];

        $requestData = $this->request->getData();
        
        if(isset($requestData['allow_uid_access']))
            unset($requestData['allow_uid_access']);

        if(isset($requestData['status']))
            unset($requestData['status']);

        if(isset($requestData['contract_date']))
            unset($requestData['contract_date']);

        if(isset($requestData['uid']))
            unset($requestData['uid']);

        $employee = $this->Employees->patchEntity($employee, $requestData);

        if ($this->Employees->save($employee)) 
        {
            $responseData['message'] = __d("api", "Profile successefully updated!");
        } else {
            $this->response = $this->response->withStatus(400);
            $responseData['message'] = __d("api", "Please check your input data!");
            $responseData['error']  = $employee->getErrors();
            $responseData['_serialize']  = ['message', 'data', 'error'];
        }

        $employee['gender'] = $employee->getGenderName();

        $employee = $employee->toArray();
        unset($employee['password']);
        unset($employee['allow_uid_access']);
        unset($employee['status']);
        unset($employee['created']);
        unset($employee['modified']);

        $responseData['data'] = $employee;

        $this->set($responseData);
    }

    public function logout()
    {
        $this->Auth->logout();

        $message = __d('api', 'You have been successefully logout');

        return $this->response->withType('application/json')->withStatus(200)->withStringBody(json_encode(['message' => $message, 'data' => []]));
    }

    public function forgotPassword()
    {
        //check request method
        if(!$this->checkRequestMethod(['post', 'put']))
            return $this->response->withType('application/json')
                ->withStatus(400)
                ->withStringBody(json_encode(['message' => __d("api", 'Method is not supported!'), 'data' => []]));

        $query = $this->Employees->findByEmail($this->request->getData(['email']));
        $employee = $query->where(['status' => true])->first();

        $responseData = [
            'message'   => 'OK',
            'data'      => [],
            '_serialize'=> ['message', 'data']
        ];
        
        if (is_null($employee))
        {
            return $this->response->withType('application/json')
                ->withStatus(400)
                ->withStringBody(json_encode(['message' => __d("api", "Email address does not exist, or employee with this email address is inactive. Please, try again!"), 'data' => $responseData['data']]));
        } else {

            $password = $this->Employees::randomPassword();
            $employee->password = $password;

            if ($this->Employees->save($employee))
            {
                $email = new Email('default');
                $email->setFrom('internship@example.com');
                $email->setTo($employee->email, $employee->full_name);
                $email->setSubject(__d("api", 'Password reset'));

                if ($email->send(__d("api", 'Hi {0}. Your new password is: {1}', [$employee->full_name, $password])))
                    $responseData['message'] = __d("api", 'New password has been sent to the given email!');
                else 

                    return $this->response->withType('application/json')
                        ->withStatus(400)
                        ->withStringBody(json_encode(['message' => __d("api", 'Error sending email: ' . $email->smtpError)]));    
            } else {

                return $this->response->withType('application/json')
                        ->withStatus(400)
                        ->withStringBody(json_encode(['message' => __d("api", 'Error resetting password! Please, try again!')]));
            }
        }

        $this->set($responseData);
    }


}