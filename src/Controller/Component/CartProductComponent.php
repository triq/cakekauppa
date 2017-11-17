<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

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