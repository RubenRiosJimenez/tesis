<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'name' => 'Fondos Municipales',
    'basePath' => dirname(__DIR__),
    'language'=>'es', // Este es el lenguaje en el que querés que muestre las cosas
    'sourceLanguage'=>'es',
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
        'name' => '_backendUser', // unique for backend
        'path'=>'/backend/web'  // correct path for the backend app.
    ]
],
'session' => [
    'name' => '_backendSessionId', // unique for backend
    'savePath' => __DIR__ . '/../runtime', // a temporary folder on backend
],
        
        'view' => [
        'theme' => [
            'pathMap' => [
                '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
            ],
        ],
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
        'modules' => [
       'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ]
    ],

];
