<?php
/**
 * Created by PhpStorm.
 * User: vuquangthinh
 * Date: 6/2/2016
 * Time: 6:09 PM
 */

namespace quangthinh\yii\rbac\controllers;


use quangthinh\yii\rbac\Module;
use Yii;
use yii\base\Exception;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\rbac\Assignment;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class AssignController extends Controller
{
    public function actions()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($id)
    {
        $user = Module::getInstance()->findIdentity($id);
        if ($user) {
            throw new NotFoundHttpException('Người dùng không tồn tại hoặc bị khóa');
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => Module::getInstance()->getAuthManager()
                ->getRoles(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'user' => $user,
        ]);
    }

    public function actionUpdate($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request;
        $role_name = $request->post('role', null);

        if ($role_name == null) {
            throw new NotFoundHttpException();
        }

        if ($user = Module::getInstance()->findIdentity($id)) {
            $auth = Module::getInstance()->getAuthManager();
            $role = $auth->getRole($role_name);

            if ($role) {
                $assignment = $auth->getAssignment($role_name, $id);

                if ($assignment) {
                    return $auth->revoke($role, $id);
                } else {
                    try {
                        return $auth->assign($role, $id);
                    } catch (\Exception $e) {
                    }
                    return false;
                }
            }
        }

        throw new NotFoundHttpException();
    }
}