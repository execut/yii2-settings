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
            $result = Setting::findByKey($key);
            if ($result) {
                $result = $result->value;
            } else if (isset($this->defaultSettings[$key])) {
                $result = $this->defaultSettings[$key];
            } else if ($defaultValue !== null) {
                $result = $defaultValue;
            }

            $replacedParams = [];
            foreach ($params as $paramKey => $param) {
                $replacedParams['{' . $paramKey . '}'] = $param;
            }

            $result = strtr($result, $replacedParams);
            if ($key === 'search_catalog_message') {
                $result = $this->replaceTemplate($result, $params);
            }
            $this->cache[$key] = $result;
        }

        return $this->cache[$key];
    }

    protected function replaceTemplate($template, $models) {
        $parts = explode('{', $template);
        $result = '';
        foreach ($parts as $part) {
            if (strpos($part, '}') !== false) {
                $subPart = explode('}', $part);
                $modelKeyParts = explode('.', $subPart[0]);
                $modelKey = $modelKeyParts[0];
                if (!empty($models[$modelKey])) {
                    $model = $models[$modelKey];
                    unset($modelKeyParts[0]);
                    $result .= $this->extractAttributeValue(implode('.', $modelKeyParts), $model);
                }

                $result .= $subPart[1];
            } else {
                $result .= $part;
            }
        }

        return $result;
    }

    protected function extractAttributeValue($attribute, $model) {
        try {
            return ArrayHelper::getValue($model, $attribute);
        } catch (\Exception $e) {
            return '';
        }
    }
}