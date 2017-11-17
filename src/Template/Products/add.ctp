<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Tuotelistaus'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="products form large-9 medium-8 columns content">
    <?= $this->Form->create($product) ?>
    <fieldset>
        <legend><?= __('Lisää tuote') ?></legend>
        <?php
            echo $this->Form->control('name', ['label' => 'Nimi']);
            echo $this->Form->control('product_code', ['label' => 'Tuotekoodi']);
            echo $this->Form->control('price', ['label' => 'Hinta(opt)']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Tallenna')) ?>
    <?= $this->Form->end() ?>
</div>
