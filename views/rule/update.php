<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\extensions\rbac\backend\models\Rule */

$this->title = Yii::t('rbac/backend', 'Update {modelClass}: ', [
    'modelClass' => 'Rule',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac/backend', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = Yii::t('rbac/backend', 'Update');
?>
<div class="rule-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
