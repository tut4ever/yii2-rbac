<?php
/**
 * Created by PhpStorm.
 * User: vuquangthinh
 * Date: 6/3/2016
 * Time: 8:21 AM
 */

use backend\widgets\GridView;
use common\assets\ICheckAsset;
use common\extensions\rbac\backend\Module;
use yii\grid\CheckboxColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\rbac\Role;

/**
 * @var $this \yii\web\View
 * @var $user \common\extensions\user\models\User
 * @var $dataProvider \yii\data\BaseDataProvider
 */
$this->title = Yii::t('rbac/backend', 'Assignment {modelClass}: ', [
        'modelClass' => 'User',
    ]) . ' ' . $user->name;

$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac/backend', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->name, 'url' => ['view', 'id' => $formModel->id]];
$this->params['breadcrumbs'][] = Yii::t('rbac/backend', 'Assignment');


ICheckAsset::register($this);

$ajaxUrl = Url::to(['update', 'id' => $user->id]);
$this->registerJs(<<<RQ
$("input.icheck").iCheck({"checkboxClass":"icheckbox_square-blue","radioClass":"iradio_square-blue","increaseArea":"20%"});
$("input.icheck").on("ifToggled", function(e) {
    var \$el = $(this);
    $.ajax({
        url: "{$ajaxUrl}",
        data: {role: \$el.val()},
        type: "POST",
        success: function(resp) {
            if (!resp) {
                \$el.iCheck('toggle')                
            }
        }
    });
});
RQ
);

?>

<p>
    <?= Html::a(Yii::t('user/backend', 'View'), ['/user/default/view', 'id' => $user->id], ['class' => 'btn btn-primary btn-flat']) ?>
    <?= Html::a(Yii::t('user/backend', 'Authentication'), ['/auth/view', 'id' => $user->id], ['class' => 'btn btn-default btn-flat']) ?>
</p>

<div class="assign-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => CheckboxColumn::className(),
                'header' => '',
                'checkboxOptions' => function (Role $model, $key, $index, $column) use ($user) {
                    $auth = Module::getInstance()->getAuthManager();
                    return [
                        'checked' => $auth->getAssignment($model->name, $user->id) !== null,
                        'class' => 'icheck',
                    ];
                },
            ],
            'name:ntext',
            'description:ntext',
        ],
    ]); ?>
</div>
