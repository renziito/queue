<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Current Queue</h1>

<?php if ($current) :?>
    <ul>
    <?php foreach ($current as $c) :?>
        <?php Utils::show($c);?>
        <li></li>
    <?php endforeach;?>
    </ul>
<?php else :?>
    <p>The queue is currently empty</p>
<?php endif;?>

<h1>Top 10 Players</h1>

<ol>
<?php foreach ($top as $t) :?>
    <li><?=$t->username?> - <?=$t->play?></li>
<?php endforeach;?>
</ol>
