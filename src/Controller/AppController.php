<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\I18n\Time;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public $uses = array('Cart');

    /**
     * Initialization hook method.
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authenticate' => [
            'Form' => [
                'fields' => [
                'username' => 'name',
                'password' => 'password'
                ]
            ]
        ],
        'loginAction' => [
            'controller' => 'Admins',
            'action' => 'login'
            ]
        ]);

        // Allow all actions
        $this->Auth->allow();
        /*
        $this->Auth->allow(
            ['controller' => 'pages', 'action' => 'display', 'home'],
            ['controller' => 'products' ],
            ['url' => '/']
        );
        */
        $this->Auth->deny(
            ['controller' => 'admin'],
            ['controller' => 'products', 'action' => 'edit', 'add']
        );
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Http\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        // Note: These defaults are just to get started quickly with development
        // and should not be used in production. You should instead set "_serialize"
        // in each action as required.
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    public function beforeFilter(\Cake\Event\Event $event) {
        parent::beforeFilter($event);
        //$this->loadModel('Cart');

        $session = $this->request->session();

        $session->write('Cart.gvalue','testi');
        $session->write('Config.language', 'en');

        var_dump("session: ");
        //var_dump($session);
        var_dump($session->read('Config'));
        $count = 0;
        //$count = $this->Cart->getCount($session);
        $this->set('count', $count);
        //$this->set('count',0);

        var_dump('__Session: ');
        //var_dump($_SESSION);
        $data1 = array();
        $data1 = $session->read('test.time.');
        $t = Time::now();
        array_push($data1, $t);
        //add new time item
        $session->write('test.time.', $data1);

        print_r('test.time.: '. join(',', $session->read('test.time.')) .", count=". (int)count($session->read('test.time.')));

    }

}
