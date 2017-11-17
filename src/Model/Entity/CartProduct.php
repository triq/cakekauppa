<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class CartProduct extends Product
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

    public function getCount()
    {
        return $this->count;
    }

    public function getTotal() {
        return (float)$this->getCount() * $this->product['price'];
    }
}