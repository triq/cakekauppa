<?php
use Cake\Core\Configure;
//$this->layout = false;

$cakeDescription = 'Cake-kauppa.';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>
    </title>

    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->script('my.js') ?> 
</head>
<body class="home">

<header class="row">
    <div class="header-image">Cake-kauppa</div>
    <div class="header-title">
        <h1>Cake-kauppa: Verkkokauppademo. Myymme puhelimia ja kaikkea. </h1>
    </div>
</header>

<div class="row">
    <h3>Tuotteita (WIP: 5 tuotetta esille random) </h3>
    <div class="columns large-6">
        <h3>Getting Started</h3>
        <ul>
            <li class="bullet book"><a target="_blank" href="https://book.cakephp.org/3.0/en/">CakePHP 3.0 Docs</a></li>
            <li class="bullet book"><a target="_blank" href="https://book.cakephp.org/3.0/en/tutorials-and-examples/bookmarks/intro.html">The 15 min Bookmarker Tutorial</a></li>
            <li class="bullet book"><a target="_blank" href="https://book.cakephp.org/3.0/en/tutorials-and-examples/blog/blog.html">The 15 min Blog Tutorial</a></li>
        </ul>
        <p>
    </div>
</div>


</body>
</html>
