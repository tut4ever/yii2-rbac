<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\extensions\rbac\backend\models\Permission */

$this->title = Yii::t('rbac/backend', 'Update {modelClass}: ', [
    'modelClass' => 'Permission',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac/backend', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = Yii::t('rbac/backend', 'Update');
?>
<div class="permission-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
