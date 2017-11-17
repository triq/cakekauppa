<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><?php echo $this->Html->link('Home','/');?>
            </li>
            <li class="active">Cart</li>
        </ol>
    </div>
</div>

<?php echo $this->Form->create('Cart',array('url'=>array('action'=>'update')));?>
<div class="row">
    <div class="col-lg-12">
        <table class="table">
            <thead>
            <tr>
                <th>Nimi</th>
                <th>Hinta</th>
                <th>Määrä</th>
                <th>Yhteensä</th>
            </tr>
            </thead>
            <tbody>
            <?php $total=0;?>
            <?php foreach ($products as $product):?>
            <tr>
                <td><?php echo $product['name'];?></td>
                <td><?php echo $product['price'];?>
                </td>
                <td><div class="col-xs-3">
                    <?php echo $this->Form->hidden('Cart.update.product_id.',array('value'=>$product['id']));?>
                    <?php echo $this->Form->input('Cart.update.count.',array('type'=>'number', 'label'=>false,
                    'class'=>'form-control input-sm', 'value'=>$product->getCount()));?>
                </div></td>
                <td><?php echo $product->getTotal(); ?>
                </td>
            </tr>
            <?php $total = $total + $product->getTotal(); ?>
            <?php endforeach;?>

            <tr class="success">
                <td colspan=3></td>
                <td><?php echo $total;?>
                </td>
            </tr>
            </tbody>
        </table>

        <p class="text-right">
            <?php echo $this->Form->submit('Päivitä',array('class'=>'btn btn-warning','div'=>false));?>
            <a class="btn btn-success"
               onclick="alert('Implement a payment module for buyer to make a payment.');">CheckOut</a>
            <?= $this->Html->link('Tuhoa ostoskori','/cart/deletecart'); ?>
        </p>

    </div>
</div>
<?php echo $this->Form->end();?>