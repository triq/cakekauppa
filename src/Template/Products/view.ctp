<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <p class="heading">Linkit</p>
        <li><?= $this->Html->link('Tuotelistaus', ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link('Aloitussivu', '/') ?> </li>
    </ul>
</nav>
<div class="products view large-9 medium-8 columns content">
    <h3><?= h($product->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= 'Tuote ' ?></th>
            <td><?= h($product->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tuotekoodi') ?></th>
            <td><?= h($product->product_code) ?></td>
        </tr>
        <tr>
            <th scope="row">Hinta</th>
            <td><?= $this->Number->format($product->price) ?></td>
        </tr>
    </table>
</div>
<div class="row">
    <div class="col-lg-4 col-md-4">
        <?php echo $this->Html->image($product->image,array('class'=>'thumbnail'));?>
    </div>

    <div class="col-lg-5 col-md-5">
        <p>
            <?= $this->Form->create('Cart',array('id'=>'add-form','url'=>array('controller'=>'cart','action'=>'add')));?>
            <?= $this->Form->hidden('add_product_id',array('value'=>$product->id))?>
            <?= $this->Form->submit('Lisää koriin',array('class'=>'btn-success btn btn-lg'));?>
            <?= $this->Form->end();?>
        </p>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#add-form').submit(function(e){
        e.preventDefault();
        var tis = $(this);
        $.post(tis.attr('action'),tis.serialize(),function(data){
            $('#cart-counter').text(data);
        });
    });
});
</script>

