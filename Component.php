<?php
/**
 */

namespace execut\settings;


use execut\settings\models\Setting;

class Component extends \yii\base\Component
{
    protected $cache = [];
    public $defaultSettings = [
        'company-name' => 'eXeCUT CMS',
    ];
    public function get($key) {
        if (!isset($this->cache[$key])) {
            $result = Setting::find()->byKey($key)->one();
            if ($result) {
                $result = $result->value;
            } else if (isset($this->defaultSettings[$key])) {
                $result = $this->defaultSettings[$key];
            }

            $this->cache[$key] = $result;
        }

        return $this->cache[$key];
    }
}