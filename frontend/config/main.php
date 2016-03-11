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
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
//            'transport' => [
//                'class' => 'Swift_SmtpTransport',
//                'host' => 'smtp.yandex.ru',
//                'username' => 'php-shaman',
//                'password' => '12microsoft12',
//                'port' => '465',
//                'encryption' => 'ssl',
//            ],
        ],
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
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=futbolend',
            'username' => 'futbolend',
            'password' => 'fdgfg546DHBGScz',
            'charset' => 'utf8',
            'tablePrefix' => 'fl_',
            'enableSchemaCache' => true,
            // Duration of schema cache.
            'schemaCacheDuration' => 3600,
            // Name of the cache component used to store schema information
            'schemaCache' => 'cacheFile',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'baseUrl' => '/',
            'suffix' => '.html',
            'rules' => [
                '' => 'site/index',
                'about' => 'site/about',
                'contact' => 'site/contact',
                'user/registry' => 'site/signup',
                'login' => 'site/login',
                'site/requestpasswordreset' => 'site/requestpasswordreset',
                'site/reset-password' => 'site/resetpassword',

                'item/changes' => 'item/changes',

                't/<url:.*>' => 'item/view',
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

                'seach' => 'search/index',
                'individual-order' => 'individual/index',

//                'img/full/<element:\w+>/<water:\w+>/<top:\d+>/<left:\d+>' => 'search/index',
                [
                    'pattern' => 'img/<type:(full|mini)>/<element:\w+>/<water:\w+>/<top:\d+>/<left:\d+>',
                    'route' => 'image/create',
                    'suffix' => '.jpg',
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
