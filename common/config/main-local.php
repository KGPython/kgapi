<?php
return [
    'components' => [
//            'db' => [
//            'class' => 'yii\db\Connection',
//            'dsn' => 'mysql:host=localhost;dbname=yii2advanced',
//            'username' => 'root',
//            'password' => 'root',
//            'charset' => 'utf8',
//            ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=112.126.81.187;dbname=UCenter',
            'username' => 'ucroot',
            'password' => '10233201sn',
            'charset' => 'utf8',
        ],
        'mssql' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'sqlsrv:Server=192.168.250.226;Database=myshopcmcard', 
            'username' => 'eaa',
            'password' => 'KG20131226#',
            'charset' => 'utf8',
        ],
        'stock' => [
            'class' => 'yii\db\Connection',
            'dsn' =>'sqlsrv:Server=192.168.250.11;Database=mySHOPCMStock',
            'username' => 'eas',
            'password' => 'WX201509nn@',
            'charset' => 'utf8',
        ],
        'cpsm' => [
            'class' => 'yii\db\Connection',
            'dsn' =>'sqlsrv:Server=192.168.11.17;Database=cpsmzsb',
            'username' => 'eas',
            'password' => 'WX201509nn@',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
