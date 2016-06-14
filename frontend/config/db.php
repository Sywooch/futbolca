<?php
/**
 * powered by php-shaman
 * db.php 10.06.2016
 * NewFutbolca
 */

if((isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] == '127.0.0.1') || mb_substr_count(__DIR__, '1newfulbolca.ru', 'UTF-8') > 0){
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=futbolca',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'tablePrefix' => 'fl_',
        'enableSchemaCache' => true,
        // Duration of schema cache.
        'schemaCacheDuration' => 5,
        // Name of the cache component used to store schema information
        'schemaCache' => 'cacheFile',
    ];
}

return [
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
];
