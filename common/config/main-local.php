<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2advanced', // 修改为你的数据库名
            'username' => 'root',                               // 数据库用户名
            'password' => 'Agao113311',                             // 数据库密码
            'charset' => 'utf8',                                // 字符集
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,                         // 是否启用邮件发送
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'site/anime-movies' => 'site/anime-movies',
                'site/sci-fi-movies' => 'site/sci-fi-movies',
                'site/popular-movies' => 'site/popular-movies',
            ],
        ],

    ],
];
