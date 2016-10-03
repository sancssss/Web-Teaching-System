<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<h1>作业列表</h1>
<ul>
    <?php print_r($works); ?>
<?php foreach ($works as $work): ?>
    <li>
        <?= Html::encode("{$work->twork_title} ({$work->user_number})") ?>:
        <?= $work->twork_date?>
    </li>
<?php endforeach; ?>
</ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>