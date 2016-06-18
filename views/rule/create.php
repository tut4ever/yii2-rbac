<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\extensions\rbac\backend\models\Rule */

$this->title = Yii::t('rbac/backend', 'Create Rule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac/backend', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rule-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
