<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test_unit');
if (file_exists(__DIR__ . '/../../vendor/autoload.php')) {
    require_once(__DIR__ . '/../../autoload.php');
    require_once(__DIR__ . '/../../yiisoft/yii2/Yii.php');
} else {
    require_once(__DIR__ . '/../../../../autoload.php');
    require_once(__DIR__ . '/../../../../yiisoft/yii2/Yii.php');
}
