<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Current Queue</h1>

<?php if ($current) :?>
    <ol>
    <?php foreach ($current as $c) :?>
        <?php  $args = ($c->args!=null)?' - "'.$c->args.'"':'';?>
        <li><?=$c->username . $args?></li>
    <?php endforeach;?>
    </ol>
<?php else :?>
    <p>The queue is currently empty</p>
<?php endif;?>

<h1>Top 10 Players</h1>

<ol>
<?php foreach ($top as $t) :?>
    <li><?=$t->username?> - <?=$t->play?></li>
<?php endforeach;?>
</ol>
