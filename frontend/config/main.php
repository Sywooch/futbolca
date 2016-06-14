<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'sourceLanguage'=>'en_US',
    'language' => 'ru',
    'charset' => 'UTF-8',
    'timeZone' => 'Europe/Kiev',
    'name' => \Yii::t('app', 'Футболки'),
    'controllerNamespace' => 'frontend\controllers',
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
                    'css' => [],
                    'js' => [],
                ],

            ],

        ],
        'mail' => require_once(__DIR__.'/mail.php'),
        'formatter' => [
            'timeZone' => 'Europe/Moscow',
            'dateFormat' => 'dd.MM.yyyy',
            'datetimeFormat' => 'dd/MM/yyyy H:i:s',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => '',
        ],
        'request' => [
            'enableCsrfValidation' => true,
            'cookieValidationKey' => 'sdf#$5w543hrg()dhdSg',
            'baseUrl' => ''
        ],
        'db' => require_once(__DIR__.'/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'baseUrl' => '/',
            'suffix' => '.html',
            'rules' => [
                '' => 'site/index',
//                'about' => 'site/about',
                'contact' => 'site/contact',
                'user/registry' => 'site/signup',
                'login' => 'site/login',
                'site/requestpasswordreset' => 'site/requestpasswordreset',
                'site/reset-password' => 'site/resetpassword',

                'item/changes' => 'item/changes',

                't/<url:.*>' => 'item/view',
                't2/<url:.*>' => 'item/view2',
                'preview/<url:.*>' => 'item/preview',
                't' => 'item/index',

                'blog/<url:.*>' => 'news/view',
                'blog' => 'news/index',

                'page/<url:.*>' => 'page/view',
                'page' => 'page/index',

                'tags/<url:.*>/<page:\d+>' => 'tags/view',
                'tags/<url:.*>' => 'tags/view',
                'tags' => 'tags/index',

                'c/<url:.*>/<page:\d+>' => 'category/view',
                'c/<url:.*>' => 'category/view',
                'c' => 'category/index',

                'p/<url:.*>/<page:\d+>' => 'podcat/view',
                'p/<url:.*>' => 'podcat/view',
                'p' => 'podcat/index',

                'order/<id:\d+>' => 'user/view',
                'user/orders' => 'user/orders',

                'seach' => 'search/index',
                'individual-order' => 'individual/index',

                'user/car' => 'cart/index',

//                'img/full/<element:\w+>/<water:\w+>/<top:\d+>/<left:\d+>' => 'search/index',
                [
                    'pattern' => 'img/<type:(full|mini)>/<element:[0-9a-zA-Z\-_]+>_<water:[0-9a-zA-Z\-_]+>_<top:\d+>-<left:\d+>',
                    'route' => 'image/create',
                    'suffix' => '.jpg',
                ],
                [
                    'pattern' => 'imgpre/<type:(full|mini)>/<element:[0-9a-zA-Z\-_]+>_<water:[0-9a-zA-Z\-_]+>_<top:\d+>-<left:\d+>',
                    'route' => 'image/preview',
                    'suffix' => '.jpg',
                ],
                [
                    'pattern' => 'sitemap',
                    'route' => 'site/sitemap',
                    'suffix' => '.xml',
                ],
                [
                    'pattern' => 'yandex',
                    'route' => 'yandex/index',
                    'suffix' => '.xml',
                ],
                [
                    'pattern' => 'rss',
                    'route' => 'site/rss',
                    'suffix' => '.xml',
                ],

                '<controller:\w+>/<id:\d+>/<action:(create|update|delete)>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<controller:\w+>' => '<controller>/index',
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
        ],
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
