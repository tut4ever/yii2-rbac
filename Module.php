<?php
/**
 * Created by PhpStorm.
 * User: vuquangthinh
 * Date: 6/2/2016
 * Time: 5:46 PM
 */

namespace quangthinh\yii\rbac;


use Yii;
use yii\rbac\ManagerInterface;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'quangthinh\yii\rbac\controllers';
    public $defaultRoute = 'role/index';

    private $_authManager = 'authManager';

    public function setAuthManager($value)
    {
        $this->_authManager = $value;
    }

    /**
     * @return null|ManagerInterface|string
     * @throws \yii\base\InvalidConfigException
     */
    public function getAuthManager()
    {
        if (is_string($this->_authManager)) {
            $this->_authManager = Yii::$app->get($this->_authManager);
        }

        return $this->_authManager;
    }

    public function findIdentity($id) {
        /**
         * @var $class IdentityInterface
         */
        $class = Yii::$app->user->identityClass;
        return $class::findIdentity($id);
    }
}