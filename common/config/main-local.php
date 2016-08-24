<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=112.126.81.187;dbname=UCenter',
            'username' => 'ucroot',
            'password' => '10233201sn',
            'charset' => 'utf8',
        ],
        'card' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'sqlsrv:Server=192.168.250.226;Database=myshopcmcard',
            'username' => 'eaa',
            'password' => 'KG20131226#',
            'charset' => 'GBK',
        ],
        'stock' => [
            'class' => 'yii\db\Connection',
            'dsn' =>'sqlsrv:Server=192.168.250.11;Database=mySHOPCMStock',
            'username' => 'eas',
            'password' => 'WX201509nn@',
            'charset' => 'GBK',
        ],
        'park' => [
            'class' => 'yii\db\Connection',
            'dsn' =>'sqlsrv:Server=121.26.231.34,9000;Database=kg',
            'username' => 'sa',
            'password' => 'S@msung_w0w',
            'charset' => 'GBK',
        ],
        'cpsm' => [
            'class' => 'yii\db\Connection',
            'dsn' =>'sqlsrv:Server=192.168.11.17;Database=cpsmzsb',
            'username' => 'eas',
            'password' => 'WX201509nn@',
            'charset' => 'GBK',
        ],
        'logistics' => [
            'class' => 'yii\db\Connection',
            'dsn' =>'dblib:host=192.168.11.16;dbname=mySHOPDCStock',
            'username' => 'eas',
            'password' => 'WX201509nn@',
            'charset' => 'GBK',
        ],
//        'db' => [
//            'class' => 'yii\db\Connection',
//            'dsn' => 'mysql:host=112.126.81.187;dbname=UCenter',
//            'username' => 'ucroot',
//            'password' => '10233201sn',
//            'charset' => 'utf8',
//        ],
//        'card' => [
//            'class' => 'yii\db\Connection',
//            'dsn' => 'dblib:host=192.168.250.226;dbname=myshopcmcard',
//            'username' => 'eaa',
//            'password' => 'KG20131226#',
//            'charset' => 'GBK',
//        ],
//        'stock' => [
//            'class' => 'yii\db\Connection',
//            'dsn' =>'dblib:host=192.168.250.11;dbname=mySHOPCMStock',
//            'username' => 'eas',
//            'password' => 'WX201509nn@',
//            'charset' => 'utf8',
//        ],
//        'stock2' => [
//            'class' => 'yii\db\Connection',
//            'dsn' =>'dblib:host=192.168.250.11;dbname=mySHOPCMStock',
//            'username' => 'eaa',
//            'password' => 'K2014G0720',
//            'charset' => 'utf8',
//        ],
//        'park' => [
//            'class' => 'yii\db\Connection',
//            'dsn' =>'dblib:host=121.26.231.34:9000;dbname=kg',
//            'username' => 'sa',
//            'password' => 'S@msung_w0w',
//            'charset' => 'utf8',
//        ],
//        'cpsm' => [
//            'class' => 'yii\db\Connection',
//            'dsn' =>'dblib:host=192.168.11.17;dbname=cpsmzsb',
//            'username' => 'eas',
//            'password' => 'WX201509nn@',
//            'charset' => 'GBK',
//        ],
//        'logistics' => [
//            'class' => 'yii\db\Connection',
//            'dsn' =>'dblib:host=192.168.11.16;dbname=mySHOPDCStock',
//            'username' => 'eas',
//            'password' => 'WX201509nn@',
//            'charset' => 'GBK',
//        ],
//        'mailer' => [
//            'class' => 'yii\swiftmailer\Mailer',
//            'viewPath' => '@common/mail',
//            // send all mails to a file by default. You have to set
//            // 'useFileTransport' to false and configure a transport
//            // for the mailer to send real emails.
//            'useFileTransport' => true,
//        ],
//        'market' => [
//            'class' => 'yii\db\Connection',
//            'dsn' => 'mysql:host=218.11.132.34;dbname=kgResearch',
//            'username' => 'root',
//            'password' => '10233201sn',
//            'charset' => 'utf8',
//        ],
    ],
];
