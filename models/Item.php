<?php
/**
 * Created by PhpStorm.
 * User: vuquangthinh
 * Date: 6/2/2016
 * Time: 6:17 PM
 */

namespace common\extensions\rbac\backend\models;


use common\extensions\rbac\backend\Module;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\rbac\Role;
use common\extensions\rbac\backend\models\Role as RoleModel;
use common\extensions\rbac\backend\models\Permission as PermissionModel;

/**
 * Class Item
 * @package common\extensions\rbac\backend\models
 *
 */
abstract class Item extends Model
{
    private $_old_name;

    public $name;

    public $description;

    public $data;

    protected $isNewRecord = true;

    protected $_children = [];

    public function getChildren()
    {
        return $this->_children;
    }

    public function setChildren($children)
    {
        $items = [];
        if (empty($children)) {
            $children = [];
        }

        foreach ($children as $child) {
            $items[$child] = $child;
        }

        $this->_children = $items;
    }

    public function getIsNewRecord()
    {
        return $this->isNewRecord;
    }

    /**
     * @return array
     */
    public function childrenRange()
    {
        $className = self::className();

        /**
         * @var $parent \yii\rbac\Item
         */
        $parent = $className::getItem($this->_old_name);

        $auth = Module::getInstance()->getAuthManager();

        // Cannot add a role as a child of a permission.
        $roles = strrpos($className . '#', 'Permission#') ? [] : $auth->getRoles();

        $permisisons = $auth->getPermissions();

        $items = [];
        if ($parent) {
            foreach ($roles as $role) {
                if ($auth->canAddChild($parent, $role)) {
                    $items[$role->name] = $role->name;
                }
            }

            foreach ($permisisons as $permisison) {
                if ($auth->canAddChild($parent, $permisison)) {
                    $items[$permisison->name] = $permisison->name;
                }
            }
        } else {
            foreach ($roles as $role) {
                $items[$role->name] = $role->name;
            }

            foreach ($permisisons as $permisison) {
                $items[$permisison->name] = $permisison->name;
            }
        }

        return $items;
    }

    public function getPrimaryKey($asArray = false)
    {
        if ($asArray) {
            return [$this->_old_name];
        }

        return $this->_old_name;
    }

    /**
     * @param $name
     * @return null|\yii\rbac\Item
     */
    abstract public static function getItem($name);

    /**
     * @return \yii\rbac\Item[]
     */
    abstract public static function getItems();

    /**
     * @param $name
     * @return Role|null
     */
    public static function findOne($name)
    {
        $className = self::className();
        $item = $className::getItem($name);
        if ($item) {
            $model = new $className();
            $model->_old_name = $item->name;
            $attributes = $model->attributes();
            foreach ($attributes as $attribute) {
                $model->$attribute = $item->$attribute;
            }
            $model->isNewRecord = false;

            $children = Module::getInstance()->getAuthManager()->getChildren($item->name);
            $model->children = ArrayHelper::map($children, 'name', 'name');

            return $model;
        }

        return null;
    }

    /**
     * @return Item[]
     */
    public static function find()
    {
        $className = self::className();
        $items = $className::getItems();;

        $results = [];
        foreach ($items as $item) {
            $results[] = $className::findOne($item->name);
        }

        return $results;
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'uniqueValidate'],
            [['children'], 'arrayValidate'],
            [['name', 'description', 'data'], 'string'],
        ];
    }

    public function arrayValidate($attribute, $params = [])
    {
        if (empty($this->children)) {
            $this->children = [];
        }

        if (!is_array($this->children)) {
            $this->addError($attribute, Yii::t('rbac/backend', 'Invalid children'));
        }
    }

    public function uniqueValidate($attribute, $params = [])
    {
        if ($this->name) {
            $item = $this->getItem($this->name);
            if ($item) {
                if ($this->isNewRecord || (!$this->isNewRecord && ($this->name != $this->_old_name))) {
                    $this->addError($attribute, 'Name must be unique');
                }
            }
        } else {
            $this->addError($attribute, 'Name is required');
        }
    }

    public function delete()
    {
        return Module::getInstance()->getAuthManager()->remove($this->getItem($this->_old_name));
    }

    /**
     * @param $name
     * @return null|Item
     */
    abstract protected static function createItem($name);

    public function save($runValidation = true)
    {
        if ($runValidation && !$this->validate()) {
            return false;
        }

        $result = false;
        $auth = Module::getInstance()->getAuthManager();
        $attributes = $this->attributes();
        if ($this->isNewRecord) {
            // add
            $item = $this->createItem($this->name);
            foreach ($attributes as $attribute) {
                $item->$attribute = $this->$attribute;
            }

            if ($result = $auth->add($item)) {
                $this->isNewRecord = false;
            }
        } else {
            // update
            $item = $this->getItem($this->_old_name);
            foreach ($attributes as $attribute) {
                $item->$attribute = $this->$attribute;
            }

            $result = $auth->update($this->_old_name, $item);
        }

        if ($result) {
            $this->_old_name = $item->name;

            $className = self::className();

            /**
             * @var $parent \yii\rbac\Item
             */
            $parent = $className::getItem($this->_old_name);

            if ($parent) {
                $changedChildren = $this->getChildren();
                $children = $auth->getChildren($this->_old_name);

                $current = [];
                foreach ($children as $child) {
                    if (isset($changedChildren[$child->name])) {
                        $current[$child->name] = $child->name;
                    } else {
                        // remove
                        $auth->removeChild($parent, $child);
                    }
                }

                foreach ($changedChildren as $child) {
                    if (!isset($current[$child])) {
                        // new
                        $child = self::tryGetItem($child);
                        if ($child) {
                            if ($parent->type == \yii\rbac\Item::TYPE_PERMISSION && $child->type == \yii\rbac\Item::TYPE_ROLE) {
                                // nothing
                            } else {
                                if ($auth->canAddChild($parent, $child)) {
                                    $auth->addChild($parent, $child);
                                }
                            }
                        }
                    }
                }
            }
        }


        return $result;
    }

    public static function tryGetItem($name)
    {
        $auth = Module::getInstance()->getAuthManager();
        if ($role = $auth->getRole($name)) {
            return $role;
        }

        if ($perm = $auth->getPermission($name)) {
            return $perm;
        }

        return null;
    }
}