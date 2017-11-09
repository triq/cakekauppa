<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Controller\Component\AuthComponent;

class AdminsController extends AppController
{
    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['logout']);
    }

    public function initialize() {
        parent::initialize();
        $loginRedirect = '/products/';
        $this->Auth->config('loginRedirect', $loginRedirect);
        $this->Auth->config('authenticate', [
            AuthComponent::ALL => ['userModel' => 'Admins', 'passwordHasher' => 'Default'],
            'Basic',
            'Form'
        ]);
    }

    /* Common login with authentication, post-form. */
    public function login() {
        if($this->request->is('post')) {
            $admin = $this->Auth->identify();
            if($admin) {
                var_dump($admin);
                $this->Auth->setAdmin($admin);
                return $this->redirect($this->Auth->redirectUrl());
            }

            //User not identified
            $this->Flash->error('Salasana tai nimi väärin!');
        }
    }

    public function logout() {
        $this->Flash->success("Kirjautunut ulos.");
        return $this->redirect($this->Auth->logout());
    }
}
