<?php
/**
 * Created by PhpStorm.
 * User: Käyttäjä
 * Date: 9.11.2017
 * Time: 15:58
 */

namespace App\Model\Table;


class CartProductTable extends ProductsTable
{

class CartProductComponent extends Component
{
    private $product = null;
    private $count = -100;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function setProduct($product = null)    {
        $this->product = $product;
    }

    public function setCount($count)
    {
        $this->count = $count;
    }

    public function getTotal() {
        return $count*$product['price'];
    }
}
}