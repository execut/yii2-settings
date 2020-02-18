<?php
$params = [];
return [
    'id' => 'app-test',
    'basePath' => __DIR__ . '/../',
    'vendorPath' => __DIR__ . '/../../../../',
    'bootstrap' => [],
    'modules' => [],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'assetManager' => [
            'basePath' => __DIR__ . '/../assets/',
            'bundles' => [
                \detalika\search\widgets\UniqueNumbersListAsset::class => [
                    'depends' => [],
                ],
                \detalika\goods\widgets\ArticlesListAsset::class => [
                    'depends' => [],
                ]
            ]
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                ],
            ]
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => getenv('DB_DSN'),
            'username' => getenv('DB_USER'),
            'password' => getenv('DB_PASSWORD'),
            'charset' => 'utf8',
            'enableSchemaCache' => true,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    'params' => $params,
];
