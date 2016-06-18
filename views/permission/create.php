<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\extensions\rbac\backend\models\Permission */

$this->title = Yii::t('rbac/backend', 'Create Permission');
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac/backend', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
