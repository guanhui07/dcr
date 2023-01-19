<?php

return [
    // 微信
    'weixin' => [
    	// 微信支付
    	'wxpay' =>[
    		'mch_id'=>'1611111',
    		'api_secret'=>'fdsf4211111111111111111',
    	],
    	// 微信公众号
    	'public' =>[
    		'app_id'=>'wxf2f211111111111111a',
    		'app_secret'=>'fdsf4211111111111111111',
    	],
    ],
    // 七牛
    'qiniu' => [
        'access_key'=>'ggVg2q11111111111111eS66A2226O',
        'secret_key'=>'fdsf4211111111111111111-Hong2Q6',
        'bucket' =>[
            'name'=>'tuigua-bucket',
            'protocol'=>'https://',
            'domain'=>'image.test.cn',
        ]
    ],
    // 阿里云
    'aliyun' => [
        'accessKeyId'=>'LT1111111113gFhz1222UT',
        'accessKeySecret'=>'4f111111111asM666D222S66',
        'signName'=>'推瓜',
        'template'=>[
            'send_code'=>'SMS_2111111219',//发送验证码
        ],
    ],
];