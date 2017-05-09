<?php

namespace execut\settings\models;

use execut\crudFields\Behavior;
use execut\crudFields\BehaviorStub;
use execut\crudFields\fields\Id;
use Yii;
use \execut\settings\models\base\Setting as BaseSetting;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "settings_settings".
 */
class Setting extends BaseSetting
{
    use BehaviorStub;
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
                            'required' => true,
                            'attribute' => 'value',
                        ],
                    ]
                ],
                # custom behaviors
            ]
        );
    }
}
