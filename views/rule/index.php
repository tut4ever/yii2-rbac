<?php

use common\extensions\rbac\backend\models\Rule;
use yii\helpers\Html;
use backend\widgets\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ArrayDataProvider */

$this->title = Yii::t('rbac/backend', 'Rules');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
/*//
//?>
<!--<p>-->
<!--    --><?//= Html::a(Yii::t('rbac/backend', 'Create Rule'), ['create'], ['class' => 'btn btn-success btn-flat']) ?>
<!--</p>-->
*/
?>

<div class="rule-index">
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'name',
            [
                'format' => 'html',
                'attribute' => 'data',
                'value' => function(Rule $model) {
                    return Html::tag('pre', $model->data);
                },
            ],
//            [
//                'class' => 'yii\grid\ActionColumn',
//                'urlCreator' => function ($action, $model, $key, $index) {
//                    return Url::toRoute(['rule/' . $action, 'id' => $model->name]);
//                }
//            ],
        ],
    ]); ?>

</div>

<?php

/*
<p>
    <?= Html::a(Yii::t('rbac/backend', 'Create Rule'), ['create'], ['class' => 'btn btn-success btn-flat']) ?>
</p>*/

?>