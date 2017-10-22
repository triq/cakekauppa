<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Controller\Component\AuthComponent;

class AdminsController extends AppController
{

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

    public function add()
    {
        $admin = $this->Admins->newEntity();
        if ($this->request->is('post')) {
            $admin = $this->Admins->patchEntity($admin, $this->request->getData());
            if ($this->Admins->save($admin)) {
                $this->Flash->success(__('The admin-user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The admin-user could not be saved. Please, try again.'));
        }
        $this->set(compact('admin'));
        $this->set('_serialize', ['admin']);
    }

    public function edit($id = null)
    {
        $admin = $this->Admins->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $admin = $this->Admins->patchEntity($admin, $this->request->getData());
            if ($this->Admins->save($admin)) {
                $this->Flash->success(__('The admin-user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The admin-user could not be saved. Please, try again.'));
        }
        $this->set(compact('admin'));
        $this->set('_serialize', ['admin']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $admin = $this->Admins->get($id);
        if ($this->Admins->delete($admin)) {
            $this->Flash->success(__('The admin-user has been deleted.'));
        } else {
            $this->Flash->error(__('The admin-user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /* Common login with authentication, post-form. */
    public function login() {
        if($this->request->is('post')) {
            $admin = $this->Auth->identify();
            if($admin) {
                $this->Auth->setAdmin($admin);
                return $this->redirect($this->Auth->redirectUrl());
            }

            //User not identified
            $this->Flash->error('Your username or password is incorrect');
        }
    }

    public function logout() {
        $this->Flash->success("You are now logged out.");
        return $this->redirect($this->Auth->logout());
    }
}
