<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'dcGVodOOzgkavel6G2Fhp1TGb456sPmv',
        ],
        /*
        'view' => [
             'theme' => [
                 'pathMap' => [
                    '@app/views' => '@administracion_general/themes/yii2-inv'
                 ],
             ],
        ],
         * */
        
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    'allowedIPs' => ['127.0.0.1','localhost','172.16.*','172.16.1.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}
return $config;
