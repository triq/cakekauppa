<?php
/**
 * Created by PhpStorm.
 * User: Käyttäjä
 * Date: 1.11.2017
 * Time: 15:23
 */

namespace App\Controller;

use Cake\ORM\TableRegistry;
//debug purpose
use Cake\I18n\Time;


class CartController extends AppController
{
    public $uses = array('Product','Cart');

    public function add() {
        var_dump('__session: ');
        var_dump($_SESSION);

        $productId = $this->request->session()->read('Cart.product_id');
        if($productId == null) {
            $productId = -1;
        }

        $this->autoRender = false;
        $session = $this->request->session();
        $time = Time::now();
        $cart_tag = 'test.time';
        $count = count($session->read($cart_tag));
        $session->write($cart_tag .'.', $time);
        if ($this->request->is('post')) {
            $this->Cart->addProduct($productId, $session);
        }
        echo $this->Cart->getCount($session);
    }

    public function view() {
        $this->Products = TableRegistry::get('Products');

        $session = $this->request->session();
        $carts = $this->Cart->readProduct($session);
        $products = array();
        if (null!=$carts) {
            var_dump('carts, _session: ');
            var_dump($carts);
            var_dump($_SESSION);
            var_dump('prodcut-id: '. (int)$session->read('productId'));
            foreach ($carts as $productId => $count) {
                //$users = $this->paginate($this->Users);
                var_dump('prodId: '. $productId);
                $p1 = $this->Products->get($productId);
                $p = $this->paginate($this->Products);
                $product = $p->get($productId);
                $product['Product']['count'] = $count;
                $products[]=$product;
            }
        }
        $this->set(compact('products'));
    }

    public function update() {
        if ($this->request->is('post')) {
            if (!empty($this->request->data)) {
                $cart = array();
                foreach ($this->request->data['Cart']['count'] as $index=>$count) {
                    if ($count>0) {
                        $productId = $this->request->data['Cart']['product_id'][$index];
                        $cart[$productId] = $count;
                    }
                }
                $this->Cart->saveProduct($cart);
            }
        }
        $this->redirect(array('action'=>'view'));
    }
}
