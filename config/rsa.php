<?php
return [
    /**
     * 默认客户端
     */
    'client' => env('RSA_CLIENT', 'default'),

    /**
     * 客户端
     */
    'clients' => [

        'default' => [
            /*
             |--------------------------------------------------------------------------
             | Public Key
             |--------------------------------------------------------------------------
             |
             | 文件名，文件路径：file://path/to/storage/
             |
             | E.g. 'rsa-public.key'
             |
             */
            'public' => env('RSA_PUBLIC_KEY', 'rsa-public.key'),

            /*
             |--------------------------------------------------------------------------
             | Private Key
             |--------------------------------------------------------------------------
             |
             | 文件名，文件路径：file://path/to/storage/
             |
             | E.g. 'rsa-private.key'
             |
             */
            'private' => env('RSA_PRIVATE_KEY', 'rsa-private.key'),

            /*
             |--------------------------------------------------------------------------
             | Passphrase
             |--------------------------------------------------------------------------
             |
             | The passphrase for your private key. Can be null if none set.
             |
             */
            'passphrase' => env('RSA_PASSPHRASE'),

            /**
             * [1-OPENSSL_PKCS1_PADDING, 2-OPENSSL_SSLV23_PADDING, 3-OPENSSL_NO_PADDING]
             */
            'encryptionMode' => env('RSA_ENCRYPTION_MODE', 1),

            /**
             * [1-OPENSSL_ALGO_SHA1, 2-OPENSSL_ALGO_MD5]
             */
            'signatureMode' => env('RSA_SIGNATURE_MODE', 1),
        ],

        'api' => [
            /**
             * 密码加密
             * 包括登录时传的密码，新增和修改时传的密码
             */
            'enable' => [
                'password' => env('RSA_API_ENABLE_PASSWORD', false)
            ],

            /*
             |--------------------------------------------------------------------------
             | Public Key
             |--------------------------------------------------------------------------
             |
             | 文件名，文件路径：file://path/to/storage/
             |
             | E.g. 'rsa-public.key'
             |
             */
            'public' => env('RSA_API_PUBLIC_KEY', 'rsa-api-public.key'),

            /*
             |--------------------------------------------------------------------------
             | Private Key
             |--------------------------------------------------------------------------
             |
             | 文件名，文件路径：file://path/to/storage/
             |
             | E.g. 'rsa-private.key'
             |
             */
            'private' => env('RSA_API_PRIVATE_KEY', 'rsa-api-private.key'),

            /*
             |--------------------------------------------------------------------------
             | Passphrase
             |--------------------------------------------------------------------------
             |
             | The passphrase for your private key. Can be null if none set.
             |
             */
            'passphrase' => env('RSA_API_PASSPHRASE'),

            /**
             * [1-OPENSSL_PKCS1_PADDING, 2-OPENSSL_SSLV23_PADDING, 3-OPENSSL_NO_PADDING]
             */
            'encryptionMode' => env('RSA_API_ENCRYPTION_MODE', 1),

            /**
             * [1-OPENSSL_ALGO_SHA1, 2-OPENSSL_ALGO_MD5]
             */
            'signatureMode' => env('RSA_API_SIGNATURE_MODE', 1),
        ],

        'backend' => [
            /**
             * 密码加密
             * 包括登录时传的密码，新增和修改时传的密码
             */
            'enable' => [
                'password' => env('RSA_BACKEND_ENABLE_PASSWORD', false)
            ],

            /*
             |--------------------------------------------------------------------------
             | Public Key
             |--------------------------------------------------------------------------
             |
             | 文件名，文件路径：file://path/to/storage/
             |
             | E.g. 'rsa-public.key'
             |
             */
            'public' => env('RSA_BACKEND_PUBLIC_KEY', 'rsa-backend-public.key'),

            /*
             |--------------------------------------------------------------------------
             | Private Key
             |--------------------------------------------------------------------------
             |
             | 文件名，文件路径：file://path/to/storage/
             |
             | E.g. 'rsa-private.key'
             |
             */
            'private' => env('RSA_BACKEND_PRIVATE_KEY', 'rsa-backend-private.key'),

            /*
             |--------------------------------------------------------------------------
             | Passphrase
             |--------------------------------------------------------------------------
             |
             | The passphrase for your private key. Can be null if none set.
             |
             */
            'passphrase' => env('RSA_BACKEND_PASSPHRASE'),

            /**
             * [1-OPENSSL_PKCS1_PADDING, 2-OPENSSL_SSLV23_PADDING, 3-OPENSSL_NO_PADDING]
             */
            'encryptionMode' => env('RSA_BACKEND_ENCRYPTION_MODE', 1),

            /**
             * [1-OPENSSL_ALGO_SHA1, 2-OPENSSL_ALGO_MD5]
             */
            'signatureMode' => env('RSA_BACKEND_SIGNATURE_MODE', 1),
        ],

        'frontend' => [
            /**
             * 密码加密
             * 包括登录时传的密码，新增和修改时传的密码
             */
            'enable' => [
                'password' => env('RSA_FRONTEND_ENABLE_PASSWORD', false)
            ],

            /*
             |--------------------------------------------------------------------------
             | Public Key
             |--------------------------------------------------------------------------
             |
             | 文件名，文件路径：file://path/to/storage/
             |
             | E.g. 'rsa-public.key'
             |
             */
            'public' => env('RSA_FRONTEND_PUBLIC_KEY', 'rsa-frontend-public.key'),

            /*
             |--------------------------------------------------------------------------
             | Private Key
             |--------------------------------------------------------------------------
             |
             | 文件名，文件路径：file://path/to/storage/
             |
             | E.g. 'rsa-private.key'
             |
             */
            'private' => env('RSA_FRONTEND_PRIVATE_KEY', 'rsa-frontend-private.key'),

            /*
             |--------------------------------------------------------------------------
             | Passphrase
             |--------------------------------------------------------------------------
             |
             | The passphrase for your private key. Can be null if none set.
             |
             */
            'passphrase' => env('RSA_FRONTEND_PASSPHRASE'),

            /**
             * [1-OPENSSL_PKCS1_PADDING, 2-OPENSSL_SSLV23_PADDING, 3-OPENSSL_NO_PADDING]
             */
            'encryptionMode' => env('RSA_FRONTEND_ENCRYPTION_MODE', 1),

            /**
             * [1-OPENSSL_ALGO_SHA1, 2-OPENSSL_ALGO_MD5]
             */
            'signatureMode' => env('RSA_FRONTEND_SIGNATURE_MODE', 1),
        ]

        // 更多客户端
    ],
];
