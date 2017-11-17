<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product[]|\Cake\Collection\CollectionInterface $products
 */
?>
<div class="products index large-9 medium-8 columns content">
    <h3>Tuotteet</h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('name', 'Nimi') ?></th>
                <th scope="col"><?= $this->Paginator->sort('product_code', 'Tuotekoodi') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price', 'Hinta') ?></th>
                <th scope="col" class="actions">Toiminnot</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?= h($product->name) ?></td>
                <td><?= h($product->product_code) ?></td>
                <td><?= $this->Number->format($product->price) ?></td>

                <td class="actions">
                    <?= $this->Html->link('Näytä', [
                        'controller' => 'products',
                        'action' => 'view',
                        $product->id,
                        //'?' => ['height' => 400, 'width' => 500]
                    ]); ?>
                </td>
                <td><div class="col-lg-5 col-md-5">
                    <?= $this->Form->create('Cart',array('id'=>'add-form','url'=>array('controller'=>'cart','action'=>'add')));?>
                    <?= $this->Form->hidden('add_product_id',array('value'=>$product->id))?>
                    <?= $this->Form->submit('Koriin',array('class'=>'btn-success btn btn-lg'));?>
                    <?= $this->Form->end();?>
                </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . 'Alku') ?>
            <?= $this->Paginator->prev('< ' . 'Edell.') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('Seur.' . ' >') ?>
            <?= $this->Paginator->last('Viim.' . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Sivu {{page}}/{{pages}}, näytetään {{current}} tuotetta, {{count}} yhteensä')]) ?></p>
    </div>
</div>
