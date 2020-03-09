<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name ." - Queue";
?>
<div class="container h-100">
<div class="row h-100 justify-content-center align-items-center">
    <div class="logo"><img src="https://www.neonpuddles.com/assets/images/np-75.png"></div>
    <div class="container-fluid container-fixed-lg sm-p-l-10 sm-p-r-10">
        <h1>Current Queue</h1>
        <?php if ($current) : ?>
            <ol>
                <?php foreach ($current as $c) : ?>
                    <?php $args = ($c->args != null) ? ' - "' . $c->args . '"' : ''; ?>
                    <li><?= $c->username . $args ?></li>
                <?php endforeach; ?>
            </ol>
        <?php else : ?>
            <p>The queue is currently empty</p>
        <?php endif; ?>

        <h2>Top 10 - Most Games Played</h2>
        <ol>
            <?php foreach ($top as $t) : ?>
                <li><?= $t->username ?> - <?= $t->play ?></li>
            <?php endforeach; ?>
        </ol>
    </div>
</div>
</div>