<?php
/**
 * Created by PhpStorm.
 * User: Käyttäjä
 * Date: 1.11.2017
 * Time: 15:38
 */
namespace App\Model\Table;

use \Cake\ORM\Table;
use \Cake\Network\Session;

class CartTable extends Table
{
    public $useTable = false;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
    }

    /*
     * add a product to cart
     */
    public function addProduct($productId, \Cake\Network\Session $session) {
        $allProducts = $this->readProducts($session);
        $this->createCart($session);
        //create cart, it doesnt exist
        if($allProducts == null) {

        }
        if($productId <= 0) {
            die('productId on 0! _'. (int)$productId ."_");
        }

      $amount = -100;
        if (null!=$allProducts) {
            var_dump('prodID: '. $productId);
            if (array_key_exists($productId, $allProducts)) {
                $amount = 1;
                if (is_array($allProducts[$productId])) {
                    $amount = $allProducts[$productId];
                    if ($amount > 0) {
                        $amount++;
                    }
                } else {
                    $amount = 1;
                }
            } else {
                $amount = 1;
            }
        }
        $allProducts[$productId] = $amount;

        $this->saveProduct($session, $allProducts);
    }

    /*
     * get total count of products
     */
    public function getCount($session) {
        $allProducts = $this->readProducts($session);

        $count = 0;
        if (empty($allProducts)) {
            return 0;
        }
        foreach ($allProducts as $product => $value) {
            //new product
            if(is_numeric($product)) {
                if(is_numeric($value)) {
                    $count++;
                }
            }
        }

        return $count;
    }

    /*
     * save data to session
     */
    public function saveProduct($session, $data) {
        return $session->write('Cart1.product_id',$data);
    }

    /*
     * read cart data from session
     */
    public function readProducts($session) {
        return $session->read('Cart1.product_id');
    }

    public function updateCart($session, $new_data) {
        $old_data = $this->readProducts($session);
        $x = $old_data;

        foreach ($new_data['product_id'] as $index => $key_val) {
            //get from column product_id value id and find same product id from olddata array -> our item
            $y=$x[$key_val];
            if($y) {
                //update olddata array item with count integer
                $x[$key_val]=$new_data['count'][$index];
            }

        };
        $this->saveProduct($session, $x);
        $old_data = $this->readProducts($session);
        $x = $old_data;
    }

    //delete all cart items
    public function deleteCart($session) {
        $this->saveProduct($session, []);
    }

    public function createCart($session) {
        $session->write('Cart',[0]);
        $session->write('Cart.products', 1);
        $session->write('Cart.products', 2);
        $session->write('Cart.products', 3);
    }

}