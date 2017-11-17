<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Controller\Component\AuthComponent;
use \App\Auth\LegacyPasswordHasher;

class AdminsController extends AppController
{
    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['logout']);
    }

    /* Common login with authentication, post-form. */
    public function login() {
        if($this->request->is('post')) {
            $u = $_POST['name'];
            $p0 = $_POST['password'];


            $x = $this->loadModel('Admins');
            $q = $x->find('all')
                ->where(['Admins.name =' => $u]);
            $results = $q->all();
            $a1 = $results->first();

            $d = new DefaultPasswordHasher();
            $f = $d->check($p0, $a1->password);
            $admin = $this->Auth->identify();
            if($admin) {
                $this->Auth->setUser($admin);
                return $this->redirect($this->Auth->redirectUrl());
            }

            //User not identified
            $this->Flash->error('Salasana tai nimi väärin!');
        }
    }

    public function logout() {
        $this->Auth->logout();
        $this->Flash->success("Kirjautunut ulos.");
        return $this->redirect($this->Auth->logout());
    }
}
