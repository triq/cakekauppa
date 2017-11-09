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
        $allProducts = $this->readProduct($session);
        if($productId <= 0) {
            die('productId on 0! _'. (int)$productId ."_");
        }

        if (null!=$allProducts) {
            var_dump('prodID: '. $productId);
            if (array_key_exists($productId, $allProducts)) {
                $allProducts[$productId]++;
            } else {
                $allProducts->write('productId', 1);
            }
        } else {
            $allProducts[$productId] = 1;
        }

        $this->saveProduct($allProducts, $session);
    }

    /*
     * get total count of products
     */
    public function getCount($session) {
        $allProducts = $this->readProduct($session);

        if (count($allProducts)<1) {
            return 0;
        }

        $count = 0;
        foreach ($allProducts as $product) {
            $count=$count+$product;
        }

        return $count;
    }

    /*
     * save data to session
     */
    public function saveProduct($data, $session) {
        return $session->write('Cart',$data);
    }

    /*
     * read cart data from session
     */
    public function readProduct($session) {
        return $session->read('Cart');
    }

}