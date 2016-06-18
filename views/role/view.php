<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\extensions\rbac\backend\models\Role */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac/backend', 'Roles'), 'url' => ['index']];
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

<div class="box box-default role-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'description:ntext',
            'data:ntext',
            [
                'format' => 'html',
                'attribute' => 'children',
                'value' => implode(', ', array_map(function ($item) use ($model) {
                    $item = $model->tryGetItem($item);
                    if (!$item) {
                        return '';
                    }

                    return Html::a($item->name,
                        ['/' . ($item->type==$item::TYPE_ROLE ? 'role' : 'permission') . '/default/view',
                        'id' => $item->name]);
                }, $model->children)),
            ],
//            'created_at:datetime',
//            'updated_at:datetime',
        ],
    ]) ?>

</div>
