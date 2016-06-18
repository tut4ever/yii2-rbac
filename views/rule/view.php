<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\extensions\rbac\backend\models\Rule */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac/backend', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<p>
    <?= Html::a(Yii::t('rbac/backend', 'Update'), ['update', 'id' => $model->name], ['class' => 'btn btn-primary btn-flat']) ?>
    <?= Html::a(Yii::t('rbac/backend', 'Delete'), ['delete', 'id' => $model->name], [
        'class' => 'btn btn-danger btn-flat',
        'data' => [
            'confirm' => Yii::t('rbac/backend', 'Are you sure you want to delete this item?'),
            'method' => 'post',
        ],
    ]) ?>
</p>

<div class="box box-default rule-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'data:ntext',
        ],
    ]) ?>

</div>
