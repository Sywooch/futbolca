<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'sourceLanguage'=>'en_US',
    'language' => 'ru',
    'charset' => 'UTF-8',
    'name' => \Yii::t('app', 'Футболки admin'),
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', '::1']
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\DbCache',
            // 'db' => 'mydb',
            // 'cacheTable' => 'my_cache',
        ],
        'cacheFile' => [
            'class' => 'yii\caching\FileCache',
        ],
        'assetManager' => [
            'bundles' => [
//                'yii\web\JqueryAsset' => [
//                    'sourcePath' => null,
//                    'js' => ['js/jquery00.js']
//                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js'=>[]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => null,
                    'css' => ['admin/css/bootstrap/bootstrap.min.css'],
                    'js' => ['admin/tinymce/bootstrap.min.js'],
                ],

            ],

        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
        ],
        'formatter' => [
            'dateFormat' => 'dd.MM.yyyy',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'USD',
        ],
        'i18n'=> [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'en_US',
                ]
            ],
        ],
        'request' => [
            'enableCsrfValidation' => false,
            'baseUrl' => '/admin/',
            'cookieValidationKey' => '0npz9bGwqKJdh6n8OAvYvCdOwuS36ovg',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'baseUrl' => '/admin/',
            'suffix' => '/',
            'rules' => [
                '/' => 'settings/index',

                [
                    'pattern' => 't/<url:.*>',
                    'route' => 'item/view',
                    'suffix' => '.html',
                ],
                [
                    'pattern' => 'preview/<url:.*>',
                    'route' => 'item/preview',
                    'suffix' => '.html',
                ],

                '<controller:\w+>/<id:\d+>/<action:(create|update|delete)>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<controller:\w+>' => '<controller>/index',
            ],
        ],
        'mail' => require_once(__DIR__.'/../../frontend/config/mail.php'),
        'db' => require_once(__DIR__.'/../../frontend/config/db.php'),
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
