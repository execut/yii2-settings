<?php

namespace execut\settings\models;

use execut\actions\widgets\DetailView;
use execut\crudFields\Behavior;
use execut\crudFields\BehaviorStub;
use execut\crudFields\fields\DetailViewField;
use execut\crudFields\fields\DropDown;
use execut\crudFields\fields\Editor;
use execut\crudFields\fields\Field;
use execut\crudFields\fields\HasOneSelect2;
use execut\crudFields\fields\Id;
use execut\crudFields\fields\reloader\Reloader;
use execut\crudFields\fields\reloader\Target;
use execut\crudFields\fields\reloader\type\Dependent;
use execut\crudFields\fields\Textarea;
use execut\crudFields\fields\Time;
use execut\crudFields\ModelsHelperTrait;
use execut\crudFields\widgets\FieldsSwitchDropdown;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "settings_settings".
 */
class Setting extends ActiveRecord
{
    const MODEL_NAME = '{n,plural,=0{Settings} =1{Setting} other{Settings}}';
    use BehaviorStub, ModelsHelperTrait;
    const TIME_ATTRIBUTE = 'value_time';
    const TYPE_ATTRIBUTE = 'type';

    const TYPE_SIMPLE = 'simple';
    const TYPE_EDITOR = 'editor';
    const TYPE_TIME = 'time';
    const ALL_TYPES = [
        self::TYPE_SIMPLE,
        self::TYPE_EDITOR,
        self::TYPE_TIME,
    ];
    public $value_editor = null;

    public static function findOrCreateByKey($key) {
        $result = self::findByKey($key);
        if (!$result) {
            $result = new static();
        }

        return $result;
    }

    protected static function getCacheKey($key) {
        return __CLASS__ . $key;
    }

    /**
     * @param $key
     * @return array|Setting|null
     */
    public static function findByKey($key)
    {
        $cache = \yii::$app->cache;
        if ($cache && ($result = $cache->get(self::getCacheKey($key)))) {
            if ($result === true) {
                return;
            }

            return $result;
        }

        $result = self::find()->byKey($key)->one();
        if (!$result) {
            $result = true;
        }

        if ($cache) {
            $cache->set(self::getCacheKey($key), $result);
        }

        if ($result === true) {
            return;
        }

        return $result;
    }

    public function afterSave($insert, $changedAttributes)
    {
        $cache = \yii::$app->cache;
        $cache->delete(self::getCacheKey($this->key));
        return parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    public function getValue()
    {
        if ($this->type === self::TYPE_TIME) {
            return $this->{self::TIME_ATTRIBUTE};
        } else {
            return $this->value;
        }
    }

    public function load($data, $formName = null)
    {
        $result = parent::load($data, $formName); // TODO: Change the autogenerated stub

        /**
         * @var Field $field
         */
        $field = $this->getField('value');
        $timeField = $this->getField(self::TIME_ATTRIBUTE);
        $timeDetailViewField = $timeField->getDetailViewField();
        if ($this->type === self::TYPE_TIME) {
            $timeDetailViewField->show();
        } else {
            $timeDetailViewField->hide();
        }

        if ($this->type === self::TYPE_SIMPLE) {
            $field->setDetailViewFieldClass(DetailViewField::class);
            $field->setFieldConfig([
                'type' => \kartik\detail\DetailView::INPUT_TEXTAREA,
            ]);
        } else if ($this->type === self::TYPE_EDITOR) {
            $field->setDetailViewFieldClass(\execut\crudFields\fields\detailViewField\Editor::class);
        } else {
            $field->getDetailViewField()->hide();
        }

        return $result;
    }

    public function behaviors()
    {
        if ($module = \yii::$app->getModule('settings')) {
            $settingsCrudFieldsPlugins = $module->getSettingsCrudFieldsPlugins();
        } else {
            $settingsCrudFieldsPlugins = [];
        }

        $typeField = new DropDown([
            'required' => true,
            'attribute' => self::TYPE_ATTRIBUTE,
            'defaultValue' => 'simple',
            'data' => $this->getTypesList(),
        ]);
        $target = new Target($typeField);
        $reloader = new Reloader(new Dependent(), [$target]);
        $fields = $this->getStandardFields(['visible', 'created', 'updated'], [
            'key' => [
                'required' => true,
                'attribute' => 'key',
            ],
            self::TYPE_ATTRIBUTE => $typeField,
            'value' => [
                'class' => Editor::class,
                'attribute' => 'value',
                'reloaders' => [$reloader],
            ],
            self::TIME_ATTRIBUTE => [
                'class' => Time::class,
                'attribute' => self::TIME_ATTRIBUTE,
                'reloaders' => [$reloader],
                'displayOnly' => false,
            ],
        ]);
        return [
            'fields' => [
                'class' => Behavior::class,
                'fields' => $fields,
                'plugins' => $settingsCrudFieldsPlugins,
            ],
            # custom behaviors
        ];
    }

    public function __toString()
    {
        return '#' . $this->id;
    }

    protected function getTypesList() {
        return [
            self::TYPE_SIMPLE => \yii::t('execut/settings', 'Simple'),
            self::TYPE_EDITOR => \yii::t('execut/settings', 'Editor'),
            self::TYPE_TIME => \yii::t('execut/settings', 'Time'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings_settings';
    }

    /**
     * @inheritdoc
     * @return \execut\settings\models\queries\SettingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \execut\settings\models\queries\SettingQuery(get_called_class());
    }
}
