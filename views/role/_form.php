<?php

use common\extensions\rbac\backend\models\Role;
use common\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\extensions\rbac\backend\models\Role */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-md-8">

        <div class="box role-form">

            <div class="box-body">
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>
                
                <?= $form->field($model, 'children')->widget(Select2::className(), [
                    'value' => $model->children, // initial value
                    'showToggleAll' => false,
                    'data' => $model->childrenRange(),
                    'options' => [
                        'multiple' => true
                    ],
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('rbac/backend', 'Create') : Yii::t('rbac/backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success btn-flat' : 'btn btn-primary btn-flat']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>

        </div>

    </div>
</div>
