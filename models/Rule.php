<?php
/**
 * Created by PhpStorm.
 * User: vuquangthinh
 * Date: 6/2/2016
 * Time: 10:58 PM
 */

namespace common\extensions\rbac\backend\models;


use common\extensions\rbac\backend\Module;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class Rule
 * @package common\extensions\rbac\backend\models
 *
 * @property string $class_name
 * @property bool $isNewRecord
 */
class Rule extends Model
{
    private $_old_name;
    public $name;
    private $isNewRecord = true;
    private $_class_name;

    public static function range()
    {
        $rules = Module::getInstance()->getAuthManager()->getRules();
        return ArrayHelper::map($rules, 'name', 'name');
    }

    public function getClass_name()
    {
        return $this->_class_name;
    }

    public function setClass_name($value)
    {
        $this->_class_name = $value;
    }

    public function getData()
    {
        $rule = Module::getInstance()->getAuthManager()->getRule($this->_old_name);
        if ($rule) {
            return var_export($rule, 1);
        }

        return '';
    }

    public function getIsNewRecord()
    {
        return $this->isNewRecord;
    }

    public function delete()
    {
        $auth = Module::getInstance()->getAuthManager();
        if ($rule = $auth->getRule($this->_old_name)) {
            $auth->remove($rule);
        }
    }

    /**
     * @param $name
     * @return Rule|null
     */
    public static function findOne($name)
    {
        $rule = Module::getInstance()->getAuthManager()
            ->getRule($name);
        if ($rule) {
            $model = new Rule();
            $attributes = $model->attributes();
            foreach ($attributes as $attribute) {
                $model->$attribute = $rule->$attribute;
            }
            $model->_old_name = $rule->name;
            $model->_class_name = get_class($rule);
            $model->isNewRecord = false;
            return $model;
        }

        return null;
    }

    /**
     * @return Rule[]
     */
    public static function find()
    {
        $items = [];

        $rules = Module::getInstance()->getAuthManager()
            ->getRules();
        foreach ($rules as $rule) {
            $items[] = self::findOne($rule->name);
        }

        return $items;
    }

    public function rules()
    {
        return [
            [['name', 'class_name'], 'required'],
            [['name', 'class_name'], 'string'],
            ['name', 'validateName'],
            ['class_name', 'validateClassName'],
        ];
    }

    public function validateClassName($attribute, $params = [])
    {
        if (!class_exists($this->class_name)) {
            $this->addError($attribute, 'Class name is not exist');
        }
    }

    public function validateName($attribute, $params = [])
    {
        $auth = Module::getInstance()->getAuthManager();
        if ($this->name) {
            $item = $auth->getRule($this->name);
            if ($item) {
                if ($this->isNewRecord || (!$this->isNewRecord && ($this->name != $this->_old_name))) {
                    $this->addError($attribute, 'Name must be unique');
                }
            }
        } else {
            $this->addError($attribute, 'Name is required');
        }
    }

    public function save($runValidate = true)
    {
        if ($runValidate && !$this->validate()) {
            return false;
        }

        $auth = Module::getInstance()->getAuthManager();
        if ($this->isNewRecord) {
            $className = $this->class_name;
            $rule = new $className();
            $rule->name = $this->name;
            if ($auth->add($rule)) {
                $this->isNewRecord = false;
                return true;
            }
        } else {
            $rule = $auth->getRule($this->_old_name);
            $rule->name = $this->name;
            return $auth->update($this->_old_name, $rule);
        }

        return false;
    }
}