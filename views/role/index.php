<?php

use yii\helpers\Html;
use backend\widgets\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\BaseDataProvider */

$this->title = Yii::t('rbac/backend', 'Roles');
$this->params['breadcrumbs'][] = $this->title;
?>

<p>
    <?= Html::a(Yii::t('rbac/backend', 'Create Role'), ['create'], ['class' => 'btn btn-success btn-flat']) ?>
</p>


<div class="role-index">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'name',
            'description:ntext',
            'data:ntext',
            // 'created_at',
            // 'updated_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::toRoute(['role/' . $action, 'id' => $model->name]);
                }
            ],
        ],
    ]); ?>

</div>

<p>
    <?= Html::a(Yii::t('rbac/backend', 'Create Role'), ['create'], ['class' => 'btn btn-success btn-flat']) ?>
</p>
