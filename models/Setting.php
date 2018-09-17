<?php

namespace execut\settings\models;

use execut\crudFields\Behavior;
use execut\crudFields\BehaviorStub;
use execut\crudFields\fields\Id;
use execut\crudFields\fields\Textarea;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "settings_settings".
 */
class Setting extends ActiveRecord
{
    const MODEL_NAME = '{n,plural,=0{Settings} =1{Setting} other{Settings}}';
    use BehaviorStub;

    public static function findOrCreateByKey($key) {
        $result = self::find()->byKey($key)->one();
        if (!$result) {
            $result = new static();
        }

        return $result;
    }

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'fields' => [
                    'class' => Behavior::class,
                    'fields' => [
                        [
                            'class' => Id::class,
                            'attribute' => 'id',
                        ],
                        [
                            'required' => true,
                            'attribute' => 'name',
                        ],
                        [
                            'required' => true,
                            'attribute' => 'key',
                        ],
                        [
                            'class' => Textarea::class,
                            'attribute' => 'value',
                        ],
                    ],
                    'plugins' => \yii::$app->getModule('settings')->getSettingsCrudFieldsPlugins(),
                ],
                # custom behaviors
            ]
        );
    }

    public function __toString()
    {
        return '#' . $this->id;
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
