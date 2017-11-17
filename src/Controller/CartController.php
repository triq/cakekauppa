<?php
/**
 * Created by PhpStorm.
 * User: Käyttäjä
 * Date: 1.11.2017
 * Time: 15:23
 */


namespace App\Controller;

use Cake\ORM\TableRegistry;
use Controller\Component\CartProductComponent;
use App\Model\Entity\CartProduct;
use App\Controller\AppController;


class CartController extends AppController
{
    public $uses = array('Product','Cart');

    // In your controller.
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('CartProduct');
    }

    public function add() {
        $session = $this->request->session();

        $this->autoRender = false;
        $productId = null;
        if ($this->request->is('post')) {
            // An input with a name attribute equal to 'MyModel[title]' is accessible at
            $productId = $this->request->getData('add_product_id');
        }

        $cart_tag = 'Cart1.product_id';
        if($productId == null) {
            $productId = -1;
            $this->Flash->error('Tuotteen lisäys epäonnistui! (ei tuotekoodia)');
        } else {
            $session = $this->request->session();
            $this->Cart->addProduct($productId, $session);
            $this->Flash->success('Tuotteen lisäys onnistui.');
        }

        $prods = $session->read($cart_tag);
        if($prods == null) {
            $prods = array();
        }
        if(array_key_exists($productId,$prods)) {
            $prods[$productId]++;
        } else {
            $prods[$productId] = 1;
        }
        $session->write($cart_tag, $prods);

       $this->redirect('/');
    }

    public function view() {
        $this->Products = TableRegistry::get('Products');

        $session = $this->request->session();
        $carts = $this->Cart->readProducts($session);
        $products = array();
        if (null!=$carts) {
            foreach ($carts as $productId => $count) {
                $p1 = $this->Products->findById($productId);
                $product = $p1->first();
                if($product != null) {
                    $cp = new CartProduct($product->toArray());
                    $cp->setProduct($product);
                    $cp->setCount($count);
                    $products[] = $cp;
                }
            }
        }
        $this->set('products', $products);
    }

    public function update() {
        if ($this->request->is('post')) {
            if (!empty($this->request->data)) {
                $cart = array();
                $cart1 = $this->request->data['Cart']['update'];
                $column_id = array_column($cart1, 'product_id');
                $column_count = array_column($cart1, 'count');
                for ($i = 0; $i < count($column_count); $i++) {
                    $cc = $column_count[$i];
                    var_dump('index-x: '. $i);
                    $count = $cc;
                    if ($count>=0) {
                        $productId = $column_id[$i];
                        $cart[$productId] = $count;
                    }
                }
                $session = $this->request->session();
                $this->Cart->updateCart($session, $cart1);
            }
        }

        $this->autoRender = false;

        $this->redirect(array('action'=>'view'));
    }

    public function deleteCart() {
        $this->Cart->deleteCart($this->request->session());
        $this->redirect(array('action'=>'view'));
    }

    public function destroySession() {
        $session = $this->request->session();
        $session->delete('Cart');
        $session->delete('Cart1');
        $this->redirect('/');
    }

}
