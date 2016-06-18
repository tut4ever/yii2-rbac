<?php
/**
 * Created by PhpStorm.
 * User: vuquangthinh
 * Date: 6/2/2016
 * Time: 7:16 PM
 */

namespace common\extensions\rbac\backend\models;


use common\extensions\rbac\backend\Module;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * Class Role
 * @package common\extensions\rbac\backend\models
 *
 * @property bool $isNewRecord
 */
class Role extends Item
{
    /**
     * @param $name
     * @return null|\yii\rbac\Item
     */
    public static function getItem($name)
    {
        return Module::getInstance()->getAuthManager()->getRole($name);
    }

    /**
     * @return \yii\rbac\Item[]
     */
    public static function getItems()
    {
        return Module::getInstance()->getAuthManager()->getRoles();
    }

    /**
     * @param $name
     * @return null|Item
     */
    protected static function createItem($name)
    {
        return Module::getInstance()->getAuthManager()->createRole($name);
    }
}