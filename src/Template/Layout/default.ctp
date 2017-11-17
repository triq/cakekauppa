<?php
$cakeDescription = 'Cake-kauppa: Yksinkertainen verkkokauppademo.';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('home.css') ?>
    <?= $this->Html->css('bootstrap.min.css'); ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <style>
    body {
      padding-top: 20px;
      padding-bottom: 20px;
    }

    .navbar {
      margin-bottom: 20px;
    }
    </style>

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
</head>
<body>
    <nav class="top-bar expanded" data-topbar role="navigation">
        <div class="top-bar-section">
            <ul class="right">
                <li><?= $this->Html->link('<span class="glyphicon glyphicon-shopping-cart"></span>Ostoskori <span class="badge" id="cart-counter">'.$cart_product_count.'</span>',
                    array('controller'=>'cart','action'=>'view'),array('escape'=>false));?></li>
                <li>KÄYTTÄJÄ: <b><i><?= $logged_user ? $logged_user : "ei käyttäjää" ?></i> <?= $logged_user ? $this->Html->link('kirjaudu ulos', '/admin/logout') : "" ?> </b></li>
                <li><?= $this->Html->link(__('Tuotelistaus'), '/') ?></li>
            </ul>
        </div>
    </nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?php echo $this->Html->script('bootstrap.min'); ?>
</body>
</html>
