<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\extensions\rbac\backend\models\Rule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box rule-form">

    <div class="box-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'class_name')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord
                ? Yii::t('rbac/backend', 'Create')
                : Yii::t('rbac/backend', 'Update'),
                ['class' => $model->isNewRecord ? 'btn btn-success btn-flat' : 'btn btn-primary btn-flat']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
