<?php
return [
    'name' => 'spacev.vn',
    'charset' => 'UTF-8',
    'language' => 'vi-VN',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => [
            // database config
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=spa1068d_spacevdb',
            'username' => 'spa1068d_spacev',
            'password' => 'sdf$%#$fhxvj34',

            'charset' => 'utf8',
            'enableSchemaCache' => true,
            // Duration of schema cache.
            'schemaCacheDuration' => 3600,
            // Name of the cache component used to store schema information
            'schemaCache' => 'cache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                //'host' => 'localhost',
                'host' => 'smtp.gmail.com', // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => 'mail.vienthong@gmail.com',
                'password' => 'wmkbcpzgxkcmjefd',
                'port' => '465', // Port 25 is a very common port too
                'encryption' => 'ssl',
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache',
        ],
    ],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'userClassName' => 'common\models\User',
                    'idField' => 'id', // id field of model User
                ]
            ],
        ]
    ],    
];
