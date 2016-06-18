<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\extensions\rbac\backend\models\Role */

$this->title = Yii::t('rbac/backend', 'Update {modelClass}: ', [
    'modelClass' => 'Role',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac/backend', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = Yii::t('rbac/backend', 'Update');
?>
<div class="role-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
