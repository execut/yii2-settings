<?php
/**
 */

namespace execut\settings;


use execut\settings\models\Setting;
use yii\helpers\ArrayHelper;

class Component extends \yii\base\Component
{
    protected $cache = [];
    public $defaultSettings = [
        'company-name' => 'eXeCUT CMS',
    ];
    public function get($key, $defaultValue = null, $params = []) {
        if (!isset($this->cache[$key])) {
            $result = Setting::find()->byKey($key)->one();
            if ($result) {
                $result = $result->value;
            } else if (isset($this->defaultSettings[$key])) {
                $result = $this->defaultSettings[$key];
            } else if ($defaultValue !== null) {
                $result = $defaultValue;
            }

            $replacedParams = [];
            foreach ($params as $key => $param) {
                $replacedParams['{' . $key . '}'] = $param;
            }

            $result = strtr($result, $replacedParams);
            $this->cache[$key] = $result;
        }

        return $this->cache[$key];
    }
}