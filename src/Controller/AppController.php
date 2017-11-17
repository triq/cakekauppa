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
use Cake\Controller\Component\AuthComponent;
use function MongoDB\BSON\toJSON;


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
        $loginRedirect = '/products/add';

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'name',
                        'password' => 'password'
                    ],
                    'passwordHasher' => [
                        'className' => 'Default',
                    ],
                    'userModel' => 'Admins',
                ],
            ],
            'loginAction' => [
                'controller' => 'Admins',
                'action' => 'login'
            ],

            'loginRedirect' => $loginRedirect
        ]);

        // Allow all actions
        $this->Auth->allow();
        $this->Auth->deny(
            ['controller' => 'admin'],
            ['controller' => 'products',
                'action' => 'edit'],
            ['controller' => 'products',
                    'action' => 'add'
            ]
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

        $session = $this->request->session();
        $session->write('Config.language', 'en');

        $this->loadModel('Cart');
        $cart_product_count = $this->Cart->getCount($session);
        $this->set('cart_product_count', $cart_product_count);

        //USER LOGGED IN:
        $logged_user = $this->Auth->user();
        if($logged_user != null) {
            $logged_user = $logged_user['name'];
        }
        $this->set('logged_user', $logged_user);
        $this->set('session_u', $session->id());
        $this->set('cart_data', $session->read('Cart'));
        $this->set('cart_data1', $session->read('Cart1'));

        $g = $session->read('Cart');

        $this->set('logged_user', $logged_user);
    }

}
