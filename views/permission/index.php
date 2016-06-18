<?php

use yii\helpers\Html;
use backend\widgets\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\BaseDataProvider */

$this->title = Yii::t('rbac/backend', 'Permissions');
$this->params['breadcrumbs'][] = $this->title;
?>

<p>
    <?= Html::a(Yii::t('rbac/backend', 'Create Permission'), ['create'], ['class' => 'btn btn-success btn-flat']) ?>
</p>


<div class="permission-index">


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
                    return Url::toRoute(['permission/' . $action, 'id' => $model->name]);
                }
            ],
        ],
    ]); ?>

</div>

<p>
    <?= Html::a(Yii::t('rbac/backend', 'Create Permission'), ['create'], ['class' => 'btn btn-success btn-flat']) ?>
</p>
