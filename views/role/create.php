<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\extensions\rbac\backend\models\Role */

$this->title = Yii::t('rbac/backend', 'Create Role');
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac/backend', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
